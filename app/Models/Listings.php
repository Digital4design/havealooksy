<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listings extends Model
{
    protected $fillable = ['title', 'description', 'location', 'image', 'price', 'category_id', 'status'];
}
