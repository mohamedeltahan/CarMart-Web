<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user=Auth::user();
        if($user->account_type=="Vendor"){
            $branches=Branch::where("vendor_id",$user->id)->with("user")->paginate();
        }
        elseif($user->account_type=="Admin"){
            $branches=Branch::with("user")->paginate();
        }
        $vendors=User::where("account_type","Vendor")->get();
        $branches=json_decode($branches->toJson(),true);
        return view("Branches.index",compact("branches","vendors"));
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
        $validatedData = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'longitude'=>['required', 'string', 'max:255',],
            'latitude' => ['required', 'string', 'max:255'],
            'city'=>['required', 'string', 'max:255',], 
            'address'=>['required', 'string', 'max:255',],
            'phone'=>['required', 'string', 'max:255',],
            'start_time'=>['required', 'string'],
            'end_time'=>['required', 'string'],



        ]);
        try {
            if(Auth::user()->account_type=="Vendor"){
                Auth::user()->StoreBranch($request->all());
            }
            else{
                User::find($request->vendor_id)->StoreBranch($request->all());
            }
            
             return redirect()->back()->withErrors(["message"=>"Branch has added successfully"]);

        } catch (\Throwable $th) {

            return redirect()->back()->withErrors(["message"=>$th->getMessage()]);

        }

    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try {
            $data=$request->all();
            $branch=Branch::find($id);
            $branch->update($data);
            return redirect()->back()->withErrors(["message"=>"Branche has updated successfully"]);
     
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(["message"=>$th->getMessage()]);
        }
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            Branch::destroy($id);
            return redirect()->back()->withErrors(["message"=>"Branche has deleted successfully"]);


        } catch (\Throwable $th) {
                    
            return redirect()->back()->withErrors(["message"=>$th->getMessage()]);


        }

    }


    public function Search(Request $request)
    {
        
        $value=$request->value;
        $branches=null;
        if(Auth::user()->account_type=="Admin"){
            $branches=Branch::with("user")->where("name", 'like', '%'.$value.'%')->get();
        }
        elseif(Auth::user()->account_type=="Vendor"){
            $branches=Branch::with("user")->where("vendor_id",Auth::user()->id)->where("name", 'like', '%'.$value.'%')->get();
        }
        $count=sizeof($branches);
        $no_of_pages=1;
        $number_of_records_in_page=$count;
        $index=1;
        $vendors=User::where("account_type","Vendor")->get();
        $branches=["data"=>json_decode($branches,true),"total"=>sizeof($branches),"links"=>[],"current_page"=>1];
       
        return view("Branches.index",compact("branches","vendors","value"));

    


    }


    
}
