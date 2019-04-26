<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = ['order_number', 'user_id', 'order_amount', 'order_status'];

    public function getOrderItems()
    {
    	return $this->hasMany('App\Models\OrderItems', 'order_id');
    }
}
