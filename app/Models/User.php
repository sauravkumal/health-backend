<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'vendor_id',
        'description',
        'address',
        'lat',
        'lng',
        'phone_no',
        'opening_hours',
        'publish_menu'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_no' => 'array',
        'opening_hours' => 'array',
        'publish_menu' => 'boolean',
        'active' => 'boolean',
        'online' => 'boolean'
    ];

    public static function vendor(): Builder
    {
        return self::query()->where('role', 'vendor');
    }

    public static function admin(): Builder
    {
        return self::query()->where('role', 'admin');
    }

    public function menu(): HasOne
    {
        return $this->hasOne(Menu::class, 'vendor_id');
    }
}
