<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentScheduled extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // also possible: 'broadcast'
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Appointment Scheduled')
            ->line('You have an appointment scheduled at: ' . $this->appointment->scheduled_at)
            ->line('Title: ' . $this->appointment->title)
            ->action('View Appointments', url('/appointments'));
    }

    public function toArray($notifiable)
    {
        return [
            'appointment_id' => $this->appointment->id,
            'title' => $this->appointment->title,
            'scheduled_at' => $this->appointment->scheduled_at,
        ];
    }
}

