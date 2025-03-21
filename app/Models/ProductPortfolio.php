<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class ProductPortfolio extends Model
{

    protected $fillable = ['heading','sub_heading','name','description','slug','image','grade_title','grade_description','key_feature_title','key_feature_description','indutry_title'];
    
    public function industry()
    {
        return $this->hasMany(Industry::class);
    }

    public function keyFeature()
    {
        return $this->hasMany(KeyFeature::class);
    }

    public function grade()
    {
        return $this->hasMany(Grade::class);
    }

    public function featureSection()
    {
        return $this->hasMany(FeatureSection::class);
    }   
    
    // public function getImageAttribute($value)
    // {
    //     return url(Storage::url($value));
    // }   
}

