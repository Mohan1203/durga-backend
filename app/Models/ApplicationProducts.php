<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationProducts extends Model
{
    use HasFactory;

    protected $table = 'application_products';

    protected $fillable = ['name','image','slug','description','category_id','features'];

    protected $casts = [
        'features'=>'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ApplicationCategory::class,'category_id');
    }

}   