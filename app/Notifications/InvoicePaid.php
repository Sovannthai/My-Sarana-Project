<?php

namespace App\Notifications;

use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    protected $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $url = asset('uploads/pdf/' . $this->invoice->id);

        return TelegramMessage::create()
            ->to($notifiable->telegram_id)
            ->content("Hello there!")
            ->line("Please check your invoice details and pay back to me!")
            // ->lineIf($this->invoice->amount > 0, "Amount paid: {$this->invoice->amount}")
            ->line("Thank you!")
            ->button('View Invoice', $url)
            ->button('Download Invoice', $url);
    }
}

