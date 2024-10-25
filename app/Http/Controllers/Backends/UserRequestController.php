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
        $user_requests = User::withCount([
            'messages as unread_messages_count' => function ($query) {
                $query->where('is_read', '0');
            }
        ])
            ->whereHas('messages')
            ->get();

        return view('backends.request.index', compact('user_requests'));
    }

    public function getMessage($userId)
    {
        $currentUserId = '1';
        Message::where('is_read', '0')
            ->where('receiver_id', $currentUserId)
            ->where('sender_id', $userId)
            ->update(['is_read' => '1']);
        $messages = Message::where(function ($query) use ($userId, $currentUserId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $currentUserId)
                ->orWhere(function ($q) use ($userId, $currentUserId) {
                    $q->where('sender_id', $currentUserId)
                        ->where('receiver_id', $userId);
                });
        })
            ->orderBy('created_at', 'asc')
            ->get(['id', 'sender_id', 'receiver_id', 'message', 'media_path', 'created_at']);

        // Add additional data to each message.
        foreach ($messages as $message) {
            $message->media_path = $message->media_path ? asset($message->media_path) : null;
            $message->sender_type = $message->sender_id == $currentUserId ? 'sent' : 'received';
        }
        return response()->json($messages);
    }


    //Send Message
    public function sendMessage(Request $request)
    {
        $request->validate([
            // 'message' => 'required|string|max:255',
            // 'media_part' => 'nullable|file|mimes:jpg,jpeg,png,doc,docx,pdf,xls,xlsx',
        ]);

        $userId = $request->input('user_id');
        $messageText = $request->input('message');
        $filePath = null;

        if ($request->hasFile('media_part')) {
            $file = $request->file('media_part');
            $fileName = $file->getClientOriginalName();
            $filePath = 'uploads/telegram-chat/' . $fileName;
            $file->move(public_path('uploads/telegram-chat'), $fileName);
            $this->sendFileToTelegram($userId, $filePath, $messageText);
        } else {
            $this->sendMessageToTelegram($userId, $messageText);
        }

        Message::create([
            'user_id' => $userId,
            'sender_id' => '1',
            'receiver_id' => $userId,
            'is_read' => '1',
            'message' => $messageText,
            'sender_type' => 'sent',
            'media_path' => $filePath,
        ]);

        return response()->json(['message' => $messageText, 'user_id' => $userId], 200);
    }

    private function sendMessageToTelegram($userId, $messageText)
    {
        $chatId = $userId;
        $token = '6892001713:AAEFqGqO4bqaQmNx465sQxV-Z6Cq-HHQCsw';
        $url = 'https://api.telegram.org/bot' . $token . '/sendMessage';

        $payload = [
            'chat_id' => $chatId,
            'text' => $messageText,
            'parse_mode' => 'HTML',
        ];
        Http::post($url, $payload);
    }

    private function sendFileToTelegram($userId, $filePath, $messageText)
    {
        $chatId = $userId;
        $token = '6892001713:AAEFqGqO4bqaQmNx465sQxV-Z6Cq-HHQCsw';
        $localFilePath = public_path($filePath);

        if (!file_exists($localFilePath)) {
            Log::error('File does not exist: ' . $localFilePath);
            return null;
        }

        // Send the file to Telegram
        $response = Http::attach('document', file_get_contents($localFilePath), basename($filePath))
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
