<?php

namespace App\Http\Controllers\ContactUs;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        
        $user=Auth::user();
        $ids=null;
        
        if($user->account_type=="Normal"){
            $contacts = ContactUs::where("title","Live Support")->where("user_id",$user->id)->orderBy('id', 'DESC')->paginate();
        }
        else{
            $contacts = ContactUS::orderBy('id', 'DESC')->paginate();
        }
     
        
        if(str_contains(url()->current(), 'api')){
            
            return json_encode($contacts,JSON_UNESCAPED_UNICODE);
        }
        $responded_count=ContactUS::where("title","Live Support")->where("response","!=",null)->count();
        $email_count=ContactUS::where("title","!=","Live Support")->count();
        $contacts=json_decode($contacts->toJson(),true);
        return view("contactus",compact("contacts"));

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
        
        try {
            $contactus=new ContactUS();
            $contactus->name=$request->name;
            $contactus->user_id=Auth::user()->id;
            
            $contactus->email=$request->email;
            $contactus->phone=$request->phone;
            $contactus->title=$request->title;
            
            $contactus->description=$request->description;
            $contactus->save();
            return json_encode(["state"=>"done"]);
        } catch (\Throwable $th) {
            return json_encode(["error"=>$th->getMessage()]);
        }
       
        
    }

    
   
    public function ChatUsStore(Request $request)
    {

        try {
            $user=Auth::user();
            $contactus=new ContactUS();
            $contactus->name=$user->full_name;
            $contactus->user_id=Auth::user()->id;
            
            $contactus->email=$user->email;
            $contactus->phone=$user->phone;
            $contactus->title="Live Support";
            
            $contactus->description=$request->description;
            $contactus->save();
            return json_encode(["state"=>"done"]);
        } catch (\Throwable $th) {
            return json_encode(["error"=>$th->getMessage()]);
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
        $contactus=ContactUS::find($id);

        try {
  
          $contactus->update($request->all());
          return redirect()->back()->withErrors(["message"=>"Response Has Been Sent"]);
  
        } catch (\Throwable $th) {
  
          return redirect()->back()->withErrors(["message"=>$th->getMessage()]);
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
        //
    }
}
