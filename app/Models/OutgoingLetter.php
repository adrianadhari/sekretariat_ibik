<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingLetter extends Model
{
    // Relasi ke User sebagai pengirim internal
    public function internalSender()
    {
        return $this->belongsTo(User::class, 'internal_sender_id');
    }

    // Relasi ke User sebagai penerima internal
    public function internalRecipient()
    {
        return $this->belongsTo(User::class, 'internal_recipient_id');
    }

    // Relasi ke External sebagai pengirim eksternal
    public function externalSender()
    {
        return $this->belongsTo(External::class, 'external_sender_id');
    }

    // Relasi ke External sebagai penerima eksternal
    public function externalRecipient()
    {
        return $this->belongsTo(External::class, 'external_recipient_id');
    }
}
