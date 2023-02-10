<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['title', 'category_id', 'vendor_id', 'position', 'pricing_types', 'pricing_details'];

    protected $casts = [
        'pricing_types' => 'array',
        'pricing_details' => 'array',
    ];
    protected $appends = ['thumb_image_url'];

    protected function thumbImageUrl(): Attribute
    {
        $imageUrl = function ($value) {
            $image = $this->getFirstMedia('image');
            return $image?->getFullUrl('thumb');
        };
        return Attribute::make(
            get: $imageUrl,
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)->nonQueued();
    }
}
