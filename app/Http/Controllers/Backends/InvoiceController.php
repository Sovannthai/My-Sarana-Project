<?php

namespace App\Http\Controllers\Backends;

use Exception;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Payment;
use App\Helpers\PdfGenerator;
use App\Notifications\InvoicePaid;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Models\UserContract;
use GuzzleHttp\Exception\RequestException;

class InvoiceController extends Controller
{
    public function sendInvoiceToTelegram($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $contract = UserContract::where('user_id', $user->id)->first();
            $invoiceData = Payment::with('paymentamenities', 'userContract', 'paymentutilities')->where('user_contract_id', $contract->id)->latest()->first();
            $pdfPath = PdfGenerator::generatePdf('backends.invoice._invoice', ['invoiceData' => $invoiceData, 'user' => $user], "invoice_{$user->id}");

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

        return redirect()->route('payments.index')->with($data);
    }
    public function downloadInvoice($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $contract = UserContract::where('user_id', $user->id)->first();
            $invoiceData = Payment::with('paymentamenities', 'userContract', 'paymentutilities')->where('user_contract_id', $contract->id)->latest()->first();

            $pdfPath = PdfGenerator::generatePdf('backends.invoice._invoice', ['invoiceData' => $invoiceData, 'user' => $user], "invoice_{$user->id}");

            if (file_exists($pdfPath)) {
                return response()->download($pdfPath, "invoice_{$user->name}.pdf")->deleteFileAfterSend(true);
            } else {
                return response()->json(['message' => 'PDF file not found.'], 404);
            }
        } catch (Exception $e) {
            dd($e);
            return redirect()->route('payments.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
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
    public function viewInvoiceDetails($userId)
    {
        $user = User::findOrFail($userId);
        $contract = UserContract::where('user_id', $user->id)->first();
        $invoiceData = Payment::with('paymentamenities', 'userContract', 'paymentutilities')->where('user_contract_id', $contract->id)->latest()->first();

        return view('backends.payment.partial.payment_details', compact('user', 'invoiceData'));
    }

    public function printInvoice($userId)
    {
        $user = User::findOrFail($userId);
        $contract = UserContract::where('user_id', $user->id)->first();
        $invoiceData = Payment::with('paymentamenities', 'userContract', 'paymentutilities')
            ->where('user_contract_id', $contract->id)
            ->latest()
            ->first();

        return view('backends.invoice._invoice_slim', compact('user', 'invoiceData'));
    }
    public function downloadUtilitiesInvoice($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $contract = UserContract::where('user_id', $user->id)->first();
            $invoiceData = Payment::with('paymentamenities', 'userContract', 'paymentutilities')->where('user_contract_id', $contract->id)->latest()->first();

            $pdfPath = PdfGenerator::generatePdf('backends.invoice._utilities_invoice', ['invoiceData' => $invoiceData, 'user' => $user], "utilities_invoice_{$user->id}");

            if (file_exists($pdfPath)) {
                return response()->download($pdfPath, "utilities_invoice_{$user->name}.pdf")->deleteFileAfterSend(true);
            } else {
                return response()->json(['message' => 'PDF file not found.'], 404);
            }
        } catch (Exception $e) {
            dd($e);
            return redirect()->route('payments.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

}
