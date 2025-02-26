<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class External extends Model
{
    public function sentOutgoingLetters()
    {
        return $this->hasMany(OutgoingLetter::class, 'external_sender_id');
    }

    public function receivedOutgoingLetters()
    {
        return $this->hasMany(OutgoingLetter::class, 'external_recipient_id');
    }
}
