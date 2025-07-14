<?php

use Carbon\Carbon;

if (!function_exists('terbilang')) {
    function terbilang($angka)
    {
        $angka = abs((int)$angka);
        $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

        if ($angka < 12)
            return $huruf[$angka];
        elseif ($angka < 20)
            return $huruf[$angka - 10] . " belas";
        elseif ($angka < 100)
            return $huruf[floor($angka / 10)] . " puluh " . terbilang($angka % 10);
        elseif ($angka < 200)
            return "seratus " . terbilang($angka - 100);
        elseif ($angka < 1000)
            return $huruf[floor($angka / 100)] . " ratus " . terbilang($angka % 100);
        elseif ($angka < 2000)
            return "seribu " . terbilang($angka - 1000);
        elseif ($angka < 1000000)
            return terbilang(floor($angka / 1000)) . " ribu " . terbilang($angka % 1000);
        elseif ($angka < 1000000000)
            return terbilang(floor($angka / 1000000)) . " juta " . terbilang($angka % 1000000);

        return "angka terlalu besar";
    }
}

if (!function_exists('formatTanggalFormal')) {
    function formatTanggalFormal($tanggal)
    {
        $tanggal = Carbon::parse($tanggal);
        Carbon::setLocale('id');

        $hari = $tanggal->translatedFormat('l');
        $bulan = $tanggal->translatedFormat('F');
        $tgl = (int) $tanggal->format('d');
        $tahun = (int) $tanggal->format('Y');

        $tglTerbilang = strtolower(terbilang($tgl));
        $tahunTerbilang = strtolower(terbilang($tahun));

        return "pada hari ini, {$hari} tanggal {$tgl} ({$tglTerbilang}) bulan {$bulan}, tahun {$tahun} ({$tahunTerbilang})";
    }
}

if (!function_exists('formatKopSurat')) {
    function formatKopSurat($tanggal)
    {
        $tanggal = Carbon::parse($tanggal);
        Carbon::setLocale('id');

        return $tanggal->translatedFormat('l, d F Y');
    }
}

if (!function_exists('formatTanggalLahirFormal')) {
    function formatTanggalLahirFormal($tanggal)
    {
        $tanggal = Carbon::parse($tanggal);
        Carbon::setLocale('id');

        $tgl = (int) $tanggal->format('d');
        $bulan = $tanggal->translatedFormat('F');
        $tahun = (int) $tanggal->format('Y');

        $tglTerbilang = strtolower(terbilang($tgl));
        $tahunTerbilang = strtolower(terbilang($tahun));

        return "{$tglTerbilang} {$bulan} {$tahunTerbilang}";
    }
}
