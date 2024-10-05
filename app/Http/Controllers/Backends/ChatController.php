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
        return view('backends.chat.index', compact('row_chats',));
    }
    public function chatDetail($id)
    {
        $chateDeatail = Message::findOrFail($id);
        return view('backends.chat.layout.sidebar',compact('chateDeatail'));
    }
    public function fetchMessages()
    {
        $token = '6892001713:AAEFqGqO4bqaQmNx465sQxV-Z6Cq-HHQCsw';
        $url = 'https://api.telegram.org/bot' . $token . '/getUpdates';
        $response = Http::get($url, [
            'offset' => $this->getLastUpdateId() + 1,
        ]);

        $updates = $response->json();

        if (isset($updates['result']) && is_array($updates['result'])) {
            foreach ($updates['result'] as $update) {
                if (isset($update['message'])) {
                    $message = $update['message'];
                    $updateId = $update['update_id'];
                    $messageId = $message['message_id'];
                    $chatId = $message['chat']['id'];
                    $userId = $message['from']['id'];
                    $firstName = $message['from']['first_name'] ?? null;
                    $username = $message['from']['username'] ?? null;

                    if (isset($message['text'])) {
                        $userMessage = $message['text'];
                        if (!Message::where('update_id', $updateId)->exists()) {
                            Message::create([
                                'update_id' => $updateId,
                                'message_id' => $messageId,
                                'chat_id' => $chatId,
                                'user_id' => $userId,
                                'first_name' => $firstName,
                                'username' => $username,
                                'message' => $userMessage,
                            ]);
                        }
                    } elseif (isset($message['photo'])) {
                        $photo = $message['photo'];
                        $fileId = end($photo)['file_id'];
                        $filePath = $this->downloadFile($fileId, $token);
                        if (!Message::where('update_id', $updateId)->exists()) {
                            Message::create([
                                'update_id' => $updateId,
                                'message_id' => $messageId,
                                'chat_id' => $chatId,
                                'user_id' => $userId,
                                'first_name' => $firstName,
                                'username' => $username,
                                'message' => 'Photo received',
                                'media_path' => $filePath,
                            ]);
                        }
                    } else {
                        Log::info('Non-text message received: ', $message);
                    }
                } else {
                    Log::info('Update does not contain a message: ', $update);
                }
            }
        } else {
            Log::error('Invalid response from Telegram API: ', $updates);
        }
    }
    private function downloadFile($fileId, $token)
    {
        $fileUrl = 'https://api.telegram.org/bot' . $token . '/getFile?file_id=' . $fileId;
        $fileResponse = Http::get($fileUrl);
        $fileData = $fileResponse->json();

        if (isset($fileData['result']['file_path'])) {
            $filePath = $fileData['result']['file_path'];
            $fileUrl = 'https://api.telegram.org/file/bot' . $token . '/' . $filePath;
            $localPath = 'uploads/telegram-chat/' . basename($filePath);
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

    protected function sendMessage($chatId, $text)
    {
        $token = '6892001713:AAEFqGqO4bqaQmNx465sQxV-Z6Cq-HHQCsw';
        $url = 'https://api.telegram.org/bot' . $token . '/sendMessage';

        Http::post($url, [
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }

}
