@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Kelola Jenis Transaksi</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <h4>Daftar Jenis Transaksi </h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAnggota">
                            Tambah Jenis Transaksi
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-hover table-sales">
                                    <table class="table table-bordered table-striped"id="example">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 5%;">No</th>
                                                <th scope="col">Foto</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">NIP</th>
                                                <th scope="col">NIK</th>
                                                <th scope="col">No. Telepon</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col" class="text-center" style="width: 20%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($anggotaSaksi as $index => $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($item->foto)
                                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Saksi" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <img src="" class="img-thumbnail" alt="No Foto">
                                                    @endif
                                                </td>
                                                <td>{{ $item->nama_saksi }}</td>
                                                <td>{{ $item->NIP }}</td>
                                                <td>{{ $item->nik_saksi }}</td>
                                                <td>+62{{ $item->no_telepon_saksi }}</td>
                                                <td>{{ $item->alamat_saksi }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-warning" onclick="editAnggota({{ $item->id }})">
                                                        Edit
                                                    </button>
                                                     @method('DELETE')
                                                    <a href="{{route('Kelola_Anggota.Destroy', $item->id)}}" class="btn btn-sm btn-danger" data-confirm-delete="true">Hapus</a>
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
@include('admin.Kelola_anggota.add')
@include('admin.Kelola_anggota.edit')
@endsection

@push('scripts')
<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    function editAnggota(id) {
    $.ajax({
        url: `/Kelola_Anggota/${id}/edit`,
        type: 'GET',
        success: function (data) {
            console.log(data);
            const form = document.getElementById('editForm');
            form.action = `/Kelola_Anggota/${data.id}/update`;
            form.querySelector('input[name="_method"]').value = 'PUT';

            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_nama_saksi').value = data.nama_saksi;
            document.getElementById('edit_nik_saksi').value = data.nik_saksi;
            document.getElementById('edit_tempat_lahir_saksi').value = data.tempat_lahir_saksi;
            document.getElementById('edit_tgl_lahir_saksi').value = data.tgl_lahir_saksi;
            document.getElementById('edit_alamat_saksi').value = data.alamat_saksi;
            document.getElementById('edit_no_telepon_saksi').value = data.no_telepon_saksi;
            document.getElementById('edit_nip').value = data.NIP;

            const img = document.getElementById('preview-image');
            img.src = '';
            if (data.foto) {
                img.src = `/storage/${data.foto}`;
            } else {
                img.src = 'https://placehold.co/600x400';
            }


            $('#EditAnggota').modal('show');
        },
        error: function () {
            alert('Gagal mengambil data.');
        }
    });
}

</script>

<script>
    function previewFoto(input) {
        const preview = document.getElementById('preview-image');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = 'https://via.placeholder.com/100';
        }
    }
     function previewFotoEdit(input) {
        const preview = document.getElementById('preview-image-edit');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = 'https://placehold.co/100x100';
        }
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

