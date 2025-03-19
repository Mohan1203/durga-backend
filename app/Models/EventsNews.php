<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventsNews extends Model
{
    use HasFactory;
    
    protected $table='event';
    
    protected $fillable = ['name','image'];
}