<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'policyNumber',
        'coverageType',
        'validUntil'
    ];

    protected $casts = [
        'validUntil' => 'date:Y-m-d'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
