<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserCar;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Http\Request;
use Illuminate\Support\Str as IlluminateStr;
use Illuminate\Validation\Rule;
use Laravel\Passport\Client  as LaravelClient;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function Register(Request $request)
    {
      //  return $request->all();
      $validator = Validator::make($request->all(), [
        'full_name' => ['required', 'string', 'max:255'],
        'account_name'=>['required', 'string', 'max:255',],
        'phone' => ['required', 'string', 'max:255', 'unique:users'],
   //     'address' => ['required', 'string', 'max:255', ],
        'account_type' => ['required', 'string', 'max:255', Rule::in(['Admin', 'Vendor','Normal',"Branch"]) ],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    
    ]);

       if($validator->fails()) {
        //pass validator errors as errors object for ajax response
              return response()->json(['error'=>$validator->errors()->first()]);
        }
        
        $data=$request->all();
        
        if($request->filled("login_method" && $request->login_method=="phone")){
            $data["password"]=IlluminateStr::random(8);
        }
        
          
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
               if($request->filled("car_id")){
                   $UserCar=new UserCar();
                   $UserCar->user_id=$user->id;
                   $UserCar->car_id=$request->car_id;
                   $UserCar->save();
               }
               $response = $http->post('http://localhost/carmart/public/oauth/token', [
                   'form_params' =>[
                       'grant_type'    => 'password',
                       'client_id'     => $client->id,
                       'client_secret' => $client->secret,
                       'username'      => $data['email'],
                       'password'      => $password_without_hash,
                       'scope'         => null,
                   ]]);
                   
                   $user->tokens= json_decode(((string)$response->getBody()), true);
                   return $user;
             
              
             
  

           } catch (\Throwable $th) {
            file_put_contents("error.txt",json_encode($th->getMessage()));
             return json_encode(["error"=>$th->getMessage()]);
            // return json_encode(["Error"=>"there is some error happend....kindly contact support"]);
           
            }


            

    }

}
