<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Service;
use App\Models\specification;
use App\Models\User;
use App\Models\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
        $user=Auth::user();
      if($user && $user->account_type=="Admin"){  
            $monthly_sales=[];
            $current_month=Carbon::now()->monthName;
            $current_year=Carbon::now()->year;
            $months_array = [
                1=>'January',
                2=>'February',
                3=>'March',
                4=>'April',
                5=>'May',
                6=>'June',
                7=>'July ',
                8=>'August',
                9=>'September',
                10=>'October',
                11=>'November',
                12=>'December',
            ];
        

            
            
            foreach($months_array as $key=>$value){
                $monthly_sales[$value]=UserService::whereMonth("created_at",$key)->whereYear("created_at",$current_year)->sum("price");
                if($value==Carbon::now()->monthName){
                break;
                }
                
            }


            $vendor_offers=UserService::all()->groupBy("vendor_id");
            $vendors_sales=[];
            
            foreach($vendor_offers as $key=>$value){
                $vendors_sales[User::find($key)->full_name]=$value->sum("price");
            }

            $most_categories=[];
          /*  $offers=UserService::all()->groupBy("category_type");
            foreach($offers as $key=>$value){
                $most_categories[$key]=$value->count();
            }
            
            try {
                arsort($most_categories);
            } catch (\Throwable $th) {
                //throw $th;
            }*/



            $most_services=[];
            $offers=UserService::where("state","confirmed")->get()->groupBy("service_id");
            foreach($offers as $key=>$value){
                $most_services[Service::find($key)->name]=$value->count();
            }

            try {
                arsort($most_services);
            } catch (\Throwable $th) {
                //throw $th;
            }


        
        return view('home',compact("monthly_sales","vendors_sales","most_categories","most_services"));
      }
        elseif($user->category_title=="emergency_car"){
            
            $monthly_sales=[];
            $current_month=Carbon::now()->monthName;
            $current_year=Carbon::now()->year;
            $months_array = [
                1=>'January',
                2=>'February',
                3=>'March',
                4=>'April',
                5=>'May',
                6=>'June',
                7=>'July ',
                8=>'August',
                9=>'September',
                10=>'October',
                11=>'November',
                12=>'December',
            ];
            $monthly_requests=[];

            
            
            foreach($months_array as $key=>$value){
                $temp=UserService::where("vendor_id",$user->id)->whereMonth("created_at",$key)->whereYear("created_at",$current_year);
                $monthly_sales[$value]=$temp->sum("price");
                $monthly_requests[$value]=$temp->count();
                if($value==Carbon::now()->monthName){
                break;
                }
                
            }

            
            $most_branches=[];
            $branches_id=Branche::where("vendor_id",$user->id)->pluck("id")->toArray();
            $offers=UserService::whereIn("branch_id",$branches_id)->get()->groupBy("branch_id");
            foreach($offers as $key=>$value){
                $most_branches[$key]=$value->count();
            }
            
            try {
                arsort($most_branches);
            } catch (\Throwable $th) {
                //throw $th;
            }

         
                
            
        return view('winsh_home',compact("monthly_sales","monthly_requests"));
        return view('home',compact("monthly_sales","vendors_sales","most_services","most_branches"));

    }
    elseif($user->category_title=="car_washer"){
            
        $monthly_sales=[];
        $current_month=Carbon::now()->monthName;
        $current_year=Carbon::now()->year;
        $months_array = [
            1=>'January',
            2=>'February',
            3=>'March',
            4=>'April',
            5=>'May',
            6=>'June',
            7=>'July ',
            8=>'August',
            9=>'September',
            10=>'October',
            11=>'November',
            12=>'December',
        ];
        $monthly_requests=[];

        
        
        foreach($months_array as $key=>$value){
            $temp=UserService::where("vendor_id",$user->id)->whereMonth("created_at",$key)->whereYear("created_at",$current_year);
            $monthly_sales[$value]=$temp->sum("price");
            $monthly_requests[$value]=$temp->count();
            if($value==Carbon::now()->monthName){
            break;
            }
            
        }

        
        $most_branches=[];
        $branches_id=Branch::where("vendor_id",$user->id)->pluck("id")->toArray();
        $services=UserService::whereIn("branch_id",$branches_id)->get()->groupBy("branch_id");
        foreach($services as $key=>$value){
            $most_branches[Branch::find($key)->name]=$value->count();
        }
        try {
            arsort($most_branches);
        } catch (\Throwable $th) {
            //throw $th;
        }

        $most_services=[];
        $branches_id=Branch::where("vendor_id",$user->id)->pluck("id")->toArray();
        $services=UserService::whereIn("branch_id",$branches_id)->get()->groupBy("service_name");
        foreach($services as $key=>$value){
            $most_services[$key]=$value->count();
        }
        
        try {
            arsort($most_services);
        } catch (\Throwable $th) {
            //throw $th;
        }
     
            
        
    return view('washer_home',compact("monthly_sales","monthly_requests","most_branches","most_services"));
    return view('home',compact("monthly_sales","vendors_sales","most_services","most_branches"));

}

   
    
    return view('home',compact("monthly_sales","vendors_sales","most_services"));
   
    }


    public function GetSpecifications()
    {
        $specifications=specification::all();
        if(str_contains(url()->current(), 'api')){
            return json_encode($specifications,JSON_UNESCAPED_UNICODE);
         }
        
        return view("specifications",compact("specifications"));
    }


    public function saveToken(Request $request)
    {
        Auth::user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
  


    public function StoreSpecification(Request $request)
    {
        $en_specfication_category=$request->en_specification_category;
        $specification=new specification();
        $specification->ar_title=$request->ar_title;
        $specification->en_title=$request->en_title;
        $specification->en_specification_category=$en_specfication_category;

        if($en_specfication_category=="car_washer"){
            $specification->ar_specification_category="كار كير";
        }
        if($en_specfication_category=="emergency_car"){
            $specification->ar_specification_category="ونش انقاذ";
        }
        if($en_specfication_category=="supplier"){
            $specification->ar_specification_category="قطع غيار";
        }
        if($en_specfication_category=="mechanic"){
            $specification->ar_specification_category="مركز خدمة";
        }

        if($request->hasfile('image_link')){
            $file = $request->file('image_link');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            Storage::disk('public')->putFileAs("specifications-photos",$file,$filename);
            $specification->image_link=$filename;
            $specification->save();
        }
        return redirect()->back()->withErrors(["Specification has added successfully"]);
    }

    public function DeleteSpecification($id)
    {
        specification::destroy($id);
        return redirect()->back()->withErrors(["Specification has deleted successfully"]);
        
    }
    public function UpdateSpecification(Request $request,$id)
    {
        $data=$request->all();
        $specification=specification::find($id);
        $en_specfication_category=$request->en_specification_category;

        if($en_specfication_category=="car_washer"){
            $data["ar_specification_category"]="كار كير";
        }
        if($en_specfication_category=="emergency_car"){
            $data["ar_specification_category"]="ونش انقاذ";
        }
        if($en_specfication_category=="supplier"){
            $data["ar_specification_category"]="قطع غيار";
        }
        if($en_specfication_category=="mechanic"){
            $specification["ar_specification_category"]="مركز خدمة";
        }

        $specification->update($data);
        if($request->hasfile('image_link')){
            $file = $request->file('image_link');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            Storage::disk('public')->putFileAs("specifications-photos",$file,$filename);
            $specification->image_link=$filename;
            $specification->save();
        }

        return redirect()->back()->withErrors(["Specification has updated successfully"]);
    }
     
    public function sendNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
          
        $SERVER_API_KEY = 'AAAAHqfASME:APA91bF7QGvWeEqd_W7GQWY720a7ZbZsi-mlg8dKTW0QX9kgpGRbcgq-SpTwW_8noW1FoUDOX5gZB3KLnbyv0i9yq1rB6qd51BOGAScw-M34OtnN_V10yQz6co9NTRVADnxZa3l39UHN';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
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
  
        dd($response);
    }


    public function EditProfile()
    { 
        return view("users.edit_profile");
    }
}
