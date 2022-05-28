<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $notifications=Notification::with("user")->paginate();
        foreach($notifications as $notification){
            $notification->state=$notification->GetState();
        }
        $notifications=json_decode($notifications->toJson(),true);
        return view("notifications",compact("notifications"));
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
        
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description'=>['required', 'string', 'max:255',],
            'type' => ['required', 'string', 'max:255', Rule::in(['alert','gift','ads'])],
        ]);

        if($validator->fails()) {
            //pass validator errors as errors object for ajax response
            return redirect()->back()->withErrors(["message"=>$validator->errors()->first()]);

        }

        $data=$request->all();
        
        
        
        try {

        if($request->hasfile('image_link')){
        
            $file = $request->file('image_link');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            Storage::disk('public')->putFileAs("Notifications-photos",$file,$filename);
            $data["image_link"]=$filename;
           
        }
        if($request->filled("phone")){

            $user=User::where("phone",$request->phone)->first();
            if($user){
                    $user->AttachNotification($data);
            }
        }
        elseif($request->vendor_id!=0){

             

        }

        elseif($request->target_audience!=0){

            $users=null;
            if($request->target_audience=="ios"){
                $users=User::where("phone_type","ios")->get();
            }

            if($request->target_audience=="android"){
                $users=User::where("phone_type","android")->get();
            }

            if($request->target_audience=="premuim"){
                $users=User::where("premuim_type","!=",null)->get();
            }

            foreach($users as $user){
                $user->AttachNotification($data);
            }



        }


        elseif($request->districts!=null){
            $users=User::whereIn("location_id",$request->districts)->get();
            foreach($users as $user){
                $user->AttachNotification($data);
            }
        
        }

          dd(Notification::all());

        return redirect()->back()->withErrors(["message"=>$data["type"]." Has been Sent Successfully"]);

    }
    
     catch (\Throwable $th) {
        
       return redirect()->back()->withErrors(["message"=>$th->getMessage()]);
    
     }


    



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notification::destroy($id);
        return redirect()->back()->withErrors(["Notification has deleted sucessfully"]);
    }

    public function Search(Type $var = null)
    {
        # code...
    }
}
