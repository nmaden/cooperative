<?php

namespace App\Notifications;

    use Illuminate\Bus\Queueable;
    use Illuminate\Notifications\Notification;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Notifications\Messages\MailMessage;
    use App\User;

class NewMessage extends Notification
{
    use Queueable;
    public $fromUser;

    public function __construct(User $user)
    {
        $this->fromUser = $user;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        $subject = sprintf('%s: You\'ve got a new message from %s!', config('app.name'), $this->fromUser->name);
        $greeting = sprintf('Hello %s!', $notifiable->name);

        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->salutation('Yours Faithfully')
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
