<?php

namespace App\Http\Controllers;

use App\Models\berkas_ajb;
use App\Models\jenis_pengajuan;
use App\Models\objek_tanah;
use App\Models\pembeli;
use App\Models\pengajuan_ajb;
use App\Models\penjual;
use App\Models\saksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PembuatanAJBController extends Controller
{
    //
    public function index (){

        $jenis_pengajuan = jenis_pengajuan::all();
        return view('pengguna.pembuatan_ajb.index',compact('jenis_pengajuan'));
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
            // Step 1: Penjual
            'penjual_nama' => 'required|string|max:255',
            'penjual_nik' => 'required|numeric|digits_between:10,20',
            'penjual_alamat' => 'required|string',
            'penjual_tempat_lahir' => 'required|string',
            'penjual_tgl_lahir' => 'required|date',
            //istri penjual
            'istri_nama' => 'nullable|string|max:255',
            'istri_nik' => 'nullable|numeric|digits_between:10,20',
            'istri_tempat_lahir' => 'nullable|string',
            'istri_tgl_lahir' => 'nullable|date',
            // Step 2: Pembeli
            'pembeli_nama' => 'required|string|max:255',
            'pembeli_nik' => 'required|numeric|digits_between:10,20',
            'pembeli_alamat' => 'required|string',
            'pembeli_tempat_lahir' => 'required|string',
            'pembeli_tgl_lahir' => 'required|date',
            // Step 3: Objek
            'nomor_hak_bangun' => 'required|string|max:255',
            'nomor_surat_ukur' => 'required|string|max:255',
            'nomor_nib' => 'required|string|max:255',
            'pengesah_nib_oleh' => 'required|string|max:255',
            'nomor_spp' => 'required|string|max:255',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'jalan' => 'required|string',
            'alamat_lengkap' => 'required|string',
            'harga_transaksi' => 'required|numeric|min:0',
            // Step 4: Berkas
            'berkas_ktp_penjual' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_ktp_pembeli' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_bukti_pbb' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_file_imb' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_file_persetujuan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_dokumen_lainnya' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_akta_nikah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_ktp_istri' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_kk_penjual' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_kk_pembeli' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            // Custom messages
            'required' => ':attribute wajib diisi.',
            'numeric' => ':attribute harus berupa angka.',
            'max' => ':attribute maksimal :max karakter.',
            'mimes' => ':attribute harus berupa file PDF/JPG/PNG.',
            'berkas_ktp_penjual.max' => 'Ukuran KTP Penjual maksimal 2MB.',
            'digits_between' => ':attribute harus antara :min sampai :max digit.',
        ], [
            // Custom attribute names (untuk user-friendly messages)
            'penjual_nama' => 'Nama Penjual',
            'penjual_nik' => 'NIK Penjual',
            'penjual_alamat' => 'Alamat Penjual',
            'pembeli_nama' => 'Nama Pembeli',
            'pembeli_nik' => 'NIK Pembeli',
            'pembeli_alamat' => 'Alamat Pembeli',
            'nomor_hak_bangun' => 'Nomor Hak Bangun',
            'nomor_surat_ukur' => 'Nomor Surat Ukur',
            'nomor_nib' => 'Nomor NIB',
            'pengesah_nib_oleh' => 'Pengesah NIB',
            'nomor_spp' => 'Nomor SPP',
            'provinsi' => 'Provinsi',
            'kota' => 'Kota/Kabupaten',
            'kecamatan' => 'Kecamatan',
            'kelurahan' => 'Kelurahan',
            'jalan' => 'Jalan',
            'alamat_lengkap' => 'Alamat Lengkap',
            'Harga_transaksi' => 'Harga Transaksi',
            'berkas_ktp_penjual' => 'KTP Penjual',
            'berkas_ktp_pembeli' => 'KTP Pembeli',
            'berkas_sertifikat' => 'Sertifikat',
            'berkas_bukti_pbb' => 'Bukti PBB',
            'berkas_file_imb' => 'File IMB',
            'berkas_file_persetujuan' => 'Persetujuan',
        ]);

        // Mulai transaction untuk memastikan data konsisten
        DB::beginTransaction();

        try {
            // Simpan file-file yang diupload
            $filePaths = [];
            $fileFields = [
                'berkas_ktp_penjual', 'berkas_ktp_pembeli', 'berkas_sertifikat',
                'berkas_bukti_pbb', 'berkas_file_imb', 'berkas_file_persetujuan',
                'berkas_dokumen_lainnya', 'berkas_akta_nikah', 'berkas_ktp_istri',
                'berkas_kk_pembeli', 'berkas_kk_penjual'
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $extension = $file->getClientOriginalExtension();
                    $uniqueName = now()->format('Ymd_His') . "_{$field}_" . uniqid() . '.' . $extension;
                    $filePath = $file->storeAs('berkas_ajb', $uniqueName, 'public');
                    $filePaths[$field] = $filePath;
                }
            }

            // Create Penjual
            $penjual = Penjual::create([
                'nama_penjual' => $request->penjual_nama,
                'nik_penjual' => $request->penjual_nik,
                'tgl_lahir_penjual' => $request->penjual_tgl_lahir,
                'tempat_lahir_penjual' => $request->penjual_tempat_lahir,
                'nama_istri_penjual' => $request->istri_nama ?? null,
                'nik_istri_penjual' => $request->istri_nik ?? null,
                'tgl_lahir_istri_penjual' => $request->istri_tgl_lahir ?? null,
                'tempat_lahir_istri_penjual' => $request->istri_tempat_lahir ?? null,
                'alamat_penjual' => $request->penjual_alamat,
            ]);

            // Create Pembeli (perbaikan field yang tertukar)
            $pembeli = Pembeli::create([
                'nama_pembeli' => $request->pembeli_nama,
                'nik_pembeli' => $request->pembeli_nik,
                'tgl_lahir_pembeli' => $request->pembeli_tgl_lahir,
                'tempat_lahir_pembeli' => $request->pembeli_tempat_lahir,
                'alamat_pembeli' => $request->pembeli_alamat,
            ]);

            // Create Objek Tanah
            $objekTanah = objek_tanah::create([
                'nomor_hak_bangun' => $request->nomor_hak_bangun,
                'nomor_surat_ukur' => $request->nomor_surat_ukur,
                'nomor_nib' => $request->nomor_nib,
                'pengesahan_nib_oleh' => $request->pengesah_nib_oleh,
                'nomor_spp' => $request->nomor_spp,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'jalan' => $request->jalan,
                'alamat_lengkap' => $request->alamat_lengkap,
            ]);

            // Create Berkas AJB
            $berkasAjb = berkas_ajb::create([
                'file_ktp_penjual' => $filePaths['berkas_ktp_penjual'] ?? null,
                'file_ktp_istri_penjual' => $filePaths['berkas_ktp_istri'] ?? null,
                'file_akta_nikah' => $filePaths['berkas_akta_nikah'] ?? null,
                'file_kk_penjual' => $filePaths['berkas_kk_penjual'] ?? null,
                'file_ktp_pembeli' => $filePaths['berkas_ktp_pembeli'] ?? null,
                'file_kk_pembeli' => $filePaths['berkas_kk_pembeli'] ?? null,
                'file_sertifikat' => $filePaths['berkas_sertifikat'] ?? null,
                'file_bukti_pbb' => $filePaths['berkas_bukti_pbb'] ?? null,
                'file_imb' => $filePaths['berkas_file_imb'] ?? null,
                'file_persetujuan' => $filePaths['berkas_file_persetujuan'] ?? null,
                'file_dokumen_lainnya' => $filePaths['berkas_dokumen_lainnya'] ?? null,
            ]);

            // Generate kode pengajuan unik
            $kodePengajuan = 'AJB-' . date('Ymd') . '-' . strtoupper(Str::random(5)) . '-' . Auth::id();

            // Create Pengajuan AJB
            $pengajuanAjb = pengajuan_ajb::create([
                'id_user' => Auth::id(),
                'id_penjual' => $penjual->id,
                'id_pembeli' => $pembeli->id,
                'id_saksi' => null,
                'id_objek_tanah' => $objekTanah->id,
                'id_berkas' => $berkasAjb->id,
                'id_jenis' => $request->id_jenis,
                'kode_pengajuan' => $kodePengajuan,
                'harga_transaksi_tanah' => $request->harga_transaksi,
                'tanggal_pengajuan' => now(),
                'status' => 0, // Status awal: menunggu
            ]);

            DB::commit();

            return redirect()->route('pengguna.pembuatanajb.index')
                ->with('success', 'Pengajuan AJB berhasil dibuat dengan kode: ' . $kodePengajuan);
            } catch (\Exception $e) {
                Log::error('Terjadi error saat registrasi', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'waktu' => now()
                ]);
                DB::rollBack();
                if (!empty($filePaths)) {
                    foreach ($filePaths as $filePath) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
                return back()->withInput()
                    ->with('error', 'Gagal membuat pengajuan. Error: ' . $e->getMessage());
        }
    }
}
