<?php

namespace App\Notifications;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BidLostNotification extends Notification
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
        return (new MailMessage)
            ->line('Hello, the listing you have placed your bid on has expired!')
            ->line('Listing: ' . $this->listing->name)
            ->line('Looks like, unfortunately, you have not won the bid!')
            ->line('All your amount deposited for bid has been refunded to your main balance!')
            ->action('View Your Balance', url('/balance'))
            ->action('View Listing Details', url('/listings/' . $this->listing->id))
            ->line('Thank you for using our platform! Good luck on your future bids!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
