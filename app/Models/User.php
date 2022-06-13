<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{    
    use HasFactory;

    protected $primarykey = 'id';
    protected $table = 'users';
    protected $fillable = ['username','country','district','postcode','address'] ;
    public $timestamps = false;
}
