<?php

namespace App\Notifications;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BidWinnerNotification extends Notification
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
            ->line('Congratulations, you have won the bid!')
            ->line('We will contact you soon with the details regarding product delivery and completing this bid!')
            ->action('View Listing Details', url('/listings/' . $this->listing->id))
            ->line('Thank you for using our platform!');
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
