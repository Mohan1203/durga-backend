<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureSection extends Model
{

    protected $fillable = ['product_portfolio_id','title','description'];
    
    public function productPortfolio()
    {
        return $this->belongsTo(ProductPortfolio::class);
    }
}
