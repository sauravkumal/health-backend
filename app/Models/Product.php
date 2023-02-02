<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category_id', 'vendor_id', 'position'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
