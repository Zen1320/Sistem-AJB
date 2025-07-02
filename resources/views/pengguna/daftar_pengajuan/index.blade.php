@extends('layouts.app')
@section('title','Daftar')

@section('content')
<div class="m-4">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold mb-3">Daftar Pengajuan AJB</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row ">
                           <h4>Daftar Pengajuan AJB Anda</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="example">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Kode AJB</th>
                                                <th>Jenis Transaksi</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pengajuan as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{$item->updated_at}}</td>
                                                    <td>{{ $item->kode_pengajuan }}</td>
                                                    <td>{{$item->jenis->nama_jenis}}</td>
                                                    <td>{!!status_badge($item->status)!!}</td>
                                                    <td>{{$item->keterangan ?? '-'}}</td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                                <a href="{{route('pengguna.daftar.detail',$item->id)}}" class="btn btn-info btn-sm">Lihat</a>
                                                            @if($item->status == '0' || $item->status == '1')
                                                                <a href="{{route('pengguna.daftar.edit',$item->id)}}" class="btn btn-warning btn-sm">Edit Data</a>
                                                            @endif
                                                            @if($item->status == '0')
                                                                @method('DELETE')
                                                                <a href="{{route('pengguna.AJB.destroy',$item->id)}}" class="btn btn-danger btn-sm" data-confirm-delete="true">Hapus Data</a>
                                                            @endif

                                                        </div>
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
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

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
