<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingGuests extends Model
{
    protected $fillable = ['adults', 'children', 'infants', 'total_count', 'listing_id'];
}
