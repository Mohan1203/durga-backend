<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class ApplicationCategory extends Model
{
    use HasFactory;
    protected $table = 'application-categories';
    protected $fillable = ['name', 'image', 'slug', 'sequence'];

    protected static function boot()
    {
        parent::boot();

        // When creating a new category, set its sequence to the next available number
        static::creating(function ($category) {
            $maxSequence = static::max('sequence') ?? 0;
            $category->sequence = $maxSequence + 1;
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(ApplicationProducts::class,'category_id');
    }

    public function applicationProducts(): BelongsToMany
    {
        return $this->belongsToMany(ApplicationProducts::class, 'application_category_product', 'application_category_id', 'application_product_id');
    }

    // public function getImageAttribute($value)
    // {
    //     return url(Storage::url($value));
    // }
}