<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Appointment;

class AppointmentStatusUpdatedNotification extends Notification
{
    use Queueable;

    public $appointment;
    public $action;

    public function __construct(Appointment $appointment, string $action)
    {
        $this->appointment = $appointment;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $clinic = config('clinic.name');
        $subject = $this->action === 'accepted'
            ? 'Appointment Approved - '.$clinic
            : 'Appointment Update - '.$clinic;

        return (new MailMessage)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($subject)
            ->view('emails.appointment-status-updated', [
                'appointment' => $this->appointment,
                'action' => $this->action
            ]);
    }
}
