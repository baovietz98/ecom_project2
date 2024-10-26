<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
        // Mối quan hệ giữa Cart và User
    public function user(){
        return $this->hasOne('App\models\User','id','user_id');
    }

        // Mối quan hệ giữa Cart và Product
    public function product(){
        return $this->hasOne('App\models\Product','id','product_id');
    }
}
