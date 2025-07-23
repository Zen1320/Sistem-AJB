<?php

namespace App\Exports;

use App\Models\pengajuan_ajb;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
class laporanexport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithEvents
{
    protected $tgl_awal;
    protected $tgl_akhir;

    public function __construct($tgl_awal, $tgl_akhir)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function title(): string
    {
        return 'Laporan AJB';
    }

    public function startCell(): string
    {
        return 'A4'; // data mulai dari baris ke-4
    }

    public function headings(): array
    {
        return [
            'Kode Pengajuan',
            // 'Tanggal Export',
            'Nama Penjual',
            'Tempat Lahir Penjual',
            'Tanggal Lahir Penjual',
            'Pekerjaan Penjual',
            'Alamat Penjual',
            'NIK Penjual',
            'Nama Istri Penjual',
            'Tanggal Lahir Istri',
            'NIK Istri Penjual',
            'Nama Pembeli',
            'Tempat Lahir Pembeli',
            'Tanggal Lahir Pembeli',
            'Pekerjaan Pembeli',
            'Alamat Pembeli',
            'NIK Pembeli',
            'Nomor Tanah',
            'Luas Tanah',
            'Luas Bangunan',
            'Provinsi',
            'Kabupaten',
            'Kecamatan',
            'Desa',
            'Jalan',
            'Harga Transaksi',
            'Nama Notaris',
            'Tempat Lahir Notaris',
            'Tanggal Lahir Notaris',
            'Alamat Notaris',
            'NIK Notaris',
            'NIP Notaris',
        ];
    }

    public function collection()
    {
        $query = pengajuan_ajb::with(['penjual', 'pembeli', 'saksi', 'objekTanah']);

        if ($this->tgl_awal && $this->tgl_akhir) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->tgl_awal)->startOfDay(),
                Carbon::parse($this->tgl_akhir)->endOfDay()
            ]);
        }

        $data = $query->get();
        $rows = [];
        $now = Carbon::now()->locale('id')->translatedFormat('d F Y');

        foreach ($data as $pengajuan) {
            $penjual = $pengajuan->penjual;
            $pembeli = $pengajuan->pembeli;
            $saksi = $pengajuan->saksi;
            $tanah = $pengajuan->objekTanah;

            $rows[] = [
                $pengajuan->kode_pengajuan,
                // $now,

                $penjual->nama_penjual ?? '',
                $penjual->tempat_lahir_penjual ?? '',
                Carbon::parse($penjual->tanggal_lahir ?? null)->translatedFormat('d F Y'),
                $penjual->pekerjaan_penjual ?? '',
                $penjual->alamat_penjual ?? '',
                $penjual->nik_penjual ?? '',

                $penjual->nama_istri_penjual ?? ' Belum Menikah ',
                Carbon::parse($penjual->tgl_lahir_istri_penjual)->translatedFormat('d F Y') ?? "-",
                $penjual->nik_istri_penjual ?? '-',

                $pembeli->nama_pembeli ?? '',
                $pembeli->tempat_lahir_pembeli ?? '',
                Carbon::parse($pembeli->tgl_lahir_pembeli ?? null)->translatedFormat('d F Y'),
                $pembeli->pekerjaan ?? '',
                $pembeli->alamat_pembeli ?? '',
                $pembeli->nik_pembeli ?? '',

                $tanah->nomor_hak_bangun ?? '',
                $tanah->luas_tanah ?? '',
                $tanah->luas_bangunan ?? '',
                $tanah->provinsi ?? '',
                $tanah->kota ?? '',
                $tanah->kecamatan ?? '',
                $tanah->kelurahan ?? '',
                $tanah->jalan ?? '',
                $pengajuan->harga_transaksi_tanah ?? '',

                $saksi->nama_saksi ?? '',
                $saksi->tempat_lahir_saksi ?? '',
                Carbon::parse($saksi->tgl_lahir_saksi ?? null)->translatedFormat('d F Y'),
                $saksi->alamat_saksi ?? '',
                $saksi->nik_saksi ?? '',
                $saksi->nip ?? '',
            ];
        }

        return new Collection($rows);
    }

    public function registerEvents(): array
{
    $format_tanggal = Carbon::now()->locale('id')->translatedFormat('d F Y');
    $tanggal_keterangan = "Tanggal Cetak : ";

    if ($this->tgl_awal && $this->tgl_akhir) {
        $awal = Carbon::parse($this->tgl_awal)->translatedFormat('d F Y');
        $akhir = Carbon::parse($this->tgl_akhir)->translatedFormat('d F Y');
        $tanggal_keterangan .= "$awal s/d $akhir";
    } else {
        $tanggal_keterangan .= $format_tanggal;
    }

    return [
        AfterSheet::class => function (AfterSheet $event) use ($tanggal_keterangan) {
            $sheet = $event->sheet->getDelegate();

            // ============== TITLE & TANGGAL CETAK ==============
            $sheet->setCellValue('A1', 'Laporan Pengajuan AJB');
            $sheet->mergeCells('A1:AG1');
            $sheet->getStyle('A1')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 16,
                ],
                'alignment' => [
                    'horizontal' => 'center',
                ],
            ]);

            $sheet->setCellValue('A2', $tanggal_keterangan);
            $sheet->mergeCells('A2:AG2');
            $sheet->getStyle('A2')->applyFromArray([
                'font' => ['italic' => true],
                'alignment' => ['horizontal' => 'center'],
            ]);

            // ============== HEADER STYLING ==============
            $headerRange = 'A4:AG4'; // Header starts at A4
            $sheet->getStyle($headerRange)->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'BDD7EE'], // Light blue
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);

            // ============== DATA STYLING (SELURUH TABEL) ==============
            $lastRow = $sheet->getHighestRow();
            $lastColumn = $sheet->getHighestColumn();
            $dataRange = "A4:{$lastColumn}{$lastRow}";

            $sheet->getStyle($dataRange)->applyFromArray([
                'alignment' => ['vertical' => 'top', 'wrapText' => true],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '999999'],
                    ],
                ],
            ]);

            // Optional: Set row height auto for all rows
            for ($i = 4; $i <= $lastRow; $i++) {
                $sheet->getRowDimension($i)->setRowHeight(-1);
            }
        }
    ];
}
}
