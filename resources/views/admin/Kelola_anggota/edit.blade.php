<div class="modal fade" id="EditAnggota" tabindex="-1" aria-labelledby="EditTimLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="EditTimLabel">Form Edit Anggota Saksi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_id">

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Kolom Kiri --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_nama_saksi" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_saksi" id="edit_nama_saksi" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_nik_saksi" class="form-label">NIK</label>
                                <input type="text" name="nik_saksi" id="edit_nik_saksi" class="form-control" maxlength="16" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_tempat_lahir_saksi" class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir_saksi" id="edit_tempat_lahir_saksi" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_tgl_lahir_saksi" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir_saksi" id="edit_tgl_lahir_saksi" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_alamat_saksi" class="form-label">Alamat</label>
                                <textarea name="alamat_saksi" id="edit_alamat_saksi" class="form-control" rows="2" required></textarea>
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_no_telepon_saksi" class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="text" name="no_telepon_saksi" id="edit_no_telepon_saksi" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_nip" class="form-label">NIP</label>
                                <input type="text" name="nip" id="edit_nip" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_foto" class="form-label">Foto</label>
                                <input type="file" name="foto" id="edit_foto" class="form-control" accept="image/*" onchange="previewFotoEdit(this)">
                                <span class="text-muted">* Kosongkan Bila Tidak Ingin Dirubah</span>
                                <div class="mt-2">
                                    <img id="preview-image-edit" src="https://placehold.co/100x100" class="img-thumbnail" width="100">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
