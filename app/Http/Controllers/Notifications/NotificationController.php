<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user=Auth::user();
        $index=1;
        $number_of_records_in_page=5;
        if($request->has("index")){
            $index=$request->index;
        }
        $ids=[];
        if($user->account_type=="Admin"){
            $notifications = Notification::orderBy('id', 'DESC')->with("user")->paginate();
            $seen_notification_count=Notification::where("seen",1)->count();
            $unseen_notification_count=Notification::where("seen",0)->count();
      
        }
      
        else{
            $notifications = Notification::orderBy('id', 'DESC')->where("user_id",Auth::id())->paginate();

            /*$seen_notification_count=Notification::where("vendor_id",Auth::user()->id)->where("type","!=","gift")->where("seen",1)->count();
            $unseen_notification_count=Notification::where("vendor_id",Auth::user()->id)->where("type","!=","gift")->where("seen",0)->count();
    */
        }
        if(str_contains(url()->current(), 'api')){
            
            return json_encode($notifications,JSON_UNESCAPED_UNICODE);
        }

        $notifications=json_decode($notifications->toJson(),true);

        return view("notifications",compact("notifications","index","seen_notification_count","unseen_notification_count"));

    }
    

}
