<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait WhatsappNotificationTrait
{
    public function whatsappNotification(string $recipient, string $message = '', $file = null)
    {
        $formData = [
            'message' => $message,
            'number' => $recipient,
        ];

        $url = env('WA_API') . '/send-message';

        if ($file != null) {
            Http::post($url, $formData);
            $response = Http::attach(
                'file_dikirim',
                file_get_contents($file),
                $file
            )->asMultipart()->post($url, $formData);
        } else {
            // send data to server
            $response = Http::post($url, $formData);
        }

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json(['error' => 'Failed to send message'], 500);
        }
    }
}
