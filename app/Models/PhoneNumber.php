<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhoneNumber extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'phone_number',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone_number' => 'string',
        'user_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Validation rules for the phone number model.
     *
     * @var array<string, string>
     */
    public static $rules = [
        'phone_number' => 'required|string|max:20|unique:phone_numbers,phone_number',
        'user_id' => 'required|exists:users,id'
    ];

    /**
     * Get the user that owns the phone number.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include active phone numbers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Format the phone number.
     *
     * @return string
     */
    public function getFormattedPhoneNumberAttribute(): string
    {
        // This is a placeholder. Implement your own formatting logic.
        return preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $this->phone_number);
    }
}