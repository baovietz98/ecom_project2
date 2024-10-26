<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    // Chỉ định tên bảng
    protected $table = 'category';
    protected $fillable = [
        'name',
    ];
    // Tắt tính năng timestamps
    public $timestamps = false;
}
