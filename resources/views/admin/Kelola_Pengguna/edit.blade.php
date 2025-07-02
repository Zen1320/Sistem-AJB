<div class="modal fade" id="EditPengguna" tabindex="-1" aria-labelledby="EditTimLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="EditTimLabel">Form Edit Pengguna</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST') {{-- akan diubah via JS --}}
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Kolom Kiri --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" id="edit_nama" class="form-control" placeholder="Masukkan nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea name="alamat" id="edit_alamat" class="form-control" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_tlp" class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="text" name="nomor_tlp" id="edit_nomor_telp" class="form-control" placeholder="8xxxxxxxxxx" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="edit_role" class="form-select" required>
                                    <option value="" disabled selected>Pilih role</option>
                                    <option value="1">Staff</option>
                                    <option value="0">Super Admin</option>
                                </select>
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" name="email" id="edit_email" class="form-control" placeholder="email@contoh.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="edit_passsword" class="form-control" placeholder="Isi Password" >
                                <span class="text-muted">*Kosongkan jika tidak ingin dirubah</span>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewFoto(this)">
                                <span class="text-muted">*Kosongkan jika tidak ingin dirubah</span>
                                <div class="mt-2">
                                    <img id="preview-image" src="https://via.placeholder.com/100" alt="Preview" class="img-thumbnail" width="100">
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
