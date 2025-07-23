<?php

namespace App\Http\Controllers;

use App\Models\pengajuan_ajb;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        Carbon::setLocale('id');
        if(Auth::user()->role == 1 || Auth::user()->role == 0 ){
            $bulan = range(1, 12);
            $tahun = Carbon::now()->year;

            // Pengajuan Selesai (status = 3)
            $pengajuanSelesai = pengajuan_ajb::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                ->where('status', 3)
                ->whereYear('created_at', $tahun)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->pluck('total', 'bulan');

            // Pengajuan Proses (selain status 3)
            $pengajuanProses = pengajuan_ajb::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                ->where('status', '<>', 3)
                ->whereYear('created_at', $tahun)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->pluck('total', 'bulan');

            $dataSelesai = [];
            $dataProses = [];

            foreach ($bulan as $b) {
                $dataSelesai[] = $pengajuanSelesai[$b] ?? 0;
                $dataProses[] = $pengajuanProses[$b] ?? 0;
            }

            $aktivitas = pengajuan_ajb::latest('updated_at')->take(10)->get()->map(function ($item) {
            $statusText = '';
            $waktu = '';
            $labelStatus = '';

            switch ($item->status) {
                case 0: // Masuk
                    $statusText = 'Masuk';
                    $waktu = 'Dikirim ' . Carbon::parse($item->created_at)->diffForHumans();
                    $labelStatus = 'text-primary';
                    break;
                case 1: // Revisi
                    $statusText = 'Revisi';
                    $waktu = 'Direvisi ' . Carbon::parse($item->updated_at)->diffForHumans();
                    $labelStatus = 'text-danger';
                    break;
                case 2: // Proses
                    $statusText = 'Proses';
                    $waktu = 'Diperbarui ' . Carbon::parse($item->updated_at)->diffForHumans();
                    $labelStatus = 'text-warning';
                    break;
                case 3: // Selesai
                    $statusText = 'Selesai';
                    $waktu = 'Diselesaikan ' . Carbon::parse($item->updated_at)->diffForHumans();
                    $labelStatus = 'text-success';
                    break;
                case 4: // Verifikasi
                    $statusText = 'Verifikasi Berkas';
                    $waktu = 'Verifikasi Berkas ' . Carbon::parse($item->updated_at)->diffForHumans();
                    $labelStatus = 'text-info';
                    break;
                case 5: // Revisi Masuk
                    $statusText = 'Revisi Masuk';
                    $waktu = 'Revisi Masuk ' . Carbon::parse($item->updated_at)->diffForHumans();
                    $labelStatus = 'text-secondary';
                    break;
                default:
                    $statusText = 'Tidak diketahui';
                    $waktu = 'Status tidak dikenal';
                    $labelStatus = 'text-muted';
                    break;
            }

            return [
                'kode' => $item->kode_pengajuan,
                'status_text' => $statusText,
                'status_class' => $labelStatus,
                'alamat' => $item->pembeli->alamat ?? '-',
                'waktu' => $waktu,
            ];
        });

            $pengajuan = pengajuan_ajb::with('pembeli','penjual','objekTanah')->latest()->take(5)->get();
             // Total seluruh pengajuan
            $totalTransaksi = pengajuan_ajb::count();

            // Jumlah pengajuan berdasarkan status
            $selesai        = pengajuan_ajb::where('status', 3)->count();
            $dalamProses    = pengajuan_ajb::where('status', 2)->count();
            $diRevisi       = pengajuan_ajb::where('status', 1)->count();

            return view('admin.dashboard',[
                'dataSelesai' => $dataSelesai,
                'dataProses' => $dataProses,
                'aktivitas' => $aktivitas,
                'data_pengajuan' => $pengajuan,
                'totalTransaksi' => $totalTransaksi,
                'selesai'        => $selesai,
                'dalamProses'    => $dalamProses,
                'diRevisi'       => $diRevisi
            ]);

        }else if(Auth::user()->role == 2){

            $totalAjb        = pengajuan_ajb::count();
            $selesai        = pengajuan_ajb::where('status', 3)->count();
            $dalamProses    = pengajuan_ajb::where('status', 2)->count();
            $diRevisi       = pengajuan_ajb::where('status', 1)->count();
            $recentAjb = pengajuan_ajb::with('jenis')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

             $prosesAjb = pengajuan_ajb::with('jenis')
            ->whereIn('status', [1, 2]) // Proses atau Perlu Revisi
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'jenis' => $item->jenis->nama_jenis ?? '-',
                    'status' => match($item->status) {
                        1 => 'Perlu Revisi',
                        2 => 'Proses Akad Notaris',
                        default => 'Menunggu Verifikasi',
                    },
                    'color' => match($item->status) {
                        1 => 'danger',
                        2 => 'warning',
                        default => 'primary',
                    },
                    'progress' => match($item->status) {
                        1 => 45,
                        2 => 65,
                        default => 30,
                    },
                    'update' => Carbon::parse($item->updated_at)->diffForHumans()
                ];
            });
            return view('pengguna.dashboard', compact(
            'totalAjb',
            'selesai',
            'dalamProses',
            'diRevisi',
            'recentAjb',
             'prosesAjb'

        ));
        }
    }
}
