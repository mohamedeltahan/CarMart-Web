<?php

namespace App\Http\Controllers\Carts;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Unset_;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        
        $user=Auth::user();
        $cart_items_id=$user->Cart;
        $items=[];
        foreach($cart_items_id as $c){
            $item=Service::find($c->item_id);
            $item->quantity=$c->quantity;
            $items[]=$item;
        }
         

        

        return json_encode(["items"=>$items,"total"=>$user->CartTotal()],JSON_UNESCAPED_UNICODE);
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
            $items_ids=$request->items_ids;

            for($i=0;$i<sizeof($items_ids);$i++){
                if(Cart::where("user_id",Auth::id())->where("item_id",$items_ids[$i])->first()!=null){
                    return true;
                }
                $cart=new Cart();
                $cart->user_id=Auth::user()->id;
                $cart->item_id=$items_ids[$i];
                $cart->quantity=$request->quantity[$i];
                $cart->save();
            }
            return true;
        } catch (\Throwable $th) {
            return json_encode(["state"=>"error","message"=>$th->getMessage()]);
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
        $user=Auth::user();
        $data=$request->all();
        if(Cart::where("user_id",Auth::id())->where("item_id",$id)->first()!=null){
            Cart::where("user_id",Auth::id())->where("item_id",$id)->update($data);
        }
        $cart_items_id=$user->Cart;
        $items=[];
        foreach($cart_items_id as $c){
            $item=Service::find($c->item_id);
            $item->quantity=$c->quantity;
            $items[]=$item;
        }
         

        return json_encode(["items"=>$items,"total"=>$user->CartTotal()],JSON_UNESCAPED_UNICODE);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user=Auth::user();
            Cart::where("user_id",$user->id)->where("item_id",$id)->delete();
            return true;
        } catch (\Throwable $th) {
            return json_encode(["state"=>"error","message"=>$th->getMessage()]);
        }
        
    }
}
