<!-- Modal Detail Masyarakat -->
<div class="modal fade" id="modalDetailMasyarakat" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="modalDetailLabel">Detail Masyarakat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-4 text-center">
            <img id="detail_foto" src="{{ asset('storage/default.jpg') }}" class="img-fluid rounded border" style="max-height: 200px;" alt="Foto Masyarakat">
          </div>
          <div class="col-md-8">
            <table class="table table-sm table-bordered">
              <tbody>
                <tr>
                  <th>Nama</th>
                  <td id="detail_nama">-</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td id="detail_email">-</td>
                </tr>
                <tr>
                  <th>NIK</th>
                  <td id="detail_nik">-</td>
                </tr>
                <tr>
                  <th>No. Telepon</th>
                  <td id="detail_no_telp">-</td>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <td id="detail_alamat">-</td>
                </tr>
                <tr>
                  <th>File KTP</th>
                  <td><a id="detail_file_ktp" href="#" target="_blank">Lihat KTP</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
