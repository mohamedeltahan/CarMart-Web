<?php

namespace App\Http\Controllers\Requests;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use App\Models\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {     
        $state=$request->state;
        if(Auth::user()->account_type=="Admin"){
            $vendors_id=User::where("category_title",$request->type)->pluck("id")->toArray();
            $services=UserService::whereIn("vendor_id",$vendors_id)->orderBy('id', 'desc')->with("user")->paginate();
            $services=json_decode($services->toJson(),true);
            return view("Requests.index",compact("services","state"));

        }
        $services=Auth::user()->GetRequests($state)->orderBy('id', 'desc')->with("user")->paginate();
        $services=json_decode($services->toJson(),true);


        if(str_contains(url()->current(), 'api')){
            return json_encode($services,JSON_UNESCAPED_UNICODE);
        }


        return view("Requests.index",compact("services","state"));
        
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
        //return $request->all();
        $user=Auth::user();
        //used for car washer multiple services
        if($request->filled("multiple_services") && $request->filled("services_ids")){
            $data=$request->except("services_ids");
            if($request->filled("services_ids")){
                $services_ids=$request->services_ids;
                foreach($services_ids as $id){
                    $data["service_id"]=$id;
                    $user->BookService($data);
                }
                return json_encode(["state"=>"done"]);
            }
        
        }
            
        if($request->filled("multiple_services") && $request->filled("services_names")){
                $data=$request->except("services_names");
                 if($request->filled("services_names")){
                 $services_names=$request->services_names;
                 foreach($services_names as $name){
                    $data["service_name"]=$name;
                    $user->BookService($data);
                 }
                return json_encode(["state"=>"done"]);
         }
        }

        if($request->service_type=="booking"){
            return $user->BookService($request->all());
        }
        elseif($request->service_type=="delivery"){
            return $user->RequestService($request->all());
        }
        elseif($request->service_type=="emergency_car"){
            return $user->RequestWinsh($request->all());
        }
        
        
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
        $data=$request->all();
        $data["response_time"]=Carbon::now();
        $request=UserService::find($id);
        $request->update($data);
        return redirect()->back()->withErrors(["Respond Has Been Sent Successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service=UserService::destroy($id);
        return 1;
    }

    public function Search(Request $request)
    {
         $state=$request->state;
         $value=$request->value;
         $services=DB::table("users")->join('user_services', 'user_services.user_id', '=', 'users.id');
        if(Auth::user()->account_type=="Vendor"){
            $services=$services->where("user_services.vendor_id",Auth::user()->id)
            ->where(function($query) use ($value){
                $query->orwhere("users.phone",$value);
                $query->orWhere("users.full_name","like","%".$value."%");
            })->get();
        }
        else{
            $services=$services->where("users.phone",$request->value)->orWhere("users.full_name","like","%".$request->value."%")->get();
        }
        foreach($services as $service){
            $service->user=User::find($service->user_id);
        }


         $services=["data"=>json_decode($services,true),"total"=>sizeof($services),"links"=>[],"per_page"=>sizeof($services),"current_page"=>1];
    
         return view("Requests.index",compact("services","state"));
 
    }

    public function GetRequest($id)
    {
        $request=UserService::find($id);
        $request->vendor_name=User::find($request->vendor_id)->full_name;
        return json_encode($request,JSON_UNESCAPED_UNICODE);
    }

    




}
