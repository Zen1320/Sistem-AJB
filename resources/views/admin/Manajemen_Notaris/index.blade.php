@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Manajemen Pengajuan</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <h4>Daftar Pengajuan AJB </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-hover table-sales">
                                    <table class="table table-bordered table-striped"id="example">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Nama Pengaju</th>
                                                <th>Jenis Transaksi</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                                <th>Tanggal Akad</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{$item->created_at}}</td>
                                                <td>{{$item->user->name}}</td>
                                                <td>{{$item->jenis->nama_jenis }}</td>
                                                <td>{!!status_badge($item->status)!!}</td>
                                                <td>{{$item->keterangan ?? "-"}}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_akad)->locale('id')->translatedFormat('l, d F Y H:i') }} WIB</td>
                                                <td class="text-center">
                                                    @if($item->status == '0')
                                                        <a href="{{route('Manajemen_PengajuanAJB.detail', $item->id)}}" class="btn btn-sm btn-info">Verifikasi Berkas</a>
                                                    @elseif($item->status == '1')
                                                        <a href="{{route('Manajemen_PengajuanAJB.detail', $item->id)}}" class="btn btn-sm btn-info">Cek Revisi</a>
                                                    @else
                                                        <a href="{{route('Manajemen_PengajuanAJB.detail', $item->id)}}" class="btn btn-sm btn-info">Detail</a>
                                                        @if($item->status == '3')
                                                            <a href="{{ asset('storage/' . $item->file_Akta) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                Cek Akta
                                                            </a>
                                                        @endif
                                                    @endif
                                                    @if($item->status == '2')
                                                       <a href="{{route('Manajemen_PengajuanAJB.detail', $item->id)}}" class="btn btn-sm btn-warning">Cetak Surat Akta</a>
                                                        <button onclick="bukaModalUploadAkta({{ $item->id }})" class="btn btn-sm btn-success">
                                                            Upload Akta
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.Kelola_JenisTransaksi.add')
@include('admin.Kelola_JenisTransaksi.edit')

<div class="modal fade" id="uploadAktaModal" tabindex="-1" aria-labelledby="uploadAktaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formUploadAkta" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="uploadAktaModalLabel">Upload Akta yang Sudah Ditandatangani</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="file_akta" class="form-label">Pilih File Akta (PDF)</label>
                    <input type="file" name="file_akta" id="file_akta" class="form-control" accept=".pdf" required>
                </div>
                <small class="text-muted">Pastikan dokumen telah ditandatangani semua pihak terkait.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    function editJenisTransaksi(id) {
        $.ajax({
            url: `/Kelola_JenisTransaksi/${id}/edit`,
            type: 'GET',
            success: function (data) {
                // Set form action
                const form = document.getElementById('editForm');
                form.action = `/Kelola_JenisTransaksi/${data.id}/update`;
                form.method = 'POST';
                document.getElementById('edit_nama').value = data.nama_jenis;

                $('#EditTimLapangan').modal('show');
            },
            error: function () {
                alert('Gagal mengambil data.');
            }
        });
    }
    function bukaModalUploadAkta(id) {
        const form = document.getElementById('formUploadAkta');
        form.action = `/Manajemen_PengajuanAJB/${id}/upload-akta`;
        $('#uploadAktaModal').modal('show');
    }
</script>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            responsive: true,
            lengthMenu: [5, 10, 25, 50, 100],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Selanjutnya"
                },
                zeroRecords: "Data tidak ditemukan",
                infoEmpty: "Tidak ada data yang ditampilkan",
                infoFiltered: "(difilter dari _MAX_ total data)"
            }
        });
    });
</script>
@endpush
@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

