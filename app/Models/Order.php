<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable =['product_id','order_status'];


    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
