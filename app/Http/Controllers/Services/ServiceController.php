<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Car;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceBranch;
use App\Models\ServiceCars;
use App\Models\specification;
use App\Models\User;
use App\Models\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $user=Auth::user();
        if($request->filled("category_title")){
            if($user->account_type=="Admin"){
             $services=Service::where("category",$request->category_title)->paginate();
            }
            else{
             $services=Service::where("vendor_id",$user->id)->where("category",$request->category_title)->paginate();
            }
    
        }
        else{
            if($user->account_type=="Admin"){
                $services=Service::with("user")->paginate();
            }
            else{
              $services=Service::with("user")->where("vendor_id",$user->id)->paginate();      
            }
        }

         foreach($services as $service){
            $service->rate=$service->Rates()->sum("value");
            $service->reviews=$service->Rates()->count();
            $service->full_name=User::find($service->vendor_id)->full_name;

         }
         $services=json_decode($services->toJson(),true); 
         if(str_contains(url()->current(), 'api')){
            return json_encode($services,JSON_UNESCAPED_UNICODE);
         }

  
         $vendor_branches=Branch::where("vendor_id",Auth::user()->id)->get();
         return view("Services.index",compact("services","vendor_branches"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
      /*  $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
           // 'image_link' =>'required'
            
        ]);*/
        $data=$request->all();
        $cars=$request->cars;
        $branches=$request->branches;
        
        if($cars[0]=="all_cars"){
            $cars=Car::all()->pluck("id")->toArray();
        }
        
        if($branches[0]=="all_branches"){
            $branches=Branch::where("vendor_id",Auth::id())->pluck("id")->toArray();
        }
        ///change auth id
        if(Auth::user() && Auth::user()->account_type=="Vendor"){
            $data["vendor_id"]=Auth::id();
        }
        else{
            return redirect()->back();
        }
       // $data["deleted_at"]=Carbon::now();

        try {

            if($request->hasfile('image_link')){
              $file = $request->file('image_link');
              $extension = $file->getClientOriginalExtension(); // getting image extension
              $filename =time().'.'.$extension;
              Storage::disk('public')->putFileAs("services-photos",$file,$filename);
              $data["image_link"]=$filename;
             }
            
             $service=Service::create($data);
             foreach($branches as $branch){
                 if($branch==null){
                     continue;
                 }
              $servicebranch=new ServiceBranch();
              $servicebranch->service_id=$service->id;
              $servicebranch->branch_id=$branch;
              $servicebranch->save();
              
             }
             foreach($cars as $car){
                if($car==null){
                    continue;
                }
             $servicecar=new ServiceCars();
             $servicecar->service_id=$service->id;
             $servicecar->car_id=$car;
             $servicecar->save();
             
            }


            

           } catch (\Throwable $th) {
                   dd($th->getMessage());
             return redirect()->back()->withErrors(["there is some error happend....kindly contact support"]);;
         }
        
         return redirect()->back()->withErrors(["Service has added successfully"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service=Service::find($id);
        $service->rate=$service->Rates()->sum("value");
        $service->favourite=$service->FavouriteState();

        $service->reviews=$service->Rates()->count();
        $service->vendor_name=User::find($service->vendor_id)->full_name;
        $service->vendor_photo=User::find($service->vendor_id)->photo_link;
        return json_encode($service,JSON_UNESCAPED_UNICODE);
        
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

        $service=Service::find($id);

        if($request->filled("promoted")){
            $data=$request->all();
            $service->update($data);
            return $service;
        }


      /*  $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            
        ]);*/
        
        $data=$request->all();

        ///change auth id
       // $data["vendor_id"]=2;

        try {
           
            $service=Service::find($id);
            if($request->hasfile('image_link')){
              $file = $request->file('image_link');
              $extension = $file->getClientOriginalExtension(); // getting image extension
              $filename =time().'.'.$extension;
              Storage::disk('public')->putFileAs("services-photos",$file,$filename);
              $data["image_link"]=$filename;
             }
            
            // $data["branches_name"]=json_encode(explode("\r\n", $request->branches_name));
             $service->update($data);

             if($request->filled("branches")){
                 ServiceBranch::where("service_id",$id)->delete();

                foreach($request->branches as $branch){
                    if($branch==null){
                        continue;
                    }
                 $servicebranch=new ServiceBranch();
                 $servicebranch->service_id=$service->id;
                 $servicebranch->branch_id=$branch;
                 $servicebranch->save();
                 
                }
             }

             return redirect()->back()->withErrors(["Service has updated successfully"]);

           } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);;
 
             
            // return redirect()->back()->withErrors(["there is some error happend....kindly contact support"]);;
         }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        Service::destroy($id);
        return redirect()->back()->withErrors(["Service has deleted sucessfully"]);
        
    }



    public function Search(Request $request)
    {
        $value=$request->value;

        $services=DB::table("users")
        ->join('services', 'services.vendor_id', '=', 'users.id')
        ->join("service_cars","service_cars.service_id","services.id")
        ->join("cars","cars.id","service_cars.car_id");
        
          
        if(Auth::user()->account_type=="Vendor"){
            $services=$services->where("services.vendor_id",Auth::user()->id)
            ->where(function($query) use ($value){
            $query->orwhere("services.title","like","%".$value."%");
            $query->orWhere("cars.brand","like","%".$value."%");
            $query->orWhere("cars.model","like","%".$value."%");
            });
            $services=$services->get()->unique("service_id");
         }
        else{
         $services=$services->where("services.title","like","%".$request->value."%") 
         ->where(function($query) use ($value,$request){
            $query->orWhere("cars.brand","like","%".$request->value."%");
            $query->orWhere("cars.model","like","%".$request->value."%")->get()->unique("service_id");
        });
      }

      
       foreach($services as $service){
           
        $service->rate=Service::find($service->service_id)->RateSum();
        $service->reviews=Service::find($service->service_id)->Rates()->count();
        $service->vendor_photo=User::find($service->vendor_id)->photo_link;

       }
        $services=["data"=>json_decode($services,true),"total"=>sizeof($services),"links"=>[],"per_page"=>sizeof($services),"current_page"=>1];
   
        return view("Services.index",compact("services","value"));
    }

    
    public function Users($service_id)
    {
        $users=UserService::with("user")->where("service_id",$service_id)->get();
        return $users;
    }



    public function NearestServices(Request $request)
    {
        $longitude=$request->longitude;
        $latitude=$request->latitude;
        $branches=[];
        if($request->filled("category_type")){
            $users_id=User::where("category_title",$request->category_type)->pluck("id")->toArray();
            $branches=Branch::whereIn("vendor_id",$users_id)->get();
        
        }
        else{
            $service_branches_ids=ServiceBranch::all()->pluck("branch_id")->toArray();
            $branches=Branch::whereIn("id",$service_branches_ids)->get();
        }

        $branches_array=[];

        foreach($branches as $branch){

            $branches_array[$branch->id]=$branch->getDistanceBetweenPointsNew($longitude,$latitude);

        }
            
        asort($branches_array);
        $count=0;
        $offers=[];
        $response_array=[];
        foreach($branches_array as $key=>$value){
            $branch=Branch::find($key);
            $vendor=User::find($branch->vendor_id,["full_name","category_title","id"]);
            $location=["longitude"=>$branch->longitude,"latitude"=>$branch->latitude];
            $branchServices=ServiceBranch::where("branch_id",$branch->id)->pluck("service_id")->toArray();
            $services=["vendor"=>$vendor,"location"=>$location,"services"=>Service::find($branchServices)];
            $response_array[]=$services;
        }
        
        return json_encode(["response_services"=>$response_array],JSON_UNESCAPED_UNICODE);
      // dd($branches_array);




    }

    
    public function HomepageServices()
    {
        $files = Storage::disk('public')->allFiles("today");
        $arr=[];
        foreach($files as $file){
        $renamed_file=str_replace("today"."/","",$file);
        $arr[]=$renamed_file;
        }

        $specifications=specification::all(["ar_title","en_title","image_link"]);
       
        
        $new_services=Service::orderBy('id', 'DESC')->limit(2)->get();
        foreach($new_services as $service){
            $service->rate=$service->RateSum();
            $service->favourite=$service->FavouriteState();

            $service->service_category=User::find($service->vendor_id)->category_title;
        }

        $most_items=[];
        $items=UserService::all()->groupBy("id");
        $categories=Category::all();
        $best_services=null;
        foreach($items as $key=>$value){
            $most_items[$key]=$value->count();
        }

        try {
            arsort($most_items);
            $ids=array_keys($most_items);
            $rawOrder = DB::raw(sprintf('FIELD(id, %s)', implode(',', $ids)));
            $services = Service::whereIn('id',$ids)->orderByRaw($rawOrder)->take(2)->get();
            $temp_arr=[];
            foreach($services as $service){
                $service->rate=$service->RateSum();
                $service->favourite=$service->FavouriteState();
                $service->service_category=User::find($service->vendor_id)->category_title;
                $temp_arr[]=$service;
            }
            $best_services=$temp_arr;
            } catch (\Throwable $th) {
        }

        
        
        $returned_obj=[];

        $returned_obj["banners"]=$arr;
        $returned_obj["specifications"]=$specifications;
        $returned_obj["categories"]=$categories;

        $returned_obj["new_services"]=$new_services;
        $returned_obj["best_services"]=$best_services;
        $returned_obj["featured_brands"]=User::where("featured",1)->take(4)->get();

        
        
        return json_encode($returned_obj,JSON_UNESCAPED_UNICODE);


    }

    public function GetCategoryServices(Request $request)
    {
        $category_title=$request->category_title;
        $categories=Service::where("en_category",$category_title)->orWhere("ar_category",$category_title)->paginate();
        return json_encode($categories,JSON_UNESCAPED_UNICODE);


    }
    public function NewArrivalsServices()
    {
        $services=Service::orderBy('id', 'DESC')->paginate();
        $services=json_decode($services->toJson(),true);
        $temp_arr=[];
        foreach($services["data"] as $service){
            $temp_service=Service::find($service["id"]);
            $temp_service->favourite=Service::find($service["id"])->FavouriteState();
            $temp_service->rate=$temp_service->RateSum();
            $temp_service->service_category=User::find($temp_service->vendor_id)->category_title;

            $temp_arr[]=$temp_service;
        }
        $services["data"]=$temp_arr;

        return json_encode($services,JSON_UNESCAPED_UNICODE);
    }

    public function BestSellerServices()
    {
        $most_items=[];
        $items=UserService::all()->groupBy("id");
        foreach($items as $key=>$value){
            $most_items[$key]=$value->count();
        }

        try {
            arsort($most_items);
            $ids=array_keys($most_items);
            $rawOrder = DB::raw(sprintf('FIELD(id, %s)', implode(',', $ids)));
            $services = Service::whereIn('id',$ids)->orderByRaw($rawOrder)->paginate();
            $services=json_decode($services->toJson(),true);
            $temp_arr=[];
            foreach($services["data"] as $service){
                $temp_service=Service::find($service["id"]);
                $temp_service->favourite=Service::find($service["id"])->FavouriteState();
                $temp_service->rate=$temp_service->RateSum();
                $temp_service->service_category=User::find($temp_service->vendor_id)->category_title;
                $temp_arr[]=$temp_service;
            }
            $services["data"]=$temp_arr;
            } catch (\Throwable $th) {
            //throw $th;
        }

        return json_encode($services,JSON_UNESCAPED_UNICODE);
    }
    
    public function filter(Request $request)
    {
        $services=DB::table("users")->join("services","services.vendor_id","users.id");
        if($request->filled("category_title")){
            $services=$services->where("category_title",$request->category_title);
        }
        if($request->filled("category")){
            $services=$services->where("category","like","%".$request->category."%");   
        }

        if($request->filled("start_price") && $request->filled("end_price")){
            $services=$services->where("price",">=",$request->start_price)->where("price","<=",$request->end_price);   
        }
        if($request->filled("deliverable")){
            $services=$services->where("deliverable",$request->deliverable);   
        }
        return $services->get();

        


    }


    public function GetBranches($id)
    {
        $branches_ids=ServiceBranch::where("service_id",$id)->pluck("branch_id")->toArray();
        return json_encode(["branches"=>Branch::find($branches_ids)],JSON_UNESCAPED_UNICODE);
    }

    public function GetSpareParts($id)
    {
        $suppliers=User::where("category_title","supplier")->pluck("id")->toArray();
        $branches_ids=Branch::whereIn("vendor_id",$suppliers)->pluck("id")->toArray();
        $services_ids=ServiceCars::where("car_id",$id)->pluck("service_id")->unique()->toArray();
        return $services_ids;
        return json_encode(["services"=>Service::whereIn("id",$services_ids)->whereIn("vendor_id",$suppliers)->get()],JSON_UNESCAPED_UNICODE);
    }

    public function GetBranchVendor(Request $request)
    {
        $longitude=$request->longitude;
        $latitude=$request->latitude;
        $branch=Branch::where("longitude",$longitude)->where("latitude",$latitude)->first();
        $vendor=User::find($branch->vendor_id,["full_name","category_title","id","photo_link"]);
        return $vendor;

    }

    public function GetSparePartsForCar($id)
    {
        $services_ids=ServiceCars::where("car_id",$id)->pluck("service_id")->unique()->toArray();
        $suppliers_ids=User::where("category_title","supplier")->pluck("id")->toArray();
        $services=Service::whereIn("id",$services_ids)->whereIn("vendor_id",$suppliers_ids)->paginate();
      //  $services=json_decode($services->toJson(),true); 

        return json_encode($services,JSON_UNESCAPED_UNICODE);
    }

    public function GetMaintenanceForCar($id)
    {
        $services_ids=ServiceCars::where("car_id",$id)->pluck("service_id")->unique()->toArray();
        $suppliers=User::where("category_title","mechanic")->paginate();
        return json_encode($suppliers,JSON_UNESCAPED_UNICODE);
    }


    public function GetSubCategoryServices(Request $request)
    {

        $services=Service::where('sub_category_id', $request->sub_category_id)->paginate();
        $services=json_decode($services->toJson(),true);
        $temp_arr=[];
        foreach($services["data"] as $service){
            //$temp_service=Service::find($service["id"]);
            $service["favourite"]=Service::find($service["id"])->FavouriteState();
            $service["rate"]=Service::find($service["id"])->RateSum();
            $service["service_category"]=User::find($service["vendor_id"])->category_title;

           // $temp_arr[]=$temp_service;
        }
      //  $services["data"]=$temp_arr;

        return json_encode($services,JSON_UNESCAPED_UNICODE);
    }



}
