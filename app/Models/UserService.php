<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    use HasFactory;

    protected $fillable=[
     "ar_title",
     "en_title",
     "type",
     "ar_description",
     "en_description",
     "brand",
     "price",
     "discount",
     "quantity",
     "ar_color",
     "en_color",
     "manfacture_country",
     "no_available_items",
     "no_services_requested",
     "vendor_id",
     "image_link",
     "state",
     "booking_time",
     "booking_date",
     "payment_method",
     "user_id",
     "request_note",
     "request_time",
     "response_note",
     "response_time",
     "service_id",
     "source_latitude",
     "source_longitude",
     "source_address",
     "winsh_id",
     "winsh_driver_phone",
     "car_brand",
     "car_model",
     "car_year",
     "source_address",
     "destination_address",
     "destination_latitude",
     "destination_longitude",
     "customer_name",
     "customer_phone",
     "service_name",
     "service_type",
     "address_id",
     "order_id",
     "receiving_date",
     "delivery_type",
     "delivery_fees",
     "category_type",
     "branch_id",
     "min_cost_per_kilo",
     "max_cost_per_kilo",
     "distance",
     "sub_category_id"

    ];

    public function User(Type $var = null)
    {
        return $this->belongsTo("App\Models\User","user_id");
    }

    
   function getDistanceBetweenPointsNew() {
    $unit = 'Km';
    $latitude1=$this->source_latitude;
    $longitude1=$this->source_longitude;
    
    $latitude2=$this->destination_latitude;
    $longitude2=$this->destination_longitude;
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
    




}
