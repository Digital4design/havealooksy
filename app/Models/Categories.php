<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['name', 'parent_id', 'status', 'image'];

    public function parentCategory()
    {
    	return $this->hasOne('App\Models\Categories', 'id', 'parent_id');
    }

    public function childCategories()
    {
    	return $this->hasMany('App\Models\Categories', 'parent_id', 'id');
    }
}
