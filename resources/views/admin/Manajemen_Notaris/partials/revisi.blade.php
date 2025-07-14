<div class="modal fade" id="revisiModal" tabindex="-1" aria-labelledby="revisiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="revisiModalLabel">Revisi Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('Manajemen_PengajuanAJB.revisi', ['id' => $id_pengajuan]) }}" method="POST">
                @csrf
                <div class="modal-body">
                        <div class="mb-3">
                            <label for="keteranganRevisi" class="form-label">Keterangan Revisi</label>
                            <textarea class="form-control" id="keteranganRevisi" name="keterangan_revisi" rows="4" required></textarea>
                            <div class="form-text text-muted">Mohon tuliskan keterangan yang jelas mengenai revisi yang diperlukan.</div>
                        </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Kirim Revisi</button>
            </div>
            </form>
        </div>
    </div>
</div>
