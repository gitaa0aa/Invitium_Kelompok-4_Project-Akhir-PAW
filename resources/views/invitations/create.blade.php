@extends('layouts.app')

@section('content')
  <div class="card">
    <div class="card-head">
      <h1>Invitium — Buat Undangan</h1>
      <p class="muted">Isi Form 1 (Undangan) → lanjut Form 2 (Penerima).</p>

      <div class="pill-tabs">
        <button type="button" id="tab1" class="tab active" onclick="showTab(1)">Form 1 — Data Undangan</button>
        <button type="button" id="tab2" class="tab" onclick="showTab(2)">Form 2 — Penerima</button>
      </div>
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('invitations.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- TAB 1 --}}
        <div id="pane1">
          <h2 class="section-title">Form 1 — Data Undangan</h2>

          <div class="grid">
            <div>
              <label>Kop Surat (jpg/png)</label>
              <input type="file" name="kop" accept=".jpg,.jpeg,.png">
              <p class="muted" style="margin-top:8px;">Akan ditempatkan otomatis di bagian atas surat saat PDF.</p>
            </div>

            <div class="grid grid-1">
              <div class="grid">
                <div>
                  <label>Hal</label>
                  <input type="text" name="hal" value="{{ old('hal') }}" placeholder="Contoh: Undangan Rapat Koordinasi">
                </div>
                <div>
                  <label>Lampiran (teks)</label>
                  <input type="text" name="lampiran_text" value="{{ old('lampiran_text') }}" placeholder="Contoh: 1 (satu) berkas">
                </div>
              </div>

              <div>
                <label>Lampiran Files (opsional)</label>
                <input type="file" name="lampiran_files[]" multiple>
              </div>
            </div>
          </div>

          <div style="height:16px;"></div>

          <div>
            <label>Isi / Deskripsi Surat</label>
            <textarea name="description" placeholder="Isi surat undangan...">{{ old('description') }}</textarea>
          </div>

          <div style="height:16px;"></div>

          <div class="grid">
            <div>
              <label>Tanggal Acara</label>
              <input type="date" name="event_date" value="{{ old('event_date') }}">
            </div>
            <div>
              <label>Waktu</label>
              <input type="text" name="event_time" value="{{ old('event_time') }}" placeholder="Contoh: 09.00 - 12.00 WIB">
            </div>
          </div>

          <div style="height:16px;"></div>

          <div>
            <label>Tempat</label>
            <input type="text" name="event_place" value="{{ old('event_place') }}" placeholder="Contoh: GKM 4.1">
          </div>

          <div style="height:22px;"></div>

          <h2 class="section-title">Penandatangan (TTD)</h2>
          <p class="muted" style="margin-top:-6px;">Bisa lebih dari 2. Jika isi jabatan/nama/NIP maka file TTD wajib.</p>

          <div id="signersWrap"></div>

          <div class="row-actions">
            <button type="button" class="btn btn-ghost" onclick="addSigner()">＋ Tambah Penandatangan</button>
            <button type="button" class="btn btn-primary" onclick="showTab(2)">Lanjut Form 2 →</button>
          </div>
        </div>

        {{-- TAB 2 --}}
        <div id="pane2" class="hidden">
          <h2 class="section-title">Form 2 — Penerima</h2>
          <p class="muted" style="margin-top:-6px;">Penerima bisa lebih dari 1, PDF dicetak terpisah per orang.</p>

          <div id="recipientsWrap"></div>

          <div class="row-actions">
            <button type="button" class="btn btn-ghost" onclick="addRecipient()">＋ Tambah Penerima</button>
            <button type="button" class="btn btn-ghost" onclick="showTab(1)">← Kembali Form 1</button>
            <button type="submit" class="btn btn-primary">Simpan Undangan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    function showTab(n){
      const p1 = document.getElementById('pane1');
      const p2 = document.getElementById('pane2');
      const t1 = document.getElementById('tab1');
      const t2 = document.getElementById('tab2');

      if(n === 1){
        p1.classList.remove('hidden');
        p2.classList.add('hidden');
        t1.classList.add('active');
        t2.classList.remove('active');
      }else{
        p2.classList.remove('hidden');
        p1.classList.add('hidden');
        t2.classList.add('active');
        t1.classList.remove('active');
      }
      window.scrollTo({top:0, behavior:'smooth'});
    }

    let signerIndex = 0;
    function addSigner(){
      const wrap = document.getElementById('signersWrap');

      const box = document.createElement('div');
      box.className = 'card';
      box.style.marginTop = '14px';
      box.style.borderRadius = '18px';
      box.style.boxShadow = '0 12px 30px rgba(121,87,87,.08)';

      box.innerHTML = `
        <div class="card-body">
          <div class="grid">
            <div>
              <label>Jabatan</label>
              <input type="text" name="signers[${signerIndex}][position]" placeholder="Contoh: Wakil Dekan II">
            </div>
            <div>
              <label>Nama</label>
              <input type="text" name="signers[${signerIndex}][name]" placeholder="Contoh: Salsa">
            </div>
          </div>

          <div style="height:12px;"></div>

          <div class="grid">
            <div>
              <label>NIP/NIM</label>
              <input type="text" name="signers[${signerIndex}][identity]" placeholder="Contoh: 1234567890">
            </div>
            <div>
              <label>File TTD (png/jpg)</label>
              <input type="file" name="signers[${signerIndex}][file]" accept=".png,.jpg,.jpeg">
            </div>
          </div>
        </div>
      `;

      wrap.appendChild(box);
      signerIndex++;
    }

    let recipientIndex = 0;
    function addRecipient(){
      const wrap = document.getElementById('recipientsWrap');

      const box = document.createElement('div');
      box.className = 'card';
      box.style.marginTop = '14px';
      box.style.borderRadius = '18px';
      box.style.boxShadow = '0 12px 30px rgba(121,87,87,.08)';

      box.innerHTML = `
        <div class="card-body">
          <div class="grid">
            <div>
              <label>Nama Penerima</label>
              <input type="text" name="recipients[${recipientIndex}][name]" placeholder="Contoh: Salsa, Ph.D" required>
            </div>
            <div>
              <label>Email</label>
              <input type="email" name="recipients[${recipientIndex}][email]" placeholder="Contoh: salsa@gmail.com">
            </div>
          </div>

          <div style="height:12px;"></div>

          <div class="grid">
            <div>
              <label>Jabatan</label>
              <input type="text" name="recipients[${recipientIndex}][position]" placeholder="Contoh: Kepala Departemen Sistem Informasi">
            </div>
            <div>
              <label>Afiliasi</label>
              <input type="text" name="recipients[${recipientIndex}][affiliation]" placeholder="Contoh: Fakultas Ilmu Komputer, Universitas Brawijaya">
            </div>
          </div>
        </div>
      `;

      wrap.appendChild(box);
      recipientIndex++;
    }

    // init default 2 signer, 2 recipient biar enak
    addSigner();
    addSigner();
    addRecipient();
    addRecipient();
  </script>
@endsection
