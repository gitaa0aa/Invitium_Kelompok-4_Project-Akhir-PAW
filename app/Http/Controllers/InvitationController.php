<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = Invitation::withCount('recipients')
            ->latest()
            ->get();

        return view('invitations.index', compact('invitations'));
    }

    public function create()
    {
        return view('invitations.create');
    }

    public function show(Invitation $invitation)
    {
        $invitation->load(['recipients', 'attachments', 'signatures']);
        return view('invitations.show', compact('invitation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kop' => 'nullable|file|mimes:jpg,jpeg,png|max:4096',
            'hal' => 'nullable|string|max:255',
            'lampiran_text' => 'nullable|string|max:255',
            'lampiran_files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:8192',

            'description' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'required|string|max:100',
            'event_place' => 'required|string|max:255',

            'signers' => 'nullable|array',
            'signers.*.position' => 'nullable|string|max:255',
            'signers.*.name' => 'nullable|string|max:255',
            'signers.*.identity' => 'nullable|string|max:255',
            'signers.*.file' => 'nullable|file|mimes:png,jpg,jpeg|max:4096',

            'recipients' => 'required|array|min:1',
            'recipients.*.name' => 'required|string|max:255',
            'recipients.*.email' => 'nullable|email|max:255',
            'recipients.*.position' => 'nullable|string|max:255',
            'recipients.*.affiliation' => 'nullable|string|max:255',
        ]);

        if (is_array($request->signers)) {
            foreach ($request->signers as $idx => $s) {
                $filled = !empty($s['name']) || !empty($s['position']) || !empty($s['identity']);
                if ($filled && !$request->hasFile("signers.$idx.file")) {
                    return back()
                        ->withInput()
                        ->withErrors(["signers.$idx.file" => "File TTD wajib diupload untuk penandatangan ke-" . ($idx + 1)]);
                }
            }
        }

        return DB::transaction(function () use ($request) {

            $today = Carbon::now();
            $romanMonth = $this->toRoman((int) $today->format('m'));

            $prefix = "INV/%/INVITIUM/{$romanMonth}/{$today->format('Y')}";
            $last = Invitation::where('letter_number', 'like', $prefix)
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            $nextSeq = 1;
            if ($last) {
                $parts = explode('/', $last->letter_number);
                if (count($parts) >= 2 && is_numeric($parts[1])) {
                    $nextSeq = ((int)$parts[1]) + 1;
                }
            }

            $letterNumber = sprintf(
                "INV/%03d/INVITIUM/%s/%s",
                $nextSeq,
                $romanMonth,
                $today->format('Y')
            );

            $kopPath = null;
            if ($request->hasFile('kop')) {
                $kopPath = $request->file('kop')->store('invitium/kop', 'public');
            }

            $invitation = Invitation::create([
                'letter_number' => $letterNumber,
                'letter_date'   => $today->toDateString(),
                'hal'           => $request->hal,
                'lampiran_text' => $request->lampiran_text,
                'kop_path'      => $kopPath,
                'description'   => $request->description,
                'event_date'    => $request->event_date,
                'event_time'    => $request->event_time,
                'event_place'   => $request->event_place,
            ]);

            if ($request->hasFile('lampiran_files')) {
                foreach ($request->file('lampiran_files') as $file) {
                    if (!$file) continue;

                    $path = $file->store('invitium/lampiran', 'public');

                    $invitation->attachments()->create([
                        'file_path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                    ]);
                }
            }

            if (is_array($request->signers)) {
                foreach ($request->signers as $idx => $s) {
                    $filled = !empty($s['name']) || !empty($s['position']) || !empty($s['identity']);
                    if (!$filled) continue;

                    $path = $request->file("signers.$idx.file")->store('invitium/signatures', 'public');

                    $invitation->signatures()->create([
                        'file_path'       => $path,
                        'signer_position' => $s['position'] ?? null,
                        'signer_name'     => $s['name'] ?? null,
                        'signer_identity' => $s['identity'] ?? null,
                    ]);
                }
            }

            foreach ($request->recipients as $r) {
                $invitation->recipients()->create([
                    'name' => $r['name'],
                    'email' => $r['email'] ?? null,
                    'position' => $r['position'] ?? null,
                    'affiliation' => $r['affiliation'] ?? null,
                ]);
            }

            return redirect()->route('invitations.show', $invitation);
        });
    }

    public function print(Invitation $invitation, Recipient $recipient)
    {
        abort_unless($recipient->invitation_id === $invitation->id, 404);

        $invitation->load(['attachments', 'signatures']);

        $pdf = Pdf::loadView('invitations.print', [
            'invitation' => $invitation,
            'recipient'  => $recipient,
        ])->setPaper('A4', 'portrait');

        $safeLetter = str_replace(['/', '\\'], '-', $invitation->letter_number);
        $safeName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $recipient->name);

        return $pdf->download("Invitium_{$safeLetter}_{$safeName}.pdf");
    }

    private function toRoman(int $month): string
    {
        $map = [
            1  => 'I',  2  => 'II', 3  => 'III', 4  => 'IV',
            5  => 'V',  6  => 'VI', 7  => 'VII', 8  => 'VIII',
            9  => 'IX', 10 => 'X',  11 => 'XI',  12 => 'XII',
        ];
        return $map[$month] ?? 'I';
    }
}
