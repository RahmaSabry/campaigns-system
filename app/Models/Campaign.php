<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'total', 'daily_budget', 'from', 'to'];

    protected static function boot()
    {
        parent::boot();
       
    }

    public function images()
    {
        return $this->hasMany(Image::class);
        
    }
}
