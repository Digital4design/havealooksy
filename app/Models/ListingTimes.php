<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingTimes extends Model
{
    protected $fillable = ['start_time', 'end_time', 'listing_id'];
}
