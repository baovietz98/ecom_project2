<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    // Định nghĩa các thuộc tính có thể gán hàng loạt
    protected $fillable = [
        'name', // Giả sử bạn có cột 'name' trong bảng brands
    ];
}
