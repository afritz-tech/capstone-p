<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'birthDate',
        'profilePicture',
        'isSelfPay',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birthDate' => 'date',
        'isSelfPay' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

}