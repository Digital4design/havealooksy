<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listings extends Model
{
	use SoftDeletes;
    protected $fillable = ['title', 'description', 'location', 'price', 'category_id', 'status', 'user_id', 'deleted_by'];

    public function getCategory()
    {
    	return $this->belongsTo('App\Models\Categories', 'category_id');
    }

    public function getListerRole()
    {
    	return $this->hasOneThrough('App\Role', 'App\Models\UserRoleRelation', 'user_id', 'id', 'user_id', 'role_id');
    }

    public function getImages()
    {
        return $this->hasMany('App\Models\ListingImages', 'listing_id');
    }
}
