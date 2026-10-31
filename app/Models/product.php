<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = ['name','reference','description','purchase_price','selling_price','quantity','min_stock','is_active','category_id'];
    protected $casts =[
        'is_active' => 'boolean',
    ];

    public function category(){
        return $this->belongsTo(category::class);
    }
    public function stock_movement(){
        return $this->hasMany(stock_movement::class);
    }
}
