<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'telegram_user_id',
        'sleep_hours',
        'exercise_duration',
        'water_intake',
        'date',
    ];


    public function belongsTo(): BelongsTo
    {
        return $this->belongsTo(TelegramUser::class);
    }
}
