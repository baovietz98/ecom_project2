<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product'; // Chỉ định tên bảng

    protected $fillable = [
        'category_id',
        'title',
        'price',
        'discount',
        'thumbnail',
        'description',
        'brand_id',
        'product_code',
    ];
    public function brand() {
        return $this->belongsTo(Brand::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class); // Giả sử rằng 'Image' là mô hình hình ảnh của bạn
    }
}
