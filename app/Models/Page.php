<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'other_images' => 'array',
        'sliders' => 'array',
    ];

    public function link()
    {
        return $this->belongsTo(Route_link::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
