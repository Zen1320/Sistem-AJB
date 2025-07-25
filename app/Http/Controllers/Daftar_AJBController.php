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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class Daftar_AJBController extends Controller
{
    public function index()
    {
        $title = 'Hapus Pengajuan';
        $text = "Apakah Anda yakin ingin menghapus ini?";
        confirmDelete($title, $text);
        $pengajuan = pengajuan_ajb::with(['jenis'])->get();
        return view('pengguna.daftar_pengajuan.index', compact('pengajuan'));
    }

    public function detail($id)
    {
        $pengajuan = pengajuan_ajb::with([
            'user',
            'penjual',
            'pembeli',
            'saksi',
            'jenis',
            'objekTanah',
            'berkas'
        ])->findOrFail($id);


        $filesToDownload = $this->prepareDownloadFiles($pengajuan->berkas);
        return view('pengguna.daftar_pengajuan.detail', [
            'pengajuan' => $pengajuan,
            'filesToDownload' => $filesToDownload,

        ]);
    }

    protected function prepareDownloadFiles($berkas)
    {
        $files = [];
        $fileFields = [
            'file_ktp_penjual' => 'KTP Penjual',
            'file_ktp_istri_penjual' => 'KTP Istri Penjual',
            'file_kk_penjual' => 'KK Penjual',
            'file_ktp_pembeli' => 'KTP Pembeli',
            'file_kk_pembeli' => 'KK Pembeli',
            'file_akta_nikah' => 'Akta Nikah',
            'file_sertifikat' => 'Sertifikat Tanah',
            'file_bukti_pbb' => 'Bukti PBB',
            'file_imb' => 'IMB',
            'file_persetujuan' => 'Surat Persetujuan',
            'file_dokumen_lainnya' => 'Dokumen Lainnya'
        ];

        foreach ($fileFields as $field => $label) {
            if (!empty($berkas->$field)) {
                $files[] = [
                    'name' => $this->generateFileName($label, $berkas->$field),
                    'url' => $this->getFileUrl($berkas->$field)
                ];
            }
        }

        return $files;
    }

    protected function generateFileName($label, $path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return Str::slug($label) . '.' . $extension;
    }

    protected function getFileUrl($path)
    {
        return asset('storage') . '/' . implode('/', array_map('rawurlencode', explode('/', $path)));
    }

    public function downloadBerkas($id, $file)
    {
        $pengajuan = pengajuan_ajb::with('berkas')->findOrFail($id);

        $fileFields = [
            'file_ktp_penjual',
            'file_ktp_istri_penjual',
            'file_akta_nikah',
            'file_kk_penjual',
            'file_ktp_pembeli',
            'file_kk_pembeli',
            'file_sertifikat',
            'file_bukti_pbb',
            'file_imb',
            'file_persetujuan',
            'file_dokumen_lainnya',
        ];

        if (!in_array($file, $fileFields)) {
            abort(404, 'Berkas tidak dikenali.');
        }

        $berkasPath = $pengajuan->berkas->$file ?? null;

        if (!$berkasPath || !Storage::disk('public')->exists($berkasPath)) {
            abort(404, 'Berkas tidak ditemukan.');
        }

        $filename = basename($berkasPath);

        return Storage::disk('public')->download($berkasPath, $filename);
    }


    public function downloadZip($id)
    {
        $pengajuan = pengajuan_ajb::with('berkas')->findOrFail($id);

        $fileFields = [
            'file_ktp_penjual' => 'KTP Penjual',
            'file_ktp_istri_penjual' => 'KTP Istri Penjual',
            'file_akta_nikah' => 'Akta Nikah',
            'file_kk_penjual' => 'KK Penjual',
            'file_ktp_pembeli' => 'KTP Pembeli',
            'file_kk_pembeli' => 'KK Pembeli',
            'file_sertifikat' => 'Sertifikat Tanah',
            'file_bukti_pbb' => 'Bukti PBB',
            'file_imb' => 'IMB',
            'file_persetujuan' => 'Surat Persetujuan',
            'file_dokumen_lainnya' => 'Dokumen Lainnya',
        ];

        $zip = new ZipArchive();
        $zipFileName = 'pengajuan_' . $id . '.zip';
        $zipFilePath = storage_path('app/temp/' . $zipFileName);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Gagal membuat ZIP');
        }

        foreach ($fileFields as $field => $label) {
            $file = $pengajuan->berkas->$field ?? null;
            if ($file && Storage::disk('public')->exists($file)) {
                $fullPath = Storage::disk('public')->path($file);
                $filenameInZip = Str::slug($label) . '.' . pathinfo($file, PATHINFO_EXTENSION);
                $zip->addFile($fullPath, $filenameInZip);
            }
        }

        $zip->close();

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }


    public function edit($id){
        $ajb = pengajuan_ajb::with(['penjual', 'pembeli', 'objekTanah', 'berkas', 'jenis'])->findOrFail($id);
        $jenis_pengajuan = jenis_pengajuan::all();

        return view ('pengguna.daftar_pengajuan.edit',compact('ajb','jenis_pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            // Step 1: Penjual
            'penjual_nama' => 'required|string|max:255',
            'penjual_nik' => 'required|numeric|digits_between:10,20',
            'penjual_alamat' => 'required|string',
            'penjual_tempat_lahir' => 'required|string',
            'penjual_tgl_lahir' => 'required|date',
            'pekerjaan_penjual' => 'required|string|max:255',
            'no_telepon_penjual' => 'nullable|numeric',
            //istri penjual
            'istri_nama' => 'nullable|string|max:255',
            'istri_nik' => 'nullable|numeric|digits_between:10,20',
            'istri_tempat_lahir' => 'nullable|string',
            'istri_tgl_lahir' => 'nullable|date',
            'pekerjaan_penjual_istri' => 'nullable|string|max:255',
             'no_telepon_istri_penjual' => 'nullable|numeric',
            // Step 2: Pembeli
            'pembeli_nama' => 'required|string|max:255',
            'pembeli_nik' => 'required|numeric|digits_between:10,20',
            'pembeli_alamat' => 'required|string',
            'pembeli_tempat_lahir' => 'required|string',
            'pembeli_tgl_lahir' => 'required|date',
            'no_telepon_pembeli' => 'nullable|numeric',

            // Step 3: Objek
            'nomor_hak_bangun' => 'required|string|max:255',
            'nomor_surat_ukur' => 'required|string|max:255',
            'nomor_nib' => 'required|string|max:255',
            'pengesah_nib_oleh' => 'required|string|max:255',
            'nomor_spp' => 'required|string|max:255',
            'luas_tanah' => 'required|string|max:255',
            'luas_bangunan' => 'required|string|max:255',

            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'jalan' => 'required|string',
            'alamat_lengkap' => 'required|string',
            'harga_transaksi' => 'required|numeric|min:0',
            // Step 4: Berkas
            'berkas_ktp_penjual' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_ktp_pembeli' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_bukti_pbb' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_file_imb' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'berkas_file_persetujuan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
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
        DB::beginTransaction();

        try {
            // Find existing pengajuan
            $pengajuanAjb = pengajuan_ajb::findOrFail($id);

            // Get related models
            $penjual = penjual::findOrFail($pengajuanAjb->id_penjual);
            $pembeli = pembeli::findOrFail($pengajuanAjb->id_pembeli);
            $objekTanah = objek_tanah::findOrFail($pengajuanAjb->id_objek_tanah);
            $berkasAjb = berkas_ajb::findOrFail($pengajuanAjb->id_berkas);

            $filePaths = [];
            $fileFields = [
                'berkas_ktp_penjual', 'berkas_ktp_pembeli', 'berkas_sertifikat',
                'berkas_bukti_pbb', 'berkas_file_imb', 'berkas_file_persetujuan',
                'berkas_dokumen_lainnya', 'berkas_akta_nikah', 'berkas_ktp_istri',
                'berkas_kk_pembeli', 'berkas_kk_penjual'
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $oldFile = $berkasAjb->{$this->getBerkasFieldName($field)};
                    if ($oldFile) {
                        Storage::disk('public')->delete($oldFile);
                    }
                    $file = $request->file($field);
                    $extension = $file->getClientOriginalExtension();
                    $uniqueName = now()->format('Ymd_His') . "_{$field}_" . uniqid() . '.' . $extension;
                    $filePath = $file->storeAs('berkas_ajb', $uniqueName, 'public');
                    $filePaths[$field] = $filePath;
                }
            }

            $penjual->update([
                'nama_penjual' => $request->penjual_nama,
                'nik_penjual' => $request->penjual_nik,
                'tgl_lahir_penjual' => $request->penjual_tgl_lahir,
                'tempat_lahir_penjual' => $request->penjual_tempat_lahir,
                'nama_istri_penjual' => $request->istri_nama ?? null,
                'nik_istri_penjual' => $request->istri_nik ?? null,
                'tgl_lahir_istri_penjual' => $request->istri_tgl_lahir ?? null,
                'tempat_lahir_istri_penjual' => $request->istri_tempat_lahir ?? null,
                'alamat_penjual' => $request->penjual_alamat,
                'pekerjaan_penjual' => $request->pekerjaan_penjual,
                'pekerjaan_penjual_istri' => $request->penjual_alamat,
                'no_telepon_penjual' => $request->no_telepon_penjual,
                'no_telepon_istri_penjual' => $request->no_telepon_istri_penjual
            ]);

            $pembeli->update([
                'nama_pembeli' => $request->pembeli_nama,
                'nik_pembeli' => $request->pembeli_nik,
                'tgl_lahir_pembeli' => $request->pembeli_tgl_lahir,
                'tempat_lahir_pembeli' => $request->pembeli_tempat_lahir,
                'alamat_pembeli' => $request->pembeli_alamat,
                'pekerjaan' => $request->pekerjaan,
                'no_telepon_pembeli' => $request->no_telepon_pembeli
            ]);

            $objekTanah->update([
                'nomor_hak_bangun' => $request->nomor_hak_bangun,
                'nomor_surat_ukur' => $request->nomor_surat_ukur,
                'tanggal_surat_ukur' => $request->tanggal_surat_ukur,
                'luas_tanah' => $request->luas_tanah,
                'luas_bangunan' => $request->luas_bangunan,

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

            $berkasUpdateData = [];
            foreach ($filePaths as $field => $path) {
                $berkasField = $this->getBerkasFieldName($field);
                $berkasUpdateData[$berkasField] = $path;
            }

            if (!empty($berkasUpdateData)) {
                $berkasAjb->update($berkasUpdateData);
            }

            $pengajuanAjb->update([
                'harga_transaksi_tanah' => $request->harga_transaksi,
            ]);

            DB::commit();

            return redirect()->route('pengguna.daftar.index')
                ->with('success', 'Pengajuan AJB berhasil diperbarui dengan kode: ' . $pengajuanAjb->kode_pengajuan);
        } catch (\Exception $e) {
            Log::error('Terjadi error saat update pengajuan AJB', [
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
                ->with('error', 'Gagal memperbarui pengajuan. Error: ' . $e->getMessage());
        }
    }

    private function getBerkasFieldName($requestField)
    {
        $mapping = [
            'berkas_ktp_penjual' => 'file_ktp_penjual',
            'berkas_ktp_istri' => 'file_ktp_istri_penjual',
            'berkas_akta_nikah' => 'file_akta_nikah',
            'berkas_kk_penjual' => 'file_kk_penjual',
            'berkas_ktp_pembeli' => 'file_ktp_pembeli',
            'berkas_kk_pembeli' => 'file_kk_pembeli',
            'berkas_sertifikat' => 'file_sertifikat',
            'berkas_bukti_pbb' => 'file_bukti_pbb',
            'berkas_file_imb' => 'file_imb',
            'berkas_file_persetujuan' => 'file_persetujuan',
            'berkas_dokumen_lainnya' => 'file_dokumen_lainnya',
        ];

        return $mapping[$requestField] ?? $requestField;
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $pengajuan = pengajuan_ajb::with(['penjual', 'pembeli', 'objekTanah', 'berkas'])->findOrFail($id);
            $berkasPaths = [];

            if ($pengajuan->berkas) {
                $berkasFields = [
                    'file_ktp_penjual',
                    'file_ktp_istri_penjual',
                    'file_akta_nikah',
                    'file_kk_penjual',
                    'file_ktp_pembeli',
                    'file_kk_pembeli',
                    'file_sertifikat',
                    'file_bukti_pbb',
                    'file_imb',
                    'file_persetujuan',
                    'file_dokumen_lainnya',
                ];

                foreach ($berkasFields as $field) {
                    if (!empty($pengajuan->berkas->$field)) {
                        $berkasPaths[] = $pengajuan->berkas->$field;
                    }
                }
            }

            foreach ($berkasPaths as $path) {
                Storage::disk('public')->delete($path);
            }
            $pengajuan->berkas?->delete();
            $pengajuan->penjual?->delete();
            $pengajuan->pembeli?->delete();
            $pengajuan->objekTanah?->delete();
            $pengajuan->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Data pengajuan AJB berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Gagal menghapus pengajuan AJB', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Gagal menghapus pengajuan AJB. Silakan coba lagi.');
        }
    }

}
