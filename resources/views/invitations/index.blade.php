@extends('layouts.app')

@section('content')
  <div class="card">
    <div class="card-head">
      <h1>Daftar Undangan</h1>
      <p class="muted">Riwayat undangan yang sudah dibuat.</p>
    </div>

    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>Nomor</th>
            <th>Hal</th>
            <th>Tanggal Acara</th>
            <th>Penerima</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($invitations as $inv)
            <tr>
              <td style="font-family:ui-monospace,Consolas,monospace;">{{ $inv->letter_number }}</td>
              <td>{{ $inv->hal ?? '-' }}</td>
              <td>{{ $inv->event_date?->translatedFormat('d F Y') }}</td>
              <td>{{ $inv->recipients_count }}</td>
              <td>
                <a class="btn btn-ghost" href="{{ route('invitations.show',$inv) }}">Detail</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5">Belum ada undangan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
