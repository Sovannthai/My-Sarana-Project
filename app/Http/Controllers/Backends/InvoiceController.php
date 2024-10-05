<?php

namespace App\Http\Controllers\Backends;

use Exception;
use App\Models\User;
use GuzzleHttp\Client;
use App\Helpers\PdfGenerator;
use App\Notifications\InvoicePaid;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\RequestException;

class InvoiceController extends Controller
{
    public function sendInvoiceToTelegram($userId)
    {
        try {
            $user = User::findOrFail($userId);

            $invoiceData = [
                'user' => $user,
                'invoice' => [
                    'id' => 123,
                    'amount' => 100,
                ],
            ];

            $pdfPath = PdfGenerator::generatePdf('backends.invoice._invoice', $invoiceData, "invoice_{$user->id}");
            if (file_exists($pdfPath)) {
                $this->sendTelegramInvoice($user->telegram_id, $pdfPath);
            } else {
                return response()->json(['message' => 'PDF file not found.'], 404);
            }
            $user->notify(new InvoicePaid((object) [
                'id' => 123,
                'amount' => 100,
            ]));

            $data = ['success' => 'Invoice sent successfully'];

        } catch (Exception $e) {
            dd($e);
            $data = ['error' => 'Something went wrong'];
        }

        return redirect()->route('users.index')->with($data);
    }

    protected function sendTelegramInvoice($telegramUserId, $filePath)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = $telegramUserId;
        $url = "https://api.telegram.org/bot{$botToken}/sendDocument";

        $client = new Client();

        try {
            $file = fopen($filePath, 'r');

            $response = $client->post($url, [
                'multipart' => [
                    [
                        'name' => 'chat_id',
                        'contents' => $chatId,
                    ],
                    [
                        'name' => 'document',
                        'contents' => fopen($filePath, 'r'),
                        'filename' => basename($filePath),
                    ],
                    [
                        'name' => 'caption',
                        'contents' => 'Here is your invoice.',
                    ],
                ],
            ]);
            fclose($file);

            return json_decode($response->getBody());

        } catch (RequestException $e) {
            return response()->json(['message' => 'Error sending invoice: ' . $e->getMessage()], 500);
        }
    }

}
