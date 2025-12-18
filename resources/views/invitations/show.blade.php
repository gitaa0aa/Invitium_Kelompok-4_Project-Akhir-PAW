@extends('layouts.app')

@section('content')
  <div class="card">
    <div class="card-head">
      <h1>Detail Undangan</h1>
      <p class="muted">Nomor: <span style="font-family:ui-monospace,Consolas,monospace;">{{ $invitation->letter_number }}</span></p>
    </div>

    <div class="card-body">
      <div class="grid">
        <div>
          <div class="notice">
            <div><b>Hal:</b> {{ $invitation->hal ?? '-' }}</div>
            <div><b>Lampiran:</b> {{ $invitation->lampiran_text ?? '-' }}</div>
            <div><b>Tanggal acara:</b> {{ $invitation->event_date?->translatedFormat('d F Y') }}</div>
            <div><b>Waktu:</b> {{ $invitation->event_time }}</div>
            <div><b>Tempat:</b> {{ $invitation->event_place }}</div>
          </div>
        </div>

        <div>
          <div class="notice">
            <div><b>File kop:</b> {{ $invitation->kop_path ? 'Ada' : 'Tidak ada' }}</div>
            <div><b>Lampiran file:</b> {{ $invitation->attachments->count() }}</div>
            <div><b>TTD:</b> {{ $invitation->signatures->count() }}</div>
          </div>
        </div>
      </div>

      <div style="height:18px;"></div>

      <h2 class="section-title">Penerima</h2>

      @foreach ($invitation->recipients as $recipient)
        <div style="padding:16px 0;border-bottom:1px solid rgba(121,87,87,.12);">
          <strong>{{ $recipient->name }}</strong><br>
          {{ $recipient->position }}
          @if($recipient->affiliation)
            — {{ $recipient->affiliation }}
          @endif
          @if($recipient->email)
            <div class="muted" style="margin-top:4px;">{{ $recipient->email }}</div>
          @endif

          <div style="margin-top:10px; display:flex; gap:10px; flex-wrap:wrap;">
            <a class="btn btn-ghost" href="{{ route('invitations.print', [$invitation, $recipient]) }}">
              Cetak PDF
            </a>

            <button type="button" class="btn btn-primary" onclick="openSendModal('{{ e($recipient->name) }}')">
              Kirim
            </button>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  {{-- MODAL --}}
  <div id="sendBackdrop" class="modal-backdrop">
    <div class="modal">
      <h3>📨 Berhasil Terkirim</h3>
      <p id="sendText">Undangan berhasil dikirim.</p>
      <button class="btn btn-primary" onclick="closeSendModal()">OK</button>
    </div>
  </div>

  <script>
    function openSendModal(name){
      document.getElementById('sendText').innerText = 'Undangan untuk ' + name + ' berhasil dikirim.';
      document.getElementById('sendBackdrop').style.display = 'flex';
    }
    function closeSendModal(){
      document.getElementById('sendBackdrop').style.display = 'none';
    }
  </script>
@endsection
