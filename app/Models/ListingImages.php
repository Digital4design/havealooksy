<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingImages extends Model
{
	protected $table = 'listing_images';
    protected $fillable = ['name', 'listing_id'];
}
