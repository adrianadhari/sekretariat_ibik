<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    
    use HasFactory, Notifiable;

    public function isSekretariat(): bool
    {
        return $this->role === 'sekretariat';
    }

    public function letterNumberRequests()
    {
        return $this->hasMany(LetterNumberRequest::class);
    }

    public function sentOutgoingLetters()
    {
        return $this->hasMany(OutgoingLetter::class, 'internal_sender_id');
    }

    public function receivedOutgoingLetters()
    {
        return $this->hasMany(OutgoingLetter::class, 'internal_recipient_id');
    }
}
