<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'sliders' => 'array',
    ];
    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id')->with('children');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function project()
    {
        return $this->hasMany(Project::class);
    }
    public function newsletters()
    {
        return $this->hasMany(Newsletter::class);
    }
    public function calendar()
    {
        return $this->hasMany(CalendarEvent::class);
    }
}
