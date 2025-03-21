<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class ApplicationCategory extends Model
{
    use HasFactory;
    protected $table = 'application-categories';
    protected $fillable = ['name', 'image', 'slug'];

    public function products(): HasMany
    {
        return $this->hasMany(ApplicationProducts::class,'category_id');
    }

    // public function getImageAttribute($value)
    // {
    //     return url(Storage::url($value));
    // }
}