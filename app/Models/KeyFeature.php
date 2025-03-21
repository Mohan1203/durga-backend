<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class KeyFeature extends Model
{
    protected $fillable = ['product_portfolio_id','name','description','image'];
    
    public function productPortfolio()
    {
        return $this->belongsTo(ProductPortfolio::class);
    }

    // public function getImageAttribute($value)
    // {
    //     return url(Storage::url($value));
    // } 

}
