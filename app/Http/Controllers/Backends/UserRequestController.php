<?php

namespace App\Http\Controllers\Backends;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UserRequestController extends Controller
{
    public function index()
    {
        $user_requests = User::with('messages')
            ->whereHas('messages')
            ->get(['telegram_id as user_id', 'name', 'username', 'avatar']);

        return view('backends.request.index', compact('user_requests'));
    }
    public function getMessage($userId)
    {
        $currentUserId = '1';

        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId);
        })
            ->orderBy('created_at', 'asc')
            ->get(['id', 'sender_id', 'receiver_id', 'message', 'media_path', 'created_at']);
        foreach ($messages as $message) {
            $message->media_path  = $message->media_path ? asset($message->media_path) : null;
            $message->sender_type = $message->sender_id == $currentUserId ? 'sent' : 'received';
        }

        return response()->json($messages);
    }


    //Send Message
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message'    => 'required|string|max:255',
            'media_part' => 'nullable|file|mimes:jpg,jpeg,png,doc,docx,pdf',
        ]);

        $userId       = $request->input('user_id');
        $messageText  = $request->input('message');
        $filePath     = null;
        if ($request->hasFile('media_part')) {
            $file     = $request->file('media_part');
            $filePath = $file->store('uploads', 'public');

            // Send the file to Telegram
            $this->sendFileToTelegram($userId, $filePath, $messageText);
        } else {
            // If no file, just send the message
            $this->sendMessageToTelegram($userId, $messageText);
        }

        // Store
        Message::create([
            'user_id'      => $userId,
            'sender_id'    => '1',
            'receiver_id'  => $userId,
            'message'      => $messageText,
            'sender_type'  => 'sent',
            'media_path'   => $filePath ? 'uploads/' . $filePath : null,
        ]);

        return response()->json(['message' => $messageText, 'user_id' => $userId], 200);
    }

    private function sendMessageToTelegram($userId, $messageText)
    {
        $chatId  = $userId;
        $token   = '6892001713:AAEFqGqO4bqaQmNx465sQxV-Z6Cq-HHQCsw';
        $url     = 'https://api.telegram.org/bot' . $token . '/sendMessage';

        $payload = [
            'chat_id'    => $chatId,
            'text'       => $messageText,
            'parse_mode' => 'HTML', // Optional
        ];
        Http::post($url, $payload);
    }
    private function sendFileToTelegram($userId, $filePath, $messageText)
    {
        $chatId = $userId;
        $token = '6892001713:AAEFqGqO4bqaQmNx465sQxV-Z6Cq-HHQCsw';

        $localDirectory = public_path('uploads/telegram-chat/');
        if (!file_exists($localDirectory)) {
            mkdir($localDirectory, 0755, true);
        }

        $fileName        = basename($filePath);
        $storageFilePath = 'uploads/telegram-chat/' . $fileName;

        // Move the file to the public storage directory
        Storage::disk('public')->move($filePath, $storageFilePath);

        $fileInStorage = storage_path('app/public/' . $storageFilePath);
        $localFilePath = $localDirectory . $fileName;

        if (file_exists($fileInStorage)) {
            rename($fileInStorage, $localFilePath);
        }

        if (file_exists($localFilePath)) {
            Log::info('File exists: ' . $localFilePath);
        } else {
            Log::error('File does not exist: ' . $localFilePath);
            return null;
        }

        $response = Http::attach('document', file_get_contents($localFilePath), $fileName)
            ->post('https://api.telegram.org/bot' . $token . '/sendDocument', [
                'chat_id' => $chatId,
                'caption' => $messageText,
            ]);
        $responseData = $response->json();
        Log::info('Telegram Response: ', $responseData);

        if (isset($responseData['result']['document']['file_id'])) {
            return $localFilePath;
        }
        if (!$response->successful()) {
            Log::error('Error sending document to Telegram: ' . $response->body());
        }

        return null;
    }

}
