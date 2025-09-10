<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route_link extends Model
{
    use HasFactory;

    public function page()
    {
        return $this->hasOne(Page::class);
    }

    public function parent()
    {
        return $this->belongsTo(Route_link::class, 'parent_id');
    }

    public function children()
    {
        // recursively load children
        return $this->hasMany(Route_link::class, 'parent_id')->with('children');
    }
}

