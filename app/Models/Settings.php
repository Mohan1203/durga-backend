<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class Settings extends Model
{
    protected $fillable = [
        'logo',
        'years_experience',
        'global_partners',
        'products_count',
        'state_image',
        'phone',
        'email',
        'address',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'youtube',
    ];

    protected $table = 'settings';
}