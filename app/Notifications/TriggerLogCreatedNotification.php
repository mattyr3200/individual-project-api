<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TriggerLogCreatedNotification extends Notification
{
    use Queueable;

    public $triggerLog;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($triggerLog)
    {
        $this->triggerLog = $triggerLog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->triggerLog->trigger->device->name . " has triggered an alert")
            ->greeting("Hello " . $this->triggerLog->trigger->device->user->name . ",")
            ->lines([
                "Trigger Notification",
                "Device Name: " . $this->triggerLog->trigger->device->name,
                "Device Site: " . $this->triggerLog->trigger->device->site,
                "Trigger Name: " . $this->triggerLog->trigger->name,
                "Trigger Description: " . $this->triggerLog->trigger->description,
                "Trigger Time: " . $this->triggerLog->created_at,
                "Thank you for using vision"
            ]);
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
