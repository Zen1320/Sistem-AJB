@extends('layouts.app')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Kelola Masyarakat</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <h4>Daftar Akun Masyarakat </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-hover table-sales">
                                    <table class="table table-bordered table-striped"id="example">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">No</th>
                                                <th>Foto</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>No. Telepon</th>
                                                <th class="text-center">Status</th>
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
                                                <td>
                                                    <form action="{{ route('Kelola_Masyarakat.update', $item->id) }}" method="POST" onsubmit="return confirm('Ubah status user ini?')">
                                                        @csrf
                                                        @method('PUT')
                                                       <button
                                                        type="button"
                                                        class="btn btn-sm {{ $item->status == 1 ? 'btn-success' : 'btn-secondary' }}"
                                                        onclick="konfirmasiUbahStatus({{ $item->id }}, '{{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}')"
                                                                                        >
                                                        {{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                                    </button>
                                                    </form>
                                                </td>
                                                <td class="text-center align-middle">
                                                    @if($item->status == 1)
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-primary d-inline-flex align-items-center justify-content-center"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalDetailMasyarakat"
                                                            onclick="detailmasyarakat({{ $item->id }})">
                                                            <i class="fas fa-eye me-1"></i> Detail
                                                        </button>
                                                    @else
                                                        <span class="badge bg-secondary text-white">Belum Diverifikasi</span>
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
@include('admin.kelola_masyarakat.detail')
@endsection

@push('scripts')
<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiUbahStatus(id, statusSekarang) {
        Swal.fire({
            title: 'Ubah Status Pengguna?',
            text: `Status saat ini: ${statusSekarang}. Ingin mengubahnya?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, ubah',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form lewat POST ke route update
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/Kelola_Masyarakat/${id}/update`;

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'PUT';
                form.appendChild(method);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

<script>
    function detailmasyarakat(id) {
        $.ajax({
            url: `/Kelola_Masyarakat/${id}/detail`,
            type: 'GET',
            success: function (data) {
                console.log(data);
                // Text detail
                document.getElementById('detail_nama').innerText = data.name ?? '-';
                document.getElementById('detail_email').innerText = data.email ?? '-';
                document.getElementById('detail_nik').innerText = data.nik ?? '-';
                document.getElementById('detail_no_telp').innerText = data.no_telp ?? '-';
                document.getElementById('detail_alamat').innerText = data.alamat ?? '-';

                if (data.foto) {
                    document.getElementById('detail_foto').src = `/storage/${data.foto}`;
                } else {
                    document.getElementById('detail_foto').src = `/storage/default.jpg`;
                }

                if (data.file_ktp) {
                    const link = document.getElementById('detail_file_ktp');
                    link.href = `/storage/${data.file_ktp}`;
                    link.innerText = 'Lihat File KTP';
                } else {
                    const link = document.getElementById('detail_file_ktp');
                    link.href = '#';
                    link.innerText = 'Tidak ada file';
                }

                // Tampilkan modal
                $('#modalDetailMasyarakat').modal('show');
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

