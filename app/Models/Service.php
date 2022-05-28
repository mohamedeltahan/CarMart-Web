<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Service extends Model
{
    use HasFactory;
    

    protected $fillable=["en_title","ar_title","type","en_description","ar_description","brand","price","discount","en_color","ar_color","manfacture_country","no_available_items","no_services_requested","vendor_id","image_link","promoted","en_category","ar_category","available_from","available_to","deliverable","ratio","branch_id","sub_category_id"];



    public function User(Type $var = null)
    {
        return $this->belongsTo("App\Models\User","vendor_id");
    }

    public function GetBranches()
   {
       $ids=$this->hasMany("App\Models\ServiceBranch","service_id")->pluck("branch_id")->toArray(); 
      
       return json_encode($ids,true);

   }

   
   public function Rates()
   {
       return $this->hasMany("App\Models\Rate","service_id");   
   }

   
   public function RateSum(Type $var = null)
   {
       try {
        $rates=Rate::where("service_id",$this->id);
        $value=$rates->sum("value");
        $no=$rates->count();
        return $value/$no;
       } catch (\Throwable $th) {
           return 0;
       }
       
   }

   public static function Highest_Service_Sells($vendor_id)
    {
        $services=UserService::where("vendor_id",Auth::id())->pluck("service_id")->toArray();
        $counted_array = array_count_values($services);
        arsort($counted_array);
        $service=null;
        foreach($counted_array as $key=>$value){
            $service=Service::find($key);
            $service->count=$value;
            break;
        }
        return $service;

   }

   public function FavouriteState(Type $var = null)
   {
       try {
            if(Wishlist::where("user_id",Auth::id())->where("service_id",$this->id)->first()!=null){
                return true;
            }
            else{
                return false;
            }
            
        } catch (\Throwable $th) {
          return $th;
      }
       
   }
   

}
