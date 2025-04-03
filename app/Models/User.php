<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
       return in_array($this->role, ['sekretariat', 'unit_internal']);
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->password)) {
                $user->password = bcrypt('12345678');
            }
        });
    }

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
