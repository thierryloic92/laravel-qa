<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    // protected $table='products';
    use HasFactory;
    protected $fillable = ['name','price','category_id']; //$guarded

    public function category () {        
            return $this->belongsTo(Category::class, 'category_id');
        
    }
}
