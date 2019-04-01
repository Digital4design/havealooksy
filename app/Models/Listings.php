<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listings extends Model
{
    protected $fillable = ['title', 'description', 'location', 'image', 'price', 'category_id', 'status'];

    public function getCategory()
    {
    	return $this->belongsTo('App\Models\Categories', 'category_id');
    }

    public function getListerRole()
    {
    	return $this->hasOneThrough('App\Role', 'App\Models\UserRoleRelation', 'user_id', 'id', 'user_id', 'role_id');
    }
}
