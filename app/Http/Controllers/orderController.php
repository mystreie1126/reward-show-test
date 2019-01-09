<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Order;
use App\Customer_ie;
use App\voucher_ie;
use App\rd_pickup_order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    //show the coming order
    public function newOrder(){

    	if(Auth::user()->user_type == 2){
    		$data = DB::table('ps_orders as a')
            ->select('a.id_order','a.reference','a.id_customer','a.date_add','b.product_name','b.product_reference','b.total_price_tax_incl','b.product_id','ps_rewards.id_reward_state','ps_rewards.credits',
                'cus.firstname','cus.lastname',
                'cus.email','a.current_state',
                'e.active','a.total_paid_tax_incl','ps_rewards.id_reward')
            ->join('ps_customer as cus','a.id_customer','cus.id_customer')
            ->join('ps_order_detail as b','a.id_order','=','b.id_order')
            ->join('ps_feature_product as c','c.id_product','=','b.product_id')
            ->join('ps_rewards','a.id_order','=','ps_rewards.id_order')
            ->join('ps_product_shop as e','b.product_id','=','e.id_product')
            ->where('e.id_shop',1)
            ->where('c.id_feature',Auth::user()->feature_id)
            ->where('c.id_feature_value',Auth::user()->feature_value)
            ->where('a.current_state',10)
            ->where('a.date_add','>',date('Y-m-d'))
            ->where('ps_rewards.plugin','loyalty')
            ->orderBy('a.date_add','desc')
            ->get();

            $staff = DB::table('users')->select('name','shop_id')->where('shop_id',Auth::User()->shop_id)->get();
            $rockpos = Auth::User()->rockpos;
            return response()->json([ 'order' => $data,'staff'=>$staff,'rockpos'=>$rockpos]);
    	}





    }














}
