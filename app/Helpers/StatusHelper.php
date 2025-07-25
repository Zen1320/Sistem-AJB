<?php

if (!function_exists('status_badge')) {
    function status_badge($status)
    {
        $statusList = [
            0 => ['text' => 'Masuk', 'class' => 'secondary'],
            1 => ['text' => 'Revisi', 'class' => 'warning'],
            2 => ['text' => 'Proses Akad Notaris', 'class' => 'info'],
            3 => ['text' => 'Selesai', 'class' => 'success'],
            4 => ['text' => 'Verifikasi Berkas', 'class' => 'primary'],
            5 => ['text' => 'Revisi Masuk', 'class' => 'secondary'],
        ];

        if (!isset($statusList[$status])) {
            return '<span class="badge bg-dark">Tidak Diketahui</span>';
        }

        $data = $statusList[$status];
        return '<span class="badge bg-' . $data['class'] . '">' . $data['text'] . '</span>';
    }
}
