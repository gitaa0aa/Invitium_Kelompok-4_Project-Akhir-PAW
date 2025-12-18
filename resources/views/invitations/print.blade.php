<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <style>
    @page { margin: 30px 40px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color:#111; }
    .kop img { width: 100%; max-height: 120px; object-fit: contain; }
    .row { width:100%; }
    .left { float:left; width:70%; }
    .right { float:right; width:30%; text-align:right; }
    .clear { clear:both; }
    .meta { margin-top: 14px; }
    .meta table { width:100%; border-collapse: collapse; }
    .meta td { padding: 3px 0; vertical-align: top; }
    .line { border-top: 1px solid #111; margin: 10px 0 18px; }
    .recipient { margin-top: 6px; }
    .content { margin-top: 14px; line-height: 1.6; text-align: justify; }
    .agenda { margin-top: 16px; }
    .agenda table { margin-left: 30px; border-collapse: collapse; }
    .agenda td { padding: 4px 10px 4px 0; }

    .sign-wrap { margin-top: 30px; }
    .sign-row-2 { width:100%; }
    .sign-col { width: 48%; display:inline-block; vertical-align: top; }
    .sign-col.right { float:right; text-align:center; }
    .sign-col.left  { float:left; text-align:center; }
    .sign-one { width:100%; text-align:right; }
    .sign-grid { width:100%; }
    .grid-item { width: 30%; display:inline-block; margin: 0 1.5% 20px 0; text-align:center; vertical-align: top; }

    .sign-pos { font-weight:700; margin-bottom: 8px; }
    .sign-img { height: 80px; margin-bottom: 8px; }
    .sign-img img { height: 80px; width:auto; }
    .sign-name { font-weight:700; }
    .sign-id { margin-top: 2px; }

    .attach-title { text-align:center; font-size: 14px; font-weight:700; margin-bottom: 14px; }
    .attach-box { margin-bottom: 18px; text-align:center; }
    .attach-box img { max-width: 100%; max-height: 740px; }
  </style>
</head>
<body style="background:#fff;">

  {{-- KOP --}}
  <div class="kop">
    @if($invitation->kop_path)
      <img src="{{ public_path('storage/'.$invitation->kop_path) }}" alt="Kop">
    @endif
  </div>

  <div class="row meta">
    <div class="left">
      <table>
        <tr>
          <td style="width:70px;">Nomor</td>
          <td style="width:10px;">:</td>
          <td>{{ $invitation->letter_number }}</td>
        </tr>
        <tr>
          <td>Lampiran</td>
          <td>:</td>
          <td>{{ $invitation->lampiran_text ?? '-' }}</td>
        </tr>
        <tr>
          <td>Hal</td>
          <td>:</td>
          <td>{{ $invitation->hal ?? '-' }}</td>
        </tr>
      </table>
    </div>

    <div class="right">
      {{ $invitation->letter_date?->translatedFormat('d F Y') }}
    </div>
    <div class="clear"></div>
  </div>

  <div class="line"></div>

  {{-- PENERIMA --}}
  <div class="recipient">
    <div>Yth.</div>
    <div style="font-weight:700; margin-top:4px;">{{ $recipient->name }}</div>
    @if($recipient->position)
      <div style="margin-top:2px;">{{ $recipient->position }}</div>
    @endif
    @if($recipient->affiliation)
      <div style="margin-top:2px;">{{ $recipient->affiliation }}</div>
    @endif
    <div style="margin-top:2px;">di Tempat</div>
  </div>

  <div class="content">
    <p>Dengan hormat,</p>
    <p>{{ $invitation->description }}</p>

    <p>Sehubungan dengan hal tersebut, kami mengundang Bapak/Ibu untuk hadir pada:</p>

    <div class="agenda">
      @php
        $hari = $invitation->event_date?->translatedFormat('l');
        $tgl  = $invitation->event_date?->translatedFormat('d F Y');
      @endphp

      <table>
        <tr>
          <td style="width:140px;">Hari, Tanggal</td>
          <td style="width:10px;">:</td>
          <td>{{ $hari }}, {{ $tgl }}</td>
        </tr>
        <tr>
          <td>Waktu</td>
          <td>:</td>
          <td>{{ $invitation->event_time }}</td>
        </tr>
        <tr>
          <td>Tempat</td>
          <td>:</td>
          <td>{{ $invitation->event_place }}</td>
        </tr>
      </table>
    </div>

    <p>Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Bapak/Ibu, kami ucapkan terima kasih.</p>
  </div>

  {{-- TTD --}}
  @php
    $signers = $invitation->signatures;
    $count = $signers->count();
  @endphp

  <div class="sign-wrap">
    @if($count === 1)
      {{-- 1 TTD di kanan --}}
      <div class="sign-one">
        @php $s = $signers[0]; @endphp
        <div style="width:260px; display:inline-block; text-align:center;">
          <div class="sign-pos">{{ $s->signer_position }}</div>
          <div class="sign-img">
            <img src="{{ public_path('storage/'.$s->file_path) }}" alt="ttd">
          </div>
          <div class="sign-name">{{ $s->signer_name }}</div>
          @if($s->signer_identity)
            <div class="sign-id">{{ $s->signer_identity }}</div>
          @endif
        </div>
      </div>

    @elseif($count === 2)
      {{-- 2 TTD sejajar kiri-kanan --}}
      <div class="sign-row-2">
        @php $s1 = $signers[0]; $s2 = $signers[1]; @endphp

        <div class="sign-col left">
          <div class="sign-pos">{{ $s1->signer_position }}</div>
          <div class="sign-img">
            <img src="{{ public_path('storage/'.$s1->file_path) }}" alt="ttd">
          </div>
          <div class="sign-name">{{ $s1->signer_name }}</div>
          @if($s1->signer_identity)
            <div class="sign-id">{{ $s1->signer_identity }}</div>
          @endif
        </div>

        <div class="sign-col right">
          <div class="sign-pos">{{ $s2->signer_position }}</div>
          <div class="sign-img">
            <img src="{{ public_path('storage/'.$s2->file_path) }}" alt="ttd">
          </div>
          <div class="sign-name">{{ $s2->signer_name }}</div>
          @if($s2->signer_identity)
            <div class="sign-id">{{ $s2->signer_identity }}</div>
          @endif
        </div>

        <div class="clear"></div>
      </div>

    @elseif($count > 2)
      {{-- >2 TTD grid --}}
      <div class="sign-grid">
        @foreach($signers as $s)
          <div class="grid-item">
            <div class="sign-pos">{{ $s->signer_position }}</div>
            <div class="sign-img">
              <img src="{{ public_path('storage/'.$s->file_path) }}" alt="ttd">
            </div>
            <div class="sign-name">{{ $s->signer_name }}</div>
            @if($s->signer_identity)
              <div class="sign-id">{{ $s->signer_identity }}</div>
            @endif
          </div>
        @endforeach
      </div>
    @endif
  </div>

  {{-- LAMPIRAN PAGE --}}
  @if($invitation->attachments->count())
    <div style="page-break-before:always;"></div>
    <div class="attach-title">Lampiran</div>

    @foreach($invitation->attachments as $att)
      @php
        $path = public_path('storage/'.$att->file_path);
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
      @endphp

      <div class="attach-box">
        <div style="font-weight:700; margin-bottom:10px;">{{ $att->original_name }}</div>

        @if(in_array($ext, ['jpg','jpeg','png']))
          <img src="{{ $path }}" alt="lampiran">
        @else
          <div style="font-size:12px; color:#333;">
            Lampiran non-gambar tidak bisa dirender di DomPDF.<br>
            File terlampir: <b>{{ $att->original_name }}</b>
          </div>
        @endif
      </div>
    @endforeach
  @endif

</body>
</html>
