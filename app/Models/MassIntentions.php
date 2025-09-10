<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MassIntentions extends Model
{
    /** @use HasFactory<\Database\Factories\MassIntentionsFactory> */
    use HasFactory;


    protected $fillable = [
        'first_name',
        'last_name',
        'city',
        'state',
        'zip',
        'phone',
        'email',
        'details',
    ];
}
