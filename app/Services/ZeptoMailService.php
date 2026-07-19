<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZeptoMailService
{
    /**
     * Send an email using ZeptoMail API.
     *
     * @param string $toEmail
     * @param string $toName
     * @param string $subject
     * @param string $htmlBody
     * @return bool
     */
    public static function sendEmail(string $toEmail, string $toName, string $subject, string $htmlBody): bool
    {
        $url = env('ZEPTOMAIL_URL', 'https://api.zeptomail.in/v1.1/email');
        $apiKey = env('ZEPTOMAIL_API_KEY');
        // Clean the API key in case the user pasted the prefix into the .env
        if ($apiKey) {
            $apiKey = trim(str_replace('Zoho-enczapikey ', '', $apiKey));
        }

        $fromEmail = env('ZEPTOMAIL_FROM_ADDRESS', 'noreply@sabinpanthi.com.np');

        if (!$apiKey) {
            throw new \Exception('ZeptoMail API key is not configured in .env');
        }

        try {
            $curl = curl_init();

            $payload = json_encode([
                "from" => [
                    "address" => $fromEmail
                ],
                "to" => [
                    [
                        "email_address" => [
                            "address" => $toEmail,
                            "name" => $toName ?: 'User'
                        ]
                    ]
                ],
                "subject" => $subject,
                "htmlbody" => $htmlBody,
            ]);

            if ($payload === false) {
                throw new \Exception('Failed to JSON encode the email payload: ' . json_last_error_msg());
            }

            curl_setopt_array($curl, array(
                CURLOPT_URL => trim($url),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => array(
                    "accept: application/json",
                    "authorization: Zoho-enczapikey " . $apiKey,
                    "cache-control: no-cache",
                    "content-type: application/json",
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);

            if ($err) {
                throw new \Exception('cURL Error: ' . $err);
            }

            if ($httpcode >= 400) {
                // If it's HTML, we'll just show a generic error to not clutter the screen with raw HTML tags
                if (str_contains($response, '<html')) {
                    throw new \Exception("ZeptoMail API Error (HTTP $httpcode): The ZeptoMail server rejected the request. Please check if your ZEPTOMAIL_URL and ZEPTOMAIL_API_KEY are absolutely correct in your .env file.");
                }
                throw new \Exception('ZeptoMail API Error (HTTP ' . $httpcode . '): ' . $response);
            }

            return true;
        } catch (\Exception $e) {
            throw new \Exception('ZeptoMail Exception: ' . $e->getMessage());
        }
    }
}
