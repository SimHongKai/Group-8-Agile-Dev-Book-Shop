<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    
    protected $table = 'shopping_cart';
    protected $fillable = ['userID', 'ISBN13', 'qty'] ;
     public $timestamps = false;
}
