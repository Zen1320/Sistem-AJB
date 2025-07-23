<?php

use Carbon\Carbon;

/**
 * Konversi angka ke teks bahasa Indonesia (misal: 2025 -> dua ribu dua puluh lima)
 */
function terbilang($angka)
{
    $angka = abs($angka);
    $bilangan = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

    if ($angka < 12) {
        return $bilangan[$angka];
    } elseif ($angka < 20) {
        return terbilang($angka - 10) . " belas";
    } elseif ($angka < 100) {
        return terbilang($angka / 10) . " puluh " . terbilang($angka % 10);
    } elseif ($angka < 200) {
        return "seratus " . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        return terbilang($angka / 100) . " ratus " . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        return "seribu " . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        return terbilang($angka / 1000) . " ribu " . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        return terbilang($angka / 1000000) . " juta " . terbilang($angka % 1000000);
    } else {
        return "Angka terlalu besar";
    }
}

/**
 * Format tanggal menjadi teks lengkap formal (misal: 14 Juli 1990 -> empat belas Juli seribu sembilan ratus sembilan puluh)
 */
function formatTanggalLahirFormal($tanggal)
{
    $date = Carbon::parse($tanggal);
    $tanggalTeks = terbilang((int) $date->format('d'));
    $bulanTeks = $date->translatedFormat('F'); // Juli
    $tahunTeks = terbilang((int) $date->format('Y'));

    return trim("$tanggalTeks $bulanTeks $tahunTeks");
}

/**
 * Format tanggal seperti untuk kop surat: "Senin, 14 Juli 2025"
 */
function formatTanggalKop($tanggal)
{
    $date = Carbon::parse($tanggal);
    $hari = $date->translatedFormat('l');
    $tgl = $date->format('d');
    $bulan = $date->translatedFormat('F');
    $tahun = $date->format('Y');

    return "$hari, $tgl $bulan $tahun";
}
