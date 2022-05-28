<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
   
    protected $fillable=["title","type","seen","user_id","description","image_link","target_audience","vendor_id"];



    public function GetState()
    {
        if($this->seen==0){
            return "not seen";
        }
        else{
            return "seen";
        }
    }

    
    public function User(Type $var = null)
    {
        return $this->belongsTo("App\Models\User","user_id");
    }

    public function scopeOrWhereLike($query, $column, $value)
    {
      return $query->orWhere($column, 'like', '%'.$value.'%');
    }

    
}
