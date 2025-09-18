<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = ['title','page_id', 'file_path'];



    public function page()
    {
        $this->belongsTo(Page::class, 'page_id');
    }
}
