@extends('layouts.app')
@section('title','Laporan')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <h3 class="fw-bold">Laporan </h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <h4 class="card-title">Filter Laporan Pengajuan</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="GET">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label for="tgl_awal" class="form-label">Tanggal Awal</label>
                                    <input type="date" name="tgl_awal" id="tgl_awal" class="form-control @error('tgl_awal') is-invalid @enderror"
                                        value="{{ old('tgl_awal', request('tgl_awal')) }}" placeholder="Tanggal awal" autocomplete="off" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="tgl_akhir" class="form-label">Tanggal Akhir</label>
                                    <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control @error('tgl_akhir') is-invalid @enderror"
                                        value="{{ old('tgl_akhir', request('tgl_akhir')) }}" placeholder="Tanggal akhir" autocomplete="off" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

       <div class="row mt-5">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <h4>Daftar Laporan Transaksi Barang Masuk</h4>
                        </div>
                        <div>
                             <a href="{{ route('laporan.export', [
                                'tgl_awal'  => request('tgl_awal'),
                                'tgl_akhir' => request('tgl_akhir'),
                            ]) }}" class="btn btn-success mb-3">
                            <i class="fas fa-file-excel"></i> Export Excel
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-hover table-sales">
                                    <table class="table table-bordered table-striped"id="example">
                                        <thead>
                                           <tr>
                                                <th>No</th>
                                                <th>Kode Pengajuan</th>
                                                <th>Tanggal</th>
                                                <th>Nama Penjual</th>
                                                <th>Nama Pembeli</th>
                                                <th>Luas Tanah</th>
                                                <th>Harga Transaksi</th>
                                                <th>Alamat Tanah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->kode_pengajuan }}</td>
                                                <td>{{\Carbon\Carbon::setLocale('id')}}{{
                                                \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                                                <td>{{ $item->penjual->nama_penjual ?? '-' }}</td>
                                                <td>{{ $item->pembeli->nama_pembeli ?? '-' }}</td>
                                                <td>{{ $item->objekTanah->luas_tanah ?? '-' }} m²</td>
                                                <td>Rp {{ number_format($item->harga_transaksi_tanah, 0, ',', '.') }}</td>
                                                <td>
                                                    {{ $item->objekTanah->jalan ?? '-' }},
                                                    {{ $item->objekTanah->kelurahan ?? '-' }},
                                                    {{ $item->objekTanah->kecamatan ?? '-' }},
                                                    {{ $item->objekTanah->kota ?? '-' }}
                                                </td>
                                            </tr>
                                        @empty

                                        @endforelse
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
@push('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

