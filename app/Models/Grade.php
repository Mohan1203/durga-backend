<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{

    protected $fillable = ['product_portfolio_id','parent_category','child_category'];
    
    public function productPortfolio()
    {
        return $this->belongsTo(ProductPortfolio::class);
    }
}
