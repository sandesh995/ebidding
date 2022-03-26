<?php

namespace App\Notifications;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SuccessfulListingNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Listing $listing,
    ) {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage);
        $message = $message->line('The listing you have posted has been completed!');

        if ($this->listing->largest_bid) {
            $largest_bid = $this->listing->largest_bid;
            $bids = $this->listing->bids()->count();

            $message = $message->line('There were total of ' . $bids . ' bids!');
            $message = $message->line('Your listing collected the higest bid of Rs. ' . $largest_bid . '!');
            $message  = $message->line('Congratulations on your successful listing! We will contact you shortly about product delivery and complete this auction!');
        } else {
            $message = $message->line('Unfortunately, no one has placed any bids this time!');
        }

        $message =  $message->action('View Listing Information', url('/listing/' . $this->listing->id))
            ->action('Your Balance', url('/balance'))
            ->line('Thank you for using our application!');
        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
