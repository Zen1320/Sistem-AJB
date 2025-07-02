@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Kelola Pengguna</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <h4>Daftar Kelola Pengguna </h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPengguna">
                            Tambah Kelola Pengguna
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-hover table-sales">
                                    <table class="table table-bordered"id="example">
                                        <thead class="table-secondary text-center">
                                            <tr>
                                                <th style="width: 5%;">No</th>
                                                <th>Foto</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>No. Telepon</th>
                                                <th>Alamat</th>
                                                <th>Role</th>
                                                <th style="width: 18%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pengguna as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-center">
                                                    <img src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('panel/assets/img/profile.png') }}"
                                                        alt="Foto Pengguna"
                                                        width="50" height="50"
                                                        class="rounded-circle shadow-sm border border-secondary">
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->no_telp }}</td>
                                                <td>{{ $item->alamat }}</td>
                                                <td>
                                                    @switch($item->role)
                                                        @case(0)
                                                            <span class="badge bg-danger">Super Admin</span>
                                                            @break
                                                        @case(1)
                                                            <span class="badge bg-primary">Staff</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary">Tidak Diketahui</span>
                                                    @endswitch
                                                </td>
                                                <td class="text-center">
                                                    <button type="button"
                                                    class="btn btn-warning btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#EditPengguna"
                                                    onclick="editPengguna({{ $item->id }})">
                                                    Edit
                                                    </button>
                                                    @method('DELETE')
                                                    <a href="{{route('Kelola_JenisTransaksi.Destroy', $item->id)}}" class="btn btn-sm btn-danger" data-confirm-delete="true">Hapus</a>
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
@include('admin.Kelola_Pengguna.add')
@include('admin.Kelola_Pengguna.edit')
@endsection

@push('scripts')
<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
function previewFoto(input) {
    const preview = document.getElementById('preview-image');
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = "https://via.placeholder.com/100";
    }
}
</script>

<script>
    function editPengguna(id) {
        $.ajax({
            url: `/Kelola_Pengguna/${id}/edit`,
            type: 'GET',
            success: function (data) {
                // Set form action
                const form = document.getElementById('editForm');
                form.action = `/Kelola_Pengguna/${data.id}/update`;
                form.method = 'POST';
                document.getElementById('edit_nama').value = data.name;
                document.getElementById('edit_alamat').value = data.alamat;
                document.getElementById('edit_nomor_telp').value = data.no_telp;
                document.getElementById('edit_role').value = data.role;
                document.getElementById('edit_email').value = data.email;

                $('#EditPengguna').modal('show');
            },
            error: function () {
                alert('Gagal mengambil data.');
            }
        });
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

