<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected  $fillable=["name","longitude","latitude","city","address","phone","vendor_id","start_time","end_time","user_id","email"];


    public function User()
    {
        return $this->belongsTo("App\Models\User","vendor_id");
    }
 
    

    public function scopeWhereLike($query, $column, $value)
    {
        return $query->where($column, 'like', '%'.$value.'%');
    }
    
    public function scopeOrWhereLike($query, $column, $value)
   {
     return $query->orWhere($column, 'like', '%'.$value.'%');
   }

   function getDistanceBetweenPointsNew($latitude2, $longitude2) {
    $unit = 'Km';
    $latitude1=$this->latitude;
    $longitude1=$this->longitude;
    $theta = $longitude1 - $longitude2;
    $distance = sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta));

    $distance = acos($distance); 
    $distance = rad2deg($distance); 
    $distance = $distance * 60 * 1.1515;

    switch($unit) 
    { 
        case 'Mi': break;
        case 'Km' : $distance = $distance * 1.609344; 
    }

    return (round($distance,2)); 
  }


/*public function Sells(Type $var = null)
{
    $branches_id=Offer::where("branch_id",$this->id)->pluck("id")->toArray();
    $offers=UserOffer::where("offer_id")->get()->sum("price_after_discount");

    return $offers;
    
}*/

static function Sells($flag)
{
    

}






    
}
