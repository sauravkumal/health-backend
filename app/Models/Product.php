<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['title', 'category_id', 'vendor_id', 'position'];

    protected $appends = ['image_url'];

    protected function imageUrl(): Attribute
    {
        $imageUrl = function ($value) {
            $image = $this->getFirstMedia('image');
            if ($image) {
                return $image->getFullUrl();
            }
            return null;
        };
        return Attribute::make(
            get: $imageUrl,
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
