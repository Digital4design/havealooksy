<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
	public $timestamps = false;
    protected $fillable = ['order_item', 'order_id'];
}
