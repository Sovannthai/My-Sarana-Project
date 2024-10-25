<?php

namespace App\Observers;

use App\Models\Message;

class NotificationObserver
{
    /**
     * Handle the Message "created" event.
     */
    public function created(Message $message): void
    {
        $unreadCount = Message::where('is_read', '0')->count();
        session(['unread_messages_count' => $unreadCount]);
    }

    /**
     * Handle the Message "updated" event.
     */
    public function updated(Message $message): void
    {
        if ($message->isDirty('is_read')) {
            $unreadCount = Message::where('is_read', '0')
                ->count();

            session(['unread_messages_count' => $unreadCount]);
        }
    }

    /**
     * Handle the Message "deleted" event.
     */
    public function deleted(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "restored" event.
     */
    public function restored(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     */
    public function forceDeleted(Message $message): void
    {
        //
    }
}
