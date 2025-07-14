<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MessageHelper
{
    public static function sendMessage($message, $number)
    {
        try {
                // Normalisasi nomor WA
            $cleanedNumber = preg_replace('/[^0-9]/', '', $number);

            if (str_starts_with($cleanedNumber, '62')) {
                $processedNumber = $cleanedNumber;
            } elseif (str_starts_with($cleanedNumber, '0')) {
                $processedNumber = '62' . substr($cleanedNumber, 1);
            } else {
                $processedNumber = '62' . $cleanedNumber;
            }

            $response = Http::timeout(10)->post(env("URL_WHATSAPP"), [
                "number" => $processedNumber,
                "message" => $message,
            ]);

            if (!$response->successful()) {
                Log::error("Gagal mengirim pesan ke {$processedNumber}. Response: " . $response->body());
                return false;
            }
            return true;
        } catch (\Exception $e) {
            Log::error("Error saat mengirim pesan ke {$number}: " . $e->getMessage());
            return false;
        }
    }
}
