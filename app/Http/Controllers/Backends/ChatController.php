<?php

namespace App\Http\Controllers\Backends;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\MessageReceived;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function chatIndex()
    {
        $row_chats = Message::select('messages.user_id', 'messages.first_name', 'messages.username', 'users.avatar')
            ->join('users', 'users.telegram_id', '=', 'messages.user_id')
            ->groupBy('messages.user_id', 'messages.first_name', 'messages.username', 'users.avatar')
            ->get();
        return view('backends.chat.index', compact('row_chats', ));
    }
    public function chatDetail($id)
    {
        $chateDeatail = Message::findOrFail($id);
        return view('backends.chat.layout.sidebar', compact('chateDeatail'));
    }
    public function fetchMessages()
    {
        $token       = '6892001713:AAEFqGqO4bqaQmNx465sQxV-Z6Cq-HHQCsw';
        $url         = 'https://api.telegram.org/bot' . $token . '/getUpdates';
        $response    = Http::get($url, [
            'offset' => $this->getLastUpdateId() + 1,
        ]);

        $updates     = $response->json();

        if (isset($updates['result']) && is_array($updates['result'])) {
            foreach ($updates['result'] as $update) {
                if (isset($update['message'])) {
                    $this->storeIncomingMessage($update);
                }
            }
        }
    }


    private function storeIncomingMessage($update)
    {
        $message = $update['message'];
        $updateId = $update['update_id'];
        $messageId = $message['message_id'];
        $chatId = $message['chat']['id'];
        $userId = $message['from']['id'];
        $firstName = $message['from']['first_name'] ?? null;
        $username = $message['from']['username'] ?? null;
        $created_at = $message['date'];

        if (isset($message['text'])) {
            $userMessage = $message['text'];
            if (!Message::where('update_id', $updateId)->exists()) {
                Message::create([
                    'update_id'   => $updateId,
                    'message_id'  => $messageId,
                    'chat_id'     => $chatId,
                    'user_id'     => $userId,
                    'first_name'  => $firstName,
                    'username'    => $username,
                    'message'     => $userMessage,
                    'direction'   => 'incoming',
                    'sender_id'   => $userId,
                    'receiver_id' => '1',
                    'sender_type' =>'received',
                    'created_at'  => now(),
                ]);
            }
        } elseif (isset($message['photo'])) {
            $photo = $message['photo'];
            $fileId = end($photo)['file_id'];
            $token = '6892001713:AAEFqGqO4bqaQmNx465sQxV-Z6Cq-HHQCsw';
            $filePath = $this->downloadFile($fileId, $token);
            if (!Message::where('update_id', $updateId)->exists()) {
                Message::create([
                    'update_id'    => $updateId,
                    'message_id'   => $messageId,
                    'chat_id'      => $chatId,
                    'user_id'      => $userId,
                    'first_name'   => $firstName,
                    'username'     => $username,
                    'message'      => 'Photo received',
                    'media_path'   => $filePath,
                    'direction'    => 'incoming',
                    'sender_id'    => $userId,
                    'receiver_id'  => '1',
                    'sender_type'  =>'received',
                    'type'         => 'photo',
                    'created_at'   => now(),
                ]);
            }
        }
    }

    protected function sendMessage($chatId, $text)
    {
        $token = '6892001713:AAEFqGqO4bqaQmNx465sQxV-Z6Cq-HHQCsw';
        $url   = 'https://api.telegram.org/bot' . $token . '/sendMessage';

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text'    => $text,
        ]);

        $status = $response->successful() ? 'sent' : 'failed';

        // Store the outgoing message
        Message::create([
            'chat_id'    => $chatId,
            'message'    => $text,
            'direction'  => 'outgoing',
            'type'       => 'text',
            'status'     => $status,
            'created_at' => now(),
        ]);
    }
    private function downloadFile($fileId, $token)
    {
        $fileUrl      = 'https://api.telegram.org/bot' . $token . '/getFile?file_id=' . $fileId;
        $fileResponse = Http::get($fileUrl);
        $fileData     = $fileResponse->json();

        if (isset($fileData['result']['file_path'])) {
            $filePath    = $fileData['result']['file_path'];
            $fileUrl     = 'https://api.telegram.org/file/bot' . $token . '/' . $filePath;
            $localPath   = 'uploads/telegram-chat/' . basename($filePath);
            $fileContent = file_get_contents($fileUrl);
            file_put_contents(public_path($localPath), $fileContent);

            return $localPath;
        }

        return null;
    }

    protected function getLastUpdateId()
    {
        return Message::max('update_id') ?? 0;
    }

}
