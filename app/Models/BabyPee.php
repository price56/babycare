<?php

namespace App\Models;

use App\Casts\DateTimeStringCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabyPee extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => DateTimeStringCast::class,
        'updated_at' => DateTimeStringCast::class,
        'email_verified_at' => DateTimeStringCast::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
