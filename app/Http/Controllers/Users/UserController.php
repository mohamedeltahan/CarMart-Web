<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Rate;
use App\Models\Service;
use App\Models\User;
use App\Models\UserCar;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Passport\Client as LaravelClient;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user=Auth::user();
        if($user->account_type=="Admin"){
         $users=User::paginate();
         $users=json_decode($users->toJson(),true);
         return view("users.index",compact("users"));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     /*   // dd($request->all());
        $validatedData = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'account_name'=>['required', 'string', 'max:255',],
        //    'phone' => ['required', 'string', 'max:255', 'unique:users'],
       //     'address' => ['required', 'string', 'max:255', ],
            'account_type' => ['required', 'string', 'max:255', Rule::in(['Admin', 'Vendor','Normal',"Branch"]) ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        
        ]);
*/
        $data=$request->all();

        try {

            if($request->hasfile('photo_link')){
              $file = $request->file('photo_link');
              $extension = $file->getClientOriginalExtension(); // getting image extension
              $filename =time().'.'.$extension;
              Storage::disk('public')->putFileAs("users-photos",$file,$filename);
              $data["photo_link"]=$filename;
             }
             $password_without_hash=$data["password"];

             $data["password"] = Hash::make($data['password']);
            
             $client = LaravelClient::where('password_client', 1)->first();
             $http = new GuzzleHttpClient();
             $temp_array=$request->specifications;
             $temp_string="";
             foreach($temp_array as $temp){
                 $temp_string.=$temp.",";
             }
             $data["specifications"]=$temp_string;
             $user=User::create($data);
             $response = $http->post('http://localhost/carmart/public/oauth/token', [
                 'form_params' =>[
                     'grant_type'    => 'password',
                     'client_id'     => $client->id,
                     'client_secret' => $client->secret,
                     'username'      => $data['email'],
                     'password'      => $password_without_hash,
                     'scope'         => null,
                 ]]);

            
           


           } catch (\Throwable $th) {
               dd($th);
             
             return redirect()->back()->withErrors(["there is some error happend....kindly contact support"]);;
         }

          //this is for api
         return $response->getBody();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'account_name'=>['sometimes','required', 'string', 'max:255',Rule::unique('users')->ignore($id, 'id')],
            'phone' => ['sometimes','required', 'string', 'max:255', Rule::unique('users')->ignore($id, 'id')],
            'address' => ['sometimes', 'string', 'max:255', ],
            'email' => ['sometimes','required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id, 'id')],
      
      ]);
  
      if($validator->fails()) {
          //pass validator errors as errors object for ajax response
          return response()->json(['error'=>$validator->errors()->first()]);
      }
         
      $user=User::find($id);

      if(str_contains(url()->current(), 'api') && Auth::user()->id!=$id){
          return json_encode(["error"=>"Not Auth User"],JSON_UNESCAPED_UNICODE);
      }

      $data=$request->all();
      if(!$request->filled("password")){
          
         $data=$request->except("password");

      }
      

      try {

          if($user->account_type!="Normal" && isset($data["specifications"])){
             $temp_array=$request->specifications;
             $temp_string="";
            foreach($temp_array as $temp){
              $temp_string.=$temp.",";
            }
            $data["specifications"]=$temp_string;
          }

          if($request->hasfile('photo_link')){
            $file = $request->file('photo_link');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            Storage::disk('public')->putFileAs("users-photos",$file,$filename);
            $data["photo_link"]=$filename;
           }
           if($request->filled("password")){
             $data["password"] = Hash::make($data['password']);
           }
          
           
           $user->update($data);


         } catch (\Throwable $th) {

          if(str_contains(url()->current(), 'api')){
           
              return json_encode(["error"=>$th->getMessage()],JSON_UNESCAPED_UNICODE);
          }
          dd($th->getMessage());

              return redirect()->back()->withErrors(["there is some error happend....kindly contact support"]);;
     
          }

          if(str_contains(url()->current(), 'api')){
           
            return json_encode(["state"=>"User has updated successfully","user"=>$user],JSON_UNESCAPED_UNICODE);
        }


       return redirect()->back()->withErrors(["User has updated successfully"]);;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->back()->withErrors(["message"=>"User Has Deleted Successfully"]);
    }

    public function Search(Request $request)
    {
        $value=$request->value;
        
        $users=User::WhereLike("account_name",$value)->OrWhereLike("full_name", $value)->OrWhereLike("email", $value)->OrWhereLike("phone", $value)->paginate(100);
        $users=json_decode($users->toJson(),true);

        if(str_contains(url()->current(), 'api')){
            
            
            return json_encode(["users"=>$users],JSON_UNESCAPED_UNICODE);
        }
        else{

            return view("users.index",compact("users"));

        }



    }

    public function check_user_existance($account_name)
    {
        if(User::where("account_name",$account_name)->orWhere("email",$account_name)->orWhere("phone",$account_name)->first()==null){
            return 0;
        }
        else{
            return 1;
        }
    }


    public function GetRequests($id)
    {
        return json_encode(["services"=>User::find($id)->Services],JSON_UNESCAPED_UNICODE);
    }

    public function GetUserInfo()
    {
        $user=Auth::user();
        return json_encode(["user"=>$user],JSON_UNESCAPED_UNICODE);
        
    }

    public function GetUserRequests(Type $var = null)
    {
        $user_services=Auth::user()->Services();
        return json_encode(["user"=>Auth::user() ,"outgoing_services"=>$user_services->where("state","!=","received")->get(),"received_services"=>$user_services->where("state","==","received")->get()],JSON_UNESCAPED_UNICODE);

    }

    public function ApiLogin(Request  $request)
    {
        
    $client = LaravelClient::where('password_client', 1)->first();
    $http = new GuzzleHttpClient();
    $password=$request->password;

    try {
    if($request->filled("facebook_token")){

      $user=User::where("email",$request->email)->where("login_method","facebook")->first();

      return json_encode(["access_token"=>$user->createToken("pass")->accessToken,"id"=>$user->id]);

    
    }
    elseif($request->filled("gmail_token")){

        $user=User::where("email",$request->email)->where("login_method","gmail")->first();
  
        return json_encode(["access_token"=>$user->createToken("pass")->accessToken,"id"=>$user->id]);
  
      
      }

    $response = $http->post('http://localhost/carmart/public/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ],
    ]);
    
    
     $user=User::where("email",$request->email)->orWhere("phone",$request->email)->first();
     /*$user->token=json_decode($response->getBody()->getContents(),true);
    return json_encode($user);
    */
    return json_encode(["token"=>json_decode($response->getBody()->getContents())->access_token,"id"=>$user->id,"user_name"=>$user->account_name,"profile_image"=>$user->image_link],true);

    } catch (\Throwable $th) {
        return $th->getMessage();
       return json_encode(["error"=>"Invalid Credentials"]);
    }
        
    }


    public function GroupVendorsByLevel(Type $var = null)
    {
        # code...
    }

    public function GroupVendorBySpecfications(Request $request)
    {
        
        $specifications=["عفشة","شكمان","كهرباء"];
        $vendors_array=[];
        

        if($request->filled("specification")){
            $specification=$request->specification;
            $vendors_array=["specification"=>$specification,"vendors"=>User::where("specifications","like","%".$specification."%")->get()];   
        }

        else{
          foreach($specifications as $specification){
             $vendors_array[]=["specification"=>$specification,"vendors"=>User::where("specifications","like","%".$specification."%")->get()];
        }
        
        }
        return json_encode($vendors_array,JSON_UNESCAPED_UNICODE);

    }


    public function GetVendorServices(Request $request)
    {
        try {

            $user=User::find($request->vendor_id);
            if($request->filled("value")){
                $value=$request->value;

                return $user->GetVendorServices($value);
            }
            else{
                
                return $user->GetVendorServices("");
    
            }
    
            } catch (\Throwable $th) {
            //throw $th;
        }
        
    }

    public function GetServices($id)
    {
        return Service::where("vendor_id",$id)->get();
        
    }



    public function rate(Request $request,$id,$value)
    {
        $rate=new Rate();
        try {
            if($request->filled("offer_id")){
                $rate->offer_id=$request->offer_id;
            }
            elseif($request->filled("vendor_id")){
                $rate->vendor_id=$request->vendor_id;

            }
            $rate->value=$value;
            $rate->user_id=Auth::id();
            $rate->save();
        } catch (\Throwable $th) {
            
            return json_encode(["Error"=>$th->getMessage()]);

        }

        return $rate;
     
        
    }

    public function UpdateRate(Request $request,$id,$value)
    {
        $rate=Rate::where("offer_id",$id)->where("user_id",Auth::id())->first();
        try {
            $rate->value=$value;
            $rate->save();
        } catch (\Throwable $th) {

            return json_encode(["Error"=>$th->getMessage()]);

        }

        return $rate;
        
    }

    public function DeleteRate($id)
    {
        try {
            $rate=Rate::where("offer_id",$id)->where("user_id",Auth::id())->delete();
        } catch (\Throwable $th) {
            
            return json_encode(["Error"=>$th->getMessage()]);

        }

        return true;
        
    }


    public function GetRates($id,$type)
    {
        $service=Service::find($id);
        if($type=="sum"){
            return $service->Rates->sum("value");
        }
        
        if($type=="records"){
            return $service->Rates;
        }
        
    }


    public function GetWinshes(Request $request)
    {
        $users=User::where("category_title","emergency_car")->paginate();
        
        foreach($users as $user){
            $user->rate=$user->RateSum();
        }
        
        return $users;
        
    }

    public function GetWashers(Request $request)
    {
        $users=User::where("category_title","car_washer")->paginate();
        
        foreach($users as $user){
            $user->rate=$user->RateSum();
        }
        
        return $users;
        
    }

    public function GetSuppliers(Request $request)
    {
        $users=User::where("category_title","supplier")->paginate();
        
        foreach($users as $user){
            $user->rate=$user->RateSum();
        }
        
        return $users;
        
    }

    public function GetMechanics(Request $request)
    {
        $users=User::where("category_title","mechanic")->paginate();
        
        foreach($users as $user){
            $user->rate=$user->RateSum();
        }
        
        return $users;
        
    }


    public function GetWinsh(Request $request,$id)
    {
        $user=User::find($id);
        $user->rate=$user->RateSum();
        $services=$user->services;
        $user->NoOfCompletedRequest=$user->NoOfCompletedRequest();
        $user->specifications=$user->GetSpecifications();
        $branches=Branch::where("vendor_id",$id)->get();
        $user->branches=$branches;
        return json_encode(["user"=>$user],JSON_UNESCAPED_UNICODE);
        
    }



    public function GetWasher(Request $request,$id)
    {
    
        $user=User::find($id);
        $user->specifications=json_decode($user->GetSpecifications());
        $user->rate=$user->RateSum();
        $services=$user->services;   
        $branches=Branch::where("vendor_id",$id)->get();
        $user->branches=$branches;

        
        return json_encode(["user"=>$user,"services"=>$services],JSON_UNESCAPED_UNICODE);
        
    }

    public function GetSupplier(Request $request,$id)
    {

        $user=User::find($id);
        $user->rate=$user->RateSum();
        $user->specifications=$user->GetSpecifications();
        $services=$user->services;
        $branches=Branch::where("vendor_id",$id)->get();
        $user->branches=$branches;

        
        return json_encode(["user"=>$user,"services"=>$services],JSON_UNESCAPED_UNICODE);
    }

    public function GetMechanic(Request $request,$id)
    {     
        $user=User::find($id);
        $user->rate=$user->RateSum();
       // $services=$user->services;
        $user->specifications=json_decode($user->GetSpecifications());
        $branches=Branch::where("vendor_id",$id)->get();
        $user->branches=$branches; 
        return json_encode(["user"=>$user],JSON_UNESCAPED_UNICODE);
        
    }

    public function AddItemToWishlist(Request $request)
    {
        $user=Auth::user();
        $service_id=$request->service_id;
        $wish=Wishlist::where("user_id",$user->id)->where("service_id",$service_id);
        if($wish->first()!=null){
             $wish->delete();
             return 0;
        }
        else{
            $wishlist=new Wishlist();
            $wishlist->user_id=$user->id;
            $wishlist->service_id=$service_id;
            $wishlist->save();
            return true;
        }
        
    }

    
    public function GetWishlist(Request $request)
    {
        $user=Auth::user();
        return json_encode(["items"=>$user->GetWishlistItems()],JSON_UNESCAPED_UNICODE);
    }

    public function EmptyWishlist(Request $request)
    {
        Wishlist::where("user_id",Auth::id())->delete();
        return true;

    }

    public function DeleteItemFromWishlist($id)
    {
        Wishlist::where("user_id",Auth::id())->where("item_id",$id)->delete();
        return true;

        
    }

    public function GetUserGarage()
    {
        $user=Auth::user();
        return $user->Garage();   
    }

    public function AttachToGarage(Request $request)
    {
        $user_car=new UserCar();
        $user_car->car_id=$request->car_id;
        $user_car->user_id=Auth::id();
        $user_car->save();
        return 1;   
    }

    public function GetBranches($id)
    {
        $Branches=Branch::where("vendor_id",$id)->get();
        return json_encode(["branches"=>$Branches],JSON_UNESCAPED_UNICODE);
    }
    

    public function GetBrands(Request $request)
    {
        $featured_users=User::where("account_type","Vendor")->where("featured",1)->get();
        $normal_users=User::where("account_type","Vendor")->where("featured",0)->get();
        return json_encode(["featured_users"=>$featured_users,"normal_users"=>$normal_users]);
    }





}
