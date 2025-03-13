<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplicationCategory extends Model
{
    use HasFactory;
    protected $table = 'application-categories';
    protected $fillable = ['name', 'image', 'slug'];

    public function products(): HasMany
    {
        return $this->hasMany(ApplicationProducts::class,'category_id');
    }
}
