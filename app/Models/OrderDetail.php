<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'num',
        'total_money',
    ];
    // Định nghĩa quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
