<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=['title','status','sub_category_id'];
    
    public function subCategories()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
