<?php

namespace App\Console\Commands;

use App\Models\Message;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TelegramPoll extends Command
{
    protected $signature = 'telegram:poll';
    protected $description = 'Poll Telegram for new messages';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $token = '6892001713:AAEFqGqO4bqaQmNx465sQxV-Z6Cq-HHQCsw'; // Replace with your actual token
        $url = 'https://api.telegram.org/bot' . $token . '/getUpdates';

        // Fetch the updates from Telegram
        $response = Http::get($url, [
            'offset' => $this->getLastUpdateId() + 1, // Start from last update
        ]);

        $updates = $response->json();

        if (isset($updates['result']) && is_array($updates['result'])) {
            foreach ($updates['result'] as $update) {
                // Ensure the update contains a message
                if (isset($update['message'])) {
                    $message = $update['message'];

                    // Extract relevant data from the message
                    $updateId = $update['update_id'];
                    $messageId = $message['message_id'];
                    $chatId = $message['chat']['id'];
                    $userId = $message['from']['id'];
                    $firstName = $message['from']['first_name'] ?? null;
                    $username = $message['from']['username'] ?? null;

                    // Check if 'text' key exists
                    if (isset($message['text'])) {
                        $userMessage = $message['text'];

                        // Check if this update has already been processed
                        if (!Message::where('update_id', $updateId)->exists()) {
                            // Store the message securely
                            Message::create([
                                'update_id' => $updateId,
                                'message_id' => $messageId,
                                'chat_id' => $chatId,
                                'user_id' => $userId,
                                'first_name' => $firstName,
                                'username' => $username,
                                'message' => $userMessage,
                            ]);

                            // Acknowledgment is removed, so do not send a message back
                            // $this->sendMessage($chatId, 'Message received: ' . $userMessage);
                        }
                    } else {
                        // Log that the message is not a text message
                        Log::info('Non-text message received: ', $message);
                    }
                } else {
                    // Log updates without a message
                    Log::info('Update does not contain a message: ', $update);
                }
            }
        } else {
            // Log an error if the response structure is invalid
            Log::error('Invalid response from Telegram API: ', $updates);
        }
    }

    protected function getLastUpdateId()
    {
        // Return the highest update_id or 0 if no messages have been processed
        return Message::max('update_id') ?? 0;
    }

    protected function sendMessage($chatId, $text)
    {
        $token = '6892001713:AAEFqGqO4bqaQmNx465sQxV-Z6Cq-HHQCsw'; // Replace with your actual token
        $url = 'https://api.telegram.org/bot' . $token . '/sendMessage';

        Http::post($url, [
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }
}
