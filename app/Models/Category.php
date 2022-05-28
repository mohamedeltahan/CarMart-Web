<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'ar_title',
        'en_title',
        'photo_link',
        'ar_description',
        'en_description',
        'icon',
        'colored_icon',
        'color_code',
        'map_icon',
        'sub_categories'
 
    ];


    static public function GetHighestCategory(Type $var = null)
    {
        try {
            $user_services_vendors_id=UserService::all()->pluck("vendor_id")->toArray();
            $arr=[];
            foreach($user_services_vendors_id as $key=>$value){
                
                $arr[]=User::find($value)->GetCategoryTitle("en");
            }
            $count=array_count_values($arr);
            arsort($count);
            if(sizeof($count)){ 
                return (object)["name"=>array_keys($count)[0],"count"=>array_values($count)[0]];
            }
            else{
                return (object)["name"=>"Undefined" , "count"=>0 ];
            }
    
        } catch (\Throwable $th) {
            return (object)["name"=>"Undefined" , "count"=>0 ];
        }


    }

    static public function GetLowestCategory(Type $var = null)
    {
        try {
            $user_services_vendors_id=UserService::all()->pluck("vendor_id")->toArray();
            $arr=[];
            foreach($user_services_vendors_id as $key=>$value){
                
                $arr[]=User::find($value)->GetCategoryTitle("en");
            }
            $count=array_count_values($arr);
            asort($count);
            if(sizeof($count)){ 
                return (object)["name"=>array_keys($count)[0],"count"=>array_values($count)[0]];
            }
            else{
                return (object)["name"=>"Undefined" , "count"=>0 ];
            }
    
        } catch (\Throwable $th) {
            return (object)["name"=>"Undefined" , "count"=>0 ];
        }


    }

    
 
}
