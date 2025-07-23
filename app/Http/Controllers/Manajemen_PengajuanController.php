<?php

namespace App\Http\Controllers;

use App\Helpers\MessageHelper;
use App\Models\pengajuan_ajb;
use App\Models\saksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use PhpOffice\PhpWord\TemplateProcessor;

class Manajemen_PengajuanController extends Controller
{
    //

    public function index(){
        $data = pengajuan_ajb::with('user','jenis')->get();

        return view('admin.Manajemen_Notaris.index',compact('data'));
    }

    public function detail($id){
        $pengajuan = pengajuan_ajb::with([
            'user',
            'penjual',
            'pembeli',
            'saksi',
            'jenis',
            'objekTanah',
            'berkas'
        ])->findOrFail($id);

        if ($pengajuan->status == 0) {
            $pengajuan->update([
                'status' => 4
            ]);
        }

        $saksi = saksi::all();
        $filesToDownload = $this->prepareDownloadFiles($pengajuan->berkas);
        return view('admin.Manajemen_Notaris.detail', [
            'pengajuan' => $pengajuan,
            'filesToDownload' => $filesToDownload,
            'saksi' =>$saksi,
            'id_pengajuan' => $id
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


    public function proses (Request $request, $id){
        $pengajuan = pengajuan_ajb::with('user')->find($id);
        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Pengajuan tidak ditemukan');
        }
        $tanggalAkadString = $request->input('tanggal_akad_proses') . ' ' . $request->input('waktu_akad_proses');
        $pengajuan->tanggal_akad = \Carbon\Carbon::parse($tanggalAkadString);
        $pengajuan->id_saksi = $request->input('saksi_notaris');
        $pengajuan->status = 2;
        $pengajuan->save();

            $hour = now()->format('H');
            if ($hour >= 5 && $hour < 11) {
                $salam = 'Selamat pagi';
            } elseif ($hour >= 11 && $hour < 15) {
                $salam = 'Selamat siang';
            } elseif ($hour >= 15 && $hour < 18) {
                $salam = 'Selamat sore';
            } else {
                $salam = 'Selamat malam';
            }
            $nomor = $pengajuan->user->no_telp;
            $nama = $pengajuan->user->name;
            $judul = $pengajuan->kode_pengajuan;

            $saksi = saksi::find($request->input('saksi_notaris'));
            $waktuAkad = Carbon::parse($pengajuan->tanggal_akad)->format('H:i');
            $tanggalAkad = Carbon::parse($pengajuan->tanggal_akad)->locale('id')->translatedFormat('l, d F Y');


            $message = "{$salam}, *Ibu/Bapak {$nama}*.\n\n"
            . "Kami dari *PPAT Rawat Erawady, S.H* menginformasikan bahwa pengajuan Anda dengan *Kode Pengajuan: {$judul}* telah kami *proses*.\n\n"
            . "📅 *Jadwal Akad:* {$tanggalAkad}\n"
            . "⏰ *Pukul:* {$waktuAkad} WIB\n"
            . "📍 *Lokasi:* Kantor PPAT Rawat Erawady, S.H\n\n"
            . "Mohon untuk hadir sesuai jadwal yang telah ditentukan dengan membawa persyaratan berikut:\n"
            . "✔️ Berkas asli yang telah dilampirkan\n"
            . "✔️ Penjual dan istrinya (jika sudah menikah)\n"
            . "✔️ Pembeli wajib hadir\n\n"
            . "👥 *Saksi:* {$saksi->nama_saksi} (dari pihak kantor kami)\n\n"
            . "Apabila terdapat hal yang perlu dikonfirmasi, silakan hubungi petugas kami terlebih dahulu.\n\n"
            . "Terima kasih atas kerja sama dan kepercayaannya.\n\n"
            . "_Pesan ini dibuat otomatis oleh sistem._";
            $response = MessageHelper::sendMessage($message, $nomor);


            $message = "{$salam}, *{$saksi->nama_saksi}*.\n\n"
                . "Kami informasikan bahwa Anda dijadwalkan untuk bertugas sebagai *saksi internal* pada pelaksanaan akad berikut:\n\n"
                . "📄 *Kode Pengajuan:* {$judul}\n"
                . "📅 *Tanggal:* {$tanggalAkad}\n"
                . "⏰ *Waktu:* Pukul {$waktuAkad} WIB\n"
                . "📍 *Tempat:* Kantor PPAT Rawat Erawady, S.H\n\n"
                . "Dimohon untuk hadir tepat waktu dan melaksanakan tugas sesuai dengan standar operasional yang berlaku.\n\n"
                . "Terima kasih atas komitmen dan profesionalisme Anda.\n\n"
                . "_Pesan ini dikirim secara otomatis oleh sistem._";

            $response = MessageHelper::sendMessage($message,  $saksi->no_telepon_saksi);

            if (!$response) {
                return back()->with('error', 'Gagal mengirim pesan notifikasi ke masyarakat. Namun pengajuan telah berhasil diproses.');
            }

        return redirect()->back()->with('success', 'Data Berhasil Diproses');
    }



    public function revisi(Request $request, $id)
    {
        pengajuan_ajb::where('id', $id)->update([
            'status' => 1,
            'keterangan' => $request->input('keterangan_revisi')
        ]);

        $pengajuan = pengajuan_ajb::with('user')->find($id);
        if ($pengajuan && $pengajuan->user) {
            $hour = now()->format('H');
            if ($hour >= 5 && $hour < 11) {
                $salam = 'Selamat pagi';
            } elseif ($hour >= 11 && $hour < 15) {
                $salam = 'Selamat siang';
            } elseif ($hour >= 15 && $hour < 18) {
                $salam = 'Selamat sore';
            } else {
                $salam = 'Selamat malam';
            }

            $nomor = $pengajuan->user->no_telp;
            $nama = $pengajuan->user->name;
            $judul = $pengajuan->kode_pengajuan;
            $keteranganRevisi = $request->input('keterangan_revisi');

            $message = "{$salam}, *Ibu/Pak {$nama}*.\n\n"
            . "Kami dari *PPAT RAWAT ERAWADY, S.H* ingin memberitahukan bahwa pengajuan Anda Kode Pengajuan : *{$judul}* memerlukan *revisi*.\n\n"
            . "📝 *Keterangan revisi:* {$keteranganRevisi}\n\n"
            . "Mohon untuk segera memeriksa dan memperbaiki pengajuan Anda agar dapat segera kami proses kembali.\n\n"
            . "Terima kasih atas perhatian dan kerja sama Anda.\n\n"
            . "_Pesan ini dibuat otomatis oleh sistem._";

            $response = MessageHelper::sendMessage($message, $nomor);


            if (!$response) {
                return back()->with('error', 'Gagal mengirim pesan notifikasi ke masyarakat. Namun pengajuan telah berhasil ditandai untuk revisi.');
            }
        } else {
            return back()->with('error', 'Data pengajuan atau data pengguna tidak ditemukan. Pengajuan telah ditandai untuk revisi, namun pesan tidak dapat dikirim.');
        }

        return redirect()->back()->with('success', 'Berhasil Dikirim');
    }



    public function uploadakta(Request $request, $id){
        $request->validate([
            'file_akta' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $pengajuan = pengajuan_ajb::findOrFail($id);
        $kodeTransaksi = $pengajuan->kode_pengajuan;

        if ($pengajuan->file_akta && Storage::disk('public')->exists($pengajuan->file_akta)) {
            Storage::disk('public')->delete($pengajuan->file_akta);
        }

        if ($pengajuan->file_akta && Storage::disk('public')->exists($pengajuan->file_akta)) {
            Storage::disk('public')->delete($pengajuan->file_akta);
        }

        $file = $request->file('file_akta');
        $ext = $file->getClientOriginalExtension();

        $namaFile = 'akta_' . Str::slug($kodeTransaksi, '_') . '.' . $ext;

        $path = $file->storeAs('file_akta_ttd', $namaFile, 'public');
        $pengajuan->file_akta = $path;
        $pengajuan->status = 3;
        $pengajuan->save();

            $hour = now()->format('H');
            if ($hour >= 5 && $hour < 11) {
                $salam = 'Selamat pagi';
            } elseif ($hour >= 11 && $hour < 15) {
                $salam = 'Selamat siang';
            } elseif ($hour >= 15 && $hour < 18) {
                $salam = 'Selamat sore';
            } else {
                $salam = 'Selamat malam';
            }

            $nomor = $pengajuan->user->no_telp;
            $nama = $pengajuan->user->name;
            $judul = $pengajuan->kode_pengajuan;
            $keteranganRevisi = $request->input('keterangan_revisi');

            $message = "{$salam}, *Ibu/Bapak {$nama}*.\n\n"
            . "Kami dari *PPAT Rawat Erawady, S.H* menginformasikan bahwa *akta pengajuan Anda dengan Kode Pengajuan: {$judul}* telah selesai diproses.\n\n"
            . "📄 *Dokumen akta Digital* telah tersedia dan dapat diunduh melalui sistem.\n\n"
            . "Apabila Anda mengalami kendala dalam mengakses atau mengunduh dokumen, silakan hubungi tim kami untuk bantuan lebih lanjut.\n\n"
            . "Terima kasih atas kepercayaan dan kerja sama Anda.\n\n"
            . "_Pesan ini dikirim secara otomatis oleh sistem._";
            $response = MessageHelper::sendMessage($message, $nomor);

        return redirect()->back()->with('success', 'File akta berhasil diupload dengan nama yang sesuai.');
    }


    public function cetakakta($id)
    {
        $pengajuan = pengajuan_ajb::with([
            'user',
            'penjual',
            'pembeli',
            'saksi',
            'jenis',
            'objekTanah',
        ])->findOrFail($id);

        Carbon::setLocale('id');
        $now = Carbon::now();

        // Set data
        $penjual = $pengajuan->penjual;
        $pembeli = $pengajuan->pembeli;
        $saksi = $pengajuan->saksi;
        $tanah = $pengajuan->objekTanah;

        if(!$pengajuan->penjual->nama_istri_penjual || !$pengajuan->penjual->nik_istri_penjual ){
            $templatePath = storage_path('app/templates/template_non_istri.docx');
            $templateProcessor = new TemplateProcessor($templatePath);
        }else{
            $templatePath = storage_path('app/templates/template_with_istri.docx');
            $templateProcessor = new TemplateProcessor($templatePath);
        }
         $templateProcessor->setValues([
                'kode_pengajuan' => $pengajuan->kode_pengajuan,
                'hari' => $now->translatedFormat('l'),
                'tanggal' => $now->format('d'),
                'tanggal_teks' => terbilang((int) $now->format('d')),
                'bulan' => $now->translatedFormat('F'),
                'tahun' => $now->translatedFormat('Y'),
                'tahun_teks' => ucwords(terbilang((int) $now->format('Y'))),
                'tanggal_sekarang' => $now->translatedFormat('d F Y'),

                // Penjual
                'nama_penjual' => $penjual->nama_penjual,
                'tempat_lahir_penjual' => $penjual->tempat_lahir_penjual,
                'tanggal_lahir_penjual' => Carbon::parse($penjual->tanggal_lahir)->translatedFormat('d F Y'),
                'tanggal_lahir_penjual_teks' => formatTanggalLahirFormal($penjual->tanggal_lahir),
                'pekerjaan_penjual' => $penjual->pekerjaan_penjual,
                'alamat_penjual' => $penjual->alamat_penjual,
                'nik_penjual' => $penjual->nik_penjual,
                // Istri Penjual
                'nama_istri_penjual' => $penjual->nama_istri_penjual ?? '',
                'tempat_lahir_istri_penjual' => $penjual->tempat_lahir_istri_penjual ?? '',
                'tanggal_lahir_istri_penjual' => Carbon::parse($penjual->tgl_lahir_istri_penjual)->translatedFormat('d F Y'),
                'tanggal_lahir_penjual_istri_teks' => formatTanggalLahirFormal($penjual->tgl_lahir_istri_penjual),
                'pekerjaan_istri_penjual' => $penjual->pekerjaan_penjual_istri ?? '',
                'alamat_istri_penjual' => $penjual->alamat_penjual ?? '',
                'nik_istri_penjual' => $penjual->nik_istri_penjual,
                // Pembeli
                'nama_pembeli' => $pembeli->nama_pembeli,
                'tempat_lahir_pembeli' => $pembeli->tempat_lahir_pembeli,
                'tanggal_lahir_pembeli' => Carbon::parse($pembeli->tgl_lahir_pembeli)->translatedFormat('d F Y'),
                'tanggal_lahir_pembeli_teks' => formatTanggalLahirFormal($pembeli->tgl_lahir_pembeli),
                'pekerjaan_pembeli' => $pembeli->pekerjaan,
                'alamat_pembeli' => $pembeli->alamat_pembeli,
                'nik_pembeli' => $pembeli->nik_pembeli,

                // Tanah
                'nomor_tanah' => $tanah->nomor_hak_bangun,
                'tangga_surat_ukur' => $tanah->tanggal_surat_ukur,
                'nomor_surat_ukur' => $tanah->nomor_surat_ukur,
                'luas_tanah' => $tanah->luas_tanah,
                'luas_tanah_teks' => terbilang((int) $tanah->luas_tanah),
                'luas_bangunan' => $tanah->luas_bangunan,
                'nomor_nib' => $tanah->nomor_nib,
                'provinsi' => $tanah->provinsi,
                'kabupaten' => $tanah->kota,
                'kecamatan' => $tanah->kecamatan,
                'desa' => $tanah->kelurahan,
                'jalan' => $tanah->jalan,
                'luas' => $tanah->luas,
                'nilai_nominal' => number_format($pengajuan->harga_transaksi_tanah, 0, ',', '.'),
                'nilai_nominal_teks' => terbilang($pengajuan->harga_transaksi_tanah),

                // Saksi
                'nama_notaris' => $saksi->nama_saksi,
                'tempat_lahir_saksi' => $saksi->tempat_lahir_saksi,
                'tanggal_lahir_notaris' => Carbon::parse($saksi->tgl_lahir_saksi)->translatedFormat('d F Y'),
                'tanggal_lahir_saksi_teks' => formatTanggalLahirFormal(Carbon::parse($saksi->tgl_lahir_saksi)->translatedFormat('d F Y')),
                'pekerjaan_saksi' => "Notaris",
                'alamat_notaris' => $saksi->alamat,
                'nik_notaris' => $saksi->nik_saksi,
                'nip_notaris' => $saksi->nip,
            ]);

        //test
        // $templatePath = storage_path('app/templates/template.docx');
        // $templateProcessor = new TemplateProcessor($templatePath);
        // $templateProcessor->setValues([
        //     'nama_kamu' => 'Ferry'
        // ]);

        // Simpan
        $fileName = 'Akta Kode' . $pengajuan->kode_pengajuan .'-'. $now->translatedFormat('d F Y').'.docx';
        $savePath = storage_path("app/public/$fileName");
        $templateProcessor->saveAs($savePath);

        return response()->download($savePath)->deleteFileAfterSend(true);
    }
}
