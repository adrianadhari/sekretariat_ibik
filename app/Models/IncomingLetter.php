<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingLetter extends Model
{
    // Relasi ke pengirim internal
    public function internalSender()
    {
        return $this->belongsTo(User::class, 'internal_sender_id');
    }

    // Relasi ke pengirim eksternal
    public function externalSender()
    {
        return $this->belongsTo(External::class, 'external_sender_id');
    }

    // Relasi ke penerima surat (Unit Internal atau Sekretariat)
    public function recipients()
    {
        return $this->belongsToMany(User::class, 'incoming_letter_recipient', 'incoming_letter_id', 'recipient_id');
    }

    public function getSenderNameAttribute()
    {
        if ($this->sender_type === 'Internal') {
            return $this->internalSender->name ?? 'N/A';
        } elseif ($this->sender_type === 'External') {
            return $this->externalSender->name ?? 'N/A';
        }
        return 'Unknown';
    }
}
