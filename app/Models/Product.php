<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable =['title','price','discount'];

    public function Orders(){
        return $this->hasMany(Order::class,'product_id');
    }
}
