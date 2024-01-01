<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class TelegramUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'telegram_id',
        'first_name',
        'last_name',
        'display_name',
        'username',
        'dob',
        'gender',
        'reminder'
    ];

    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => !empty($attributes['dob']) ?
                Carbon::parse($attributes['dob'])->diffInYears() . ' years' : null,
        );
    }

    public function records(): HasMany
    {
        return $this->hasMany(Record::class, 'telegram_user_id', 'id');
    }
}
