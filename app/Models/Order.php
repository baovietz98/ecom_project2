<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'fullname',
        'email',
        'phone',
        'address',
        'note',
        'status',
        'total_money',
        'order_date',
    ];

    // Định nghĩa quan hệ với OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id'); // order_id là khóa ngoại trong bảng order_details
    }
}
