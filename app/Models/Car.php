<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable=["brand","model","year","image_link"];

    public function scopeWhereLike($query, $column, $value)
    {
        return $query->where($column, 'like', '%'.$value.'%');
    }
    
    public function scopeOrWhereLike($query, $column, $value)
   {
     return $query->orWhere($column, 'like', '%'.$value.'%');
   }
 
}
