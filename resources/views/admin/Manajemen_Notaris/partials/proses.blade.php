<div class="modal fade" id="prosesModal" tabindex="-1" aria-labelledby="prosesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prosesModalLabel">Proses Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Manajemen_PengajuanAJB.proses', $id_pengajuan) }}" method="POST">
            @csrf
            <div class="modal-body">
                    <div class="mb-3">
                        <label for="saksiNotaris" class="form-label">Nama Saksi Notaris</label>
                        <select class="form-select" id="saksiNotaris" name="saksi_notaris" required>
                            <option value="" selected disabled>Pilih Saksi</option>
                            @foreach($saksi as $saksiItem)
                                <option value="{{ $saksiItem->id }}">{{ $saksiItem->nip }} - {{ $saksiItem->nama_saksi }}</option>
                            @endforeach
                        </select>
                        <div class="form-text text-muted">*(NIP - NAMA ) Pilih saksi yang akan hadir dalam proses
                    </div>
                    <div class="mb-3">
                        <label for="tanggalAkadProses" class="form-label">Tanggal Akad/Proses</label>
                        <input type="date" class="form-control" id="tanggalAkadProses" name="tanggal_akad_proses">
                    </div>
                    <div class="mb-3">
                        <label for="waktuAkadProses" class="form-label">Waktu Akad/Proses</label>
                        <input type="time" class="form-control" id="waktuAkadProses" name="waktu_akad_proses" required>
                         <div class="form-text text-muted">*(AM = Pagi, PM = Malam) <br>Pilih waktu untuk hadir dalam proses akad. Pastikan waktu yang dipilih sesuai dengan jadwal yang telah disepakati.</div>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>
