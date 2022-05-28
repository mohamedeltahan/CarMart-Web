<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    //

    public function StorePhoto(Request $request)
    {
            
            $file = $request->file('photo_link');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =$request->photo_name."-".time().'.'.$extension;
            Storage::disk('public')->putFileAs($request->folder_name,$file,$filename);
            if($request->filled("vendor")){
               $vendor=User::find($request->vendor);
               $vendor->banner_photo=$filename;
               $vendor->save();

            }
            return redirect()->back();            
    }
    
    public function GetPhotos($folder_name)
    {
        $files = Storage::disk('public')->allFiles($folder_name);
           
        $arr=[];
        foreach($files as $file){
        $renamed_file=str_replace($folder_name."/","",$file);
        $arr[explode("-",$renamed_file)[0]]=$file;
        }

        $vendors=User::where("account_type","Vendor")->get();


    
      


        return view("photos",compact("arr","vendors"));
    
        
    }

    public function DestroyPhoto(Request $request)
    {
        try {
            Storage::disk('public')->delete($request->path);
            return redirect()->back()->withErrors(["photo has been deleted successfully"]);

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);

        }
        
    }

    public function CarsIndex(Request $request)
    {
        
        $user=Auth::user();
       // $number_of_records_in_page=5;
        $cars=Car::paginate();
        $cars=json_decode($cars->toJson(),true);
        if(str_contains(url()->current(), 'api')){
            return json_encode($cars,JSON_UNESCAPED_UNICODE);
        }

        return view("cars.index",compact("cars"));


    }

    public function CarsDestroy($id)
    {
        try {
            Car::destroy($id);
            return redirect()->back()->withErrors(["Car Brand Has Been Deleted Successfully"]);

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
       

    }
    
    public function CarsUpdate($id,Request $request)
    {
        try {
            $car=Car::find($id);
            $data=$request->all();
            if($request->hasfile('image_link')){
                $file = $request->file('image_link');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                Storage::disk('public')->putFileAs("cars-photos",$file,$filename);
                $data["image_link"]=$filename;
            }
            $car->update($data);
            return redirect()->back()->withErrors(["Car Brand Has Been Updated Successfully"]);

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
       

    }

    public function CarsStore(Request $request)
    {
        try {
            $data=$request->all();
            if($request->hasfile('image_link')){
                $file = $request->file('image_link');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                Storage::disk('public')->putFileAs("cars-photos",$file,$filename);
                $data["image_link"]=$filename;
            }
            Car::create($data);
            return redirect()->back()->withErrors(["Car Brand Has Been Inserted Successfully"]);

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
       

    }

    public function CarsSearch(Request $request)
    {
        try {

            $value=$request->value;
            $cars=Car::WhereLike("brand",$value)->OrWhereLike("model",$value)->OrWhereLike("year",$value)->get();
            if(str_contains(url()->current(), 'api')){
                return json_encode($cars,JSON_UNESCAPED_UNICODE);
            }
            return view("cars.index",compact($cars));

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
       

    }

    public function CategoriesSearch(Request $request)
    {
        try {

            $value=$request->value;
            $categories=Category::where("title","like","%".$value."%")->paginate(100);
            $categories=json_decode($categories->toJson(),true);
            if(str_contains(url()->current(), 'api')){
                return json_encode($categories,JSON_UNESCAPED_UNICODE);
            }
            
            return view("categories.index",compact("categories","value"));

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
       

    }

    public function CategoriesIndex(Type $var = null)
    {   
        $categories=Category::paginate();
        $categories=json_decode($categories->toJson(),true);
        if(str_contains(url()->current(), 'api')){
            return json_encode($categories,JSON_UNESCAPED_UNICODE);
        }
       
       
       
      return view("Categories.index",compact("categories"));

    }

    public function SubCategoriesIndex(Request $request)
    {   
        $categories=null;

        if($request->filled("category_id")){
            $categories=SubCategory::where("category_id",$request->category_id)->paginate();
        }
        else{
            $categories=SubCategory::paginate();
        }
        $categories=json_decode($categories->toJson(),true);
        if(str_contains(url()->current(), 'api')){
            return json_encode($categories,JSON_UNESCAPED_UNICODE);
        }
       
       
       
      return view("Categories.index",compact("categories"));

    }



    public function CategoriesStore(Request $request)
    {
        $validatedData = $request->validate([
            'ar_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'en_description' => 'required|string',
            'ar_description' => 'required|string',  
            'photo_link' =>'required',
          
        ]);
        $data=$request->all();

        /*$image = $request->file('photo_link');
        $input['imagename'] = time().'.'.$image->extension();
     
        $destinationPath = public_path();
        $img = Image::make($image->path());
        $img->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'\\'.$input['imagename']);
   
        $destinationPath = public_path('\images');
        $image->move($destinationPath, $input['imagename']);
   
        */
        

        try {

            if($request->hasfile('photo_link')){
              $file = $request->file('photo_link');
              $extension = $file->getClientOriginalExtension(); // getting image extension
              $filename =time().'.'.$extension;
              Storage::disk('public')->putFileAs("categories-photos",$file,$filename);
              $data["photo_link"]=$filename;
             }
             if($request->hasfile('icon')){
                $file = $request->file('icon');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                Storage::disk('public')->putFileAs("icons",$file,$filename);
                $data["icon"]=$filename;
               }

               if($request->hasfile('colored_icon')){
                $file = $request->file('colored_icon');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                Storage::disk('public')->putFileAs("colored-icons",$file,$filename);
                $data["colored_icon"]=$filename;
               }

               if($request->hasfile('map_icon')){
                $file = $request->file('map_icon');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                Storage::disk('public')->putFileAs("map-icons",$file,$filename);
                $data["map_icon"]=$filename;
               }
            // $data["sub_categories"]=json_encode($request->sub_categories);
             Category::create($data);


           } catch (\Throwable $th) {
              dd($th->getMessage());
             return redirect()->back()->withErrors(["there is some error happend....kindly contact support"]);;
         }


     

     return redirect()->back();



        
        
    }

    public function SubCategoriesStore(Request $request)
    {
        $validatedData = $request->validate([
            'ar_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'en_description' => 'required|string',
            'ar_description' => 'required|string',  
            'photo_link' =>'required',
          
        ]);
        $data=$request->all();

        /*$image = $request->file('photo_link');
        $input['imagename'] = time().'.'.$image->extension();
     
        $destinationPath = public_path();
        $img = Image::make($image->path());
        $img->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'\\'.$input['imagename']);
   
        $destinationPath = public_path('\images');
        $image->move($destinationPath, $input['imagename']);
   
        */
        

        try {

            if($request->hasfile('photo_link')){
              $file = $request->file('photo_link');
              $extension = $file->getClientOriginalExtension(); // getting image extension
              $filename =time().'.'.$extension;
              Storage::disk('public')->putFileAs("subcategories-photos",$file,$filename);
              $data["photo_link"]=$filename;
             }
             if($request->hasfile('icon')){
                $file = $request->file('icon');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                Storage::disk('public')->putFileAs("icons",$file,$filename);
                $data["icon"]=$filename;
               }

               if($request->hasfile('colored_icon')){
                $file = $request->file('colored_icon');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                Storage::disk('public')->putFileAs("colored-icons",$file,$filename);
                $data["colored_icon"]=$filename;
               }

               if($request->hasfile('map_icon')){
                $file = $request->file('map_icon');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                Storage::disk('public')->putFileAs("map-icons",$file,$filename);
                $data["map_icon"]=$filename;
               }
            // $data["sub_categories"]=json_encode($request->sub_categories);
             SubCategory::create($data);


           } catch (\Throwable $th) {
              dd($th->getMessage());
             return redirect()->back()->withErrors(["there is some error happend....kindly contact support"]);;
         }


     

     return redirect()->back();



        
        
    }



    public function SubCategoriesUpdate(Request $request,$id)
    {
        $validatedData = $request->validate([
            'ar_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'en_description' => 'required|string',
            'ar_description' => 'required|string',            
        ]);

        $data=$request->all();
        
        

     

          try {

            if($request->hasfile('photo_link')){
                
              $file = $request->file('photo_link');
              $extension = $file->getClientOriginalExtension(); // getting image extension
              $filename =time().'.'.$extension;
              Storage::disk('public')->putFileAs("subcategories-photos",$file,$filename);
              $data["photo_link"]=$filename;

             }
             if($request->hasfile('icon')){
                $file = $request->file('icon');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                Storage::disk('public')->putFileAs("icons",$file,$filename);
                $data["icon"]=$filename;
            }

            if($request->hasfile('colored_icon')){
                $file = $request->file('colored_icon');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                Storage::disk('public')->putFileAs("colored-icons",$file,$filename);
                $data["colored_icon"]=$filename;
               }

             if($request->hasfile('map_icon')){
                $file = $request->file('map_icon');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                Storage::disk('public')->putFileAs("map-icons",$file,$filename);
                $data["map_icon"]=$filename;
             }

            //$data["sub_categories"]=json_encode($request->sub_categories);

            $category=SubCategory::find($id);
            $category->update($data);

            


           } catch (\Throwable $th) {
               
                
             return redirect()->back();
         }

         return redirect()->back();

    }

    public function CategoriesDestroy($id)
    {
        
        Category::destroy($id);
        return redirect()->back()->withErrors(["Category has deleted sucessfully"]);

    }
    public function SubCategoriesDestroy($id)
    {
        
        SubCategory::destroy($id);
        return redirect()->back()->withErrors(["Category has deleted sucessfully"]);

    }

    public function GetCarBrands()
    {  
        return json_encode(["items"=>array_values(array_unique(Car::all("brand")->pluck("brand")->toArray()))],JSON_UNESCAPED_UNICODE);
    }

    public function GetCarModels($brand)
    {
        return json_encode(["items"=>array_values(array_unique(Car::where("brand",$brand)->get("model")->pluck("model")->toArray()))],JSON_UNESCAPED_UNICODE);
    }
    public function GetCarYears($brand,$model)
    {
    
        return json_encode(["items"=>array_values(array_unique(Car::where("brand",$brand)->where("model",$model)->get("year")->pluck("year")->toArray()))],JSON_UNESCAPED_UNICODE);
    }
    public function GetCarId($brand,$model,$year)
    {
        try {
            
            return json_encode(["car_id"=>Car::where("brand",$brand)->where("model",$model)->where("year",$year)->first()->id],JSON_UNESCAPED_UNICODE);

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    
    }

    public function appsettings(Type $var = null)
    {
        $setting=DB::table("settings")->first();
        if(str_contains(url()->current(), 'api')){
            return json_encode($setting,JSON_UNESCAPED_UNICODE);
        }
        return view("settings",compact("setting"));
    }

    public function appsettingsstore(Request $request)
    {
        DB::table('settings')->take(1)->update($request->except("_token"));
        return redirect()->back();
    }

    



}
