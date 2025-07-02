<div class="modal fade" id="addAnggota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah Anggota</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('Kelola_Anggota.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Kolom Kiri --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_saksi" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_saksi" class="form-control" placeholder="Masukkan nama lengkap" required>
                            </div>

                            <div class="mb-3">
                                <label for="nik_saksi" class="form-label">NIK</label>
                                <input type="text" name="nik_saksi" class="form-control" placeholder="16 digit NIK" maxlength="16" required>
                            </div>

                            <div class="mb-3">
                                <label for="tempat_lahir_saksi" class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir_saksi" class="form-control" placeholder="Contoh: Jakarta" required>
                            </div>

                            <div class="mb-3">
                                <label for="tgl_lahir_saksi" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir_saksi" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="alamat_saksi" class="form-label">Alamat</label>
                                <textarea name="alamat_saksi" class="form-control" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_telepon_saksi" class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="text" name="no_telepon_saksi" class="form-control" placeholder="8xxxxxxxxxx" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" name="NIP" class="form-control" placeholder="Masukkan NIP" required>
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewFoto(this)">
                                <div class="mt-2">
                                    <img id="preview-image" src="https://via.placeholder.com/100" alt="Preview" class="img-thumbnail" width="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
