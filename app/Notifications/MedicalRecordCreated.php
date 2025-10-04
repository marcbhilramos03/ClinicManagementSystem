<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MedicalRecordCreated extends Notification
{
    use Queueable;

    protected $record;

    public function __construct($record)
    {
        $this->record = $record;
    }

    public function via($notifiable)
    {
        return ['database']; // store in DB
    }

    public function toDatabase($notifiable)
    {
        return [
            'message'   => "A new medical record has been created for you.",
            'diagnosis' => $this->record->diagnosis,
            'treatment' => $this->record->treatment,
            'date'      => $this->record->date,
        ];
    }
}
