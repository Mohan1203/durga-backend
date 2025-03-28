<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class ApplicationProducts extends Model
{
    use HasFactory;

    protected $table = 'application_products';

    protected $fillable = ['name','image','slug','description','category_id','features','product_description','product_desc_image'];

    protected $casts = [
        'features'=>'array',
    ];

    public function category()
    {
        return $this->belongsTo(ApplicationCategory::class,'category_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ApplicationCategory::class, 'application_category_product', 'application_product_id', 'application_category_id');
    }

    // public function getImageAttribute($value)
    // {
    //     return url(Storage::url($value));
    // }

}   