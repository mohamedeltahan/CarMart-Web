<?php

namespace App\Models;
use App\Models\Cart;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'description',
        'account_name',
        'phone',
        'address',
        'login_method',
        'account_type',
        'verified',
        'blocked',
        'category_title',
        'featured',
        'promo_code',
        'email',
        'photo_link',
        'latitude',
        'longitude',
        'category_title',
        'city',
        'no_of_completed_request',
        'forget_password_code',
        'phone_type',
        'gender',
        'level',
        'location_id',
        'vendor_id',
        'device_token',
        'banner_photo',
        "specifications",
        "password",
        "working_hours_from",
        "working_hours_to",
        "vacations",


        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function GetRequests($state)
    {
        
        if($this->account_type=="Vendor"){
            $services= UserService::where("vendor_id",$this->id);
            if($state!="all"){
                return $services->where("state",$state);
            }
            else{
                return $services;
            }
        }
        else{
            $services=UserService::where("user_id",$this->id);
            if($state!="all"){
                return $services->where("state",$state);
            }
            
            else{
                return $services;
            }
        }
    }




    
   public function StoreBranch($data)
   {
       $branch=new Branch();
       $branch->name=$data["name"];
       $branch->longitude=$data["longitude"];
       $branch->latitude=$data["latitude"];
       $branch->email=$data["email"];
       $branch->city=$data["city"];
       $branch->address=$data["address"];
       $branch->phone=$data["phone"];
       $branch->start_time=$data["start_time"];
       $branch->end_time=$data["end_time"];
       $branch->vendor_id=$this->id;
       $branch->save();

   }


   public function scopeWhereLike($query, $column, $value)
   {
       return $query->where($column, 'like', '%'.$value.'%');
   }
   
   public function scopeOrWhereLike($query, $column, $value)
  {
    return $query->orWhere($column, 'like', '%'.$value.'%');
  }

  public function AttachNotification($data)
   {   
       $notification=new Notification();
   /*    if(Auth::user()->account_type=="Vendor"){
        $notification->vendor_id=Auth::user()->id;
       }
       */
       $notification->title=$data["title"];
       $notification->type=$data["type"];
       $notification->title=$data["title"];
       $notification->target_audience=$data["target_audience"];
       $notification->image_link=$data["image_link"];
       $notification->user_id=$this->id;
       $notification->description=$data["description"];
       $notification->save(); 
      
       /*
       $firebaseToken = [$this->device_token];
          
       $SERVER_API_KEY = 'AAAAFc3BpEE:APA91bHN9RRVlaBlaf-SLssJw5m78ETQJW8zRvhxuVHbPWXPPkUg3XYSGg9uCoR67Rqk4n166Xbggtp60L8rKiYkwHydI8U0ehr_nzeEsGXaMrIn1BmEXpcIKjJDHL69rKZAmmVMik6D';
 
       $data = [
           "registration_ids" => $firebaseToken,
           "notification" => [
               "title" => $data["title"],
               "body" => ["dd"=>$data["description"],"image"=> "http://gpless.queen-store.net/public_html/Notifications-photos/".$data["image_link"]]
               

           ]
       ];
       $dataString = json_encode($data);
   
       $headers = [
           'Authorization: key=' . $SERVER_API_KEY,
           'Content-Type: application/json',
       ];
   
       $ch = curl_init();
     
       curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
              
       $response = curl_exec($ch);

       */

   }

   public function Cart(Type $var = null)
   {
       
       return $this->hasMany("App\Models\Cart","user_id");

   }

   public function CartTotal(Type $var = null)
   {
       $sum=0;
       foreach($this->Cart as $cart){
           $sum+=$cart->ItemPrice();
       }
       return $sum;
   }


   public function Services()
   {
       if($this->account_type=="Vendor"){
           return $this->hasMany("App\Models\Service","vendor_id");
       }
       else{
        return $this->hasMany("App\Models\UserService","user_id");
       }
   }



   public function GetSpecifications(Type $var = null)
   {
       return json_encode(explode(",",$this->specifications),JSON_UNESCAPED_UNICODE);
   }

   public function RequestService($request_array)
   {
   
       $request_array["address_id"]=$this->AttachAddress($request_array);
       

    try {
        
       $cart_items=$this->Cart;
       foreach($cart_items as $item){
            $service=Service::find($item->item_id);    
            $UserService=$service->replicate();
            $UserService->quantity=$item->quantity;
            $UserService->service_id=$service->id;
            $UserService->request_time=Carbon::now();
            $UserService->state="pending";
            $UserService->request_note=$request_array["request_note"];
            if(isset($request_array["branch_id"]) && ServiceBranch::where("service_id",$UserService->service_id)->first()!=null){
                $UserService->branch_id=$request_array["branch_id"];
            }
            $UserService->car_brand=$request_array["car_brand"];
            $UserService->car_model=$request_array["car_model"];
            $UserService->car_year=$request_array["car_year"];

            $UserService->payment_method=$request_array["payment_method"];
            if(isset($request_array["booking_time"]) && isset($request_array["booking_time"])) {
                 
                $UserService->booking_time=$request_array["booking_time"];
                $UserService->booking_date=$request_array["booking_date"];
            
            }
            if(isset($request_array["destination_longitude"]) && isset($request_array["destination_latitude"])) {
                
                $UserService->destination_longitude=$request_array["destination_longitude"];
                $UserService->destination_latitude=$request_array["destination_latitude"];
             

            }
            
            if(isset($request_array["delivery_type"]) && isset($request_array["delivery_fees"])) {
                
                $UserService->delivery_type=$request_array["delivery_type"];
                $UserService->delivery_fees=$request_array["delivery_fees"];

            }

            $UserService->service_type=$request_array["service_type"];

            
            
           // $UserService->branch_id=$branch_id;
            $UserService->user_id=Auth::id();
          //  return $service->vendor_id;
            $UserService->vendor_id=$service->vendor_id;
            $temp=UserService::create($UserService->toArray()); 
            $service->no_services_requested=$service->no_services_requested+1; 
            $service->save();

            
        }
        Cart::where("user_id",Auth::id())->delete();

        return json_encode(["state"=>"done"]);

        

      
    } catch (\Throwable $th) {

        return json_encode(["state"=>"error","message"=>$th->getMessage()]);

    }
   }

   public function BookService($request_array)
   {
    $request_array["address_id"]=$this->AttachAddress($request_array);
        
    try {
              $service=new UserService();
             if(isset($request_array["service_id"])){
               $service=Service::find($request_array["service_id"]);    
             }

            $UserService=$service->replicate();
            $UserService->quantity=0;
            if(isset($request_array["service_id"])){
                $UserService->service_id=$service->id;
            }
            if(isset($request_array["service_name"])){
             $UserService->service_name=$request_array["service_name"];
             $UserService->ar_title=specification::where("en_title",$request_array["service_name"])->first()->ar_title;
             $UserService->en_title=specification::where("en_title",$request_array["service_name"])->first()->en_title;
            }
        //    $UserService->service_id=$service->id;
            $UserService->request_time=Carbon::now();
            $UserService->state="pending";
            if(isset($request_array["branch_id"]) && ServiceBranch::where("service_id",$UserService->service_id)->first()!=null){
                $UserService->branch_id=$request_array["branch_id"];
            }
          //  $UserService->request_note=$request_array["request_note"];
            $UserService->car_brand=$request_array["car_brand"];
            $UserService->car_model=$request_array["car_model"];
            $UserService->car_year=$request_array["car_year"];

            $UserService->booking_time=$request_array["booking_time"];
            $UserService->booking_date=$request_array["booking_date"];
            $UserService->payment_method=$request_array["payment_method"];

            
            $UserService->customer_name=$request_array["customer_name"];
            $UserService->customer_phone=$request_array["customer_phone"];
            $UserService->service_type=$request_array["service_type"];
            $UserService->vendor_id=$request_array["vendor_id"];

            //$UserService->delivery_type=$request_array["delivery_type"];
           // $UserService->delivery_fees=$request_array["delivery_fees"];

            
            $UserService->user_id=Auth::id();
            $temp=UserService::create($UserService->toArray()); 
           
            if(isset($request_array["service_id"])){
              $service->no_services_requested=$service->no_services_requested+1; 
              $service->save();
            }

             return json_encode(["state"=>"done"]);

    
    } catch (\Throwable $th) {

        return json_encode(["state"=>"error","message"=>$th->getMessage()]);

    }

    }

   public function RequestWinsh($request_array)
   {

    $request_array["address_id"]=$this->AttachAddress($request_array);
        
    try {
            $service=new UserService();    
            $UserService=$service->replicate();
            $UserService->quantity=0;
            $UserService->vendor_id=$request_array["vendor_id"];
            $UserService->request_time=Carbon::now();
            $UserService->state="pending";
            $UserService->address_id=$request_array["address_id"];

            $UserService->request_note=$request_array["request_note"];
            $UserService->source_longitude=$request_array["source_longitude"];
            $UserService->source_latitude=$request_array["source_latitude"];
            $UserService->source_address=$request_array["source_address"];
            $UserService->destination_longitude=$request_array["destination_longitude"];
            $UserService->destination_latitude=$request_array["destination_latitude"];
            $UserService->destination_address=$request_array["destination_address"];
            $UserService->car_brand=$request_array["car_brand"];
            $UserService->car_model=$request_array["car_model"];
            $UserService->car_year=$request_array["car_year"];

            $UserService->service_type=$request_array["service_type"];

            //$UserService->delivery_type=$request_array["delivery_type"];
           // $UserService->delivery_fees=$request_array["delivery_fees"];

            
            $UserService->user_id=Auth::id();
            $temp=UserService::create($UserService->toArray()); 
          //  $service->no_services_requested=$service->no_services_requested+1; 
           // $service->save();

             return json_encode(["state"=>"done"]);

        

    
    } catch (\Throwable $th) {

        return json_encode(["state"=>"error","message"=>$th->getMessage()]);

    }
   }



   public function GetVendorServices($value)
   {
    if($value!=""){
        $vendor_services=Service::where("vendor_id",$this->id)->where("title","like","%".$value."%")->orWhere("brand","like","%".$value."%")->orWhere("category","like","%".$value."%")->orWhere("description","like","%".$value."%")->paginate();

    }
    else{
        $vendor_services=Service::where("vendor_id",$this->id)->paginate();

    }

    return $vendor_services;

   }


   public function findForPassport($identifier) {
    return $this->orWhere('email', $identifier)->orWhere('phone', $identifier)->first();
   }

   public function RateSum(Type $var = null)
   {
       try {
        $rates=Rate::where("vendor_id",$this->id);
        $value=$rates->sum("value");
        $no=$rates->count();
        return $value/$no;
       } catch (\Throwable $th) {
           return 0;
       }
       
   }

   public function NoOfCompletedRequest(Type $var = null)
   {
       return UserService::where("vendor_id",$this->id)->where("state","completed")->count();
   }

   public function AttachAddress($request_array)
   { 
       try {
          $address=new Address();
          $address->governorate=$request_array["governorate"];
          $address->district=$request_array["district"];
          $address->street=$request_array["street"];
          $address->apartment=$request_array["apartment"];
          $address->floor=$request_array["floor"];
          $address->user_id=$this->id;
          $address->save();
          return $address->id;
       } catch (\Throwable $th) {
           return null;
       }
       
   }

   public function GetWishlistItems(Type $var = null)
    {
        $services_ids=Wishlist::where("user_id",Auth::id())->pluck("service_id")->toArray();
        $services=Service::find($services_ids);
        return $services;
    }

    public function AttachCar(Request $request)
    {
        if(UserCar::where("user_id",Auth::id())->where("car_id",$request->car_id)->first()==null){
            $user_car=new UserCar();
            $user_car->car_id=$request->car_id;
            $user_car->user_id=Auth::id();
            $user_car->save();
        }
        return $this->GetCars();
    }

    public function GetCars(Type $var = null)
    {
        $ids=UserCar::where("user_id",$this->id)->pluck("user_id")->toArray();
        return Car::whereIn("car_id",$ids);
    }

    public function Garage(Type $var = null)
    {
        
        $cars=DB::table('cars')
        ->join('user_cars', 'user_cars.car_id', '=', 'cars.id');
        return $cars->where("user_id",$this->id)->get();
       
    }

    public function TotalRevenue()
    {
        $revenue=UserService::where("vendor_id",Auth::id())->where("state","received")->sum("price");
        return $revenue;
    }
    public function MonthlyRevenue()
    {   $month=Carbon::now()->month;
        $revenue=UserService::where("vendor_id",Auth::id())->whereMonth("created_at","=",$month)->where("state","received")->sum("price");
        return $revenue;
    }


    public function GetCategoryTitle($lang)
    {
        if($lang=="en"){
            if($this->category_title=="car_washer"){return "Car Washer";}
            if($this->category_title=="emergency_car"){return "Emergency Car";}
            if($this->category_title=="supplier"){return "Spare Parts Supplier";}
            if($this->category_title=="mechanic"){return "Maintenance Center";}

        }
        elseif($lang=="ar"){
            if($this->category_title=="car_washer"){return "مغاسل سيارات";}
            if($this->category_title=="emergency_car"){return "ونش انقاذ";}
            if($this->category_title=="supplier"){return "متاجر قطع الغيار";}
            if($this->category_title=="mechanic"){return "مراكز صيانة";}

        }
    }



}
