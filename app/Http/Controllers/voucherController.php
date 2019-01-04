<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Confirm_payment;
use App\Models\Shared_customer;
// use App\Cart_voucher;
use App\Models\POS_customer;
// use App\pos_reward;
// use App\pos_cart_voucher;
//
// use App\pos_voucher_name;
use DB;
class voucherController extends Controller
{

	public function __construct()
	    {
	        $this->middleware('auth');
	    }


public function createPosVoucher(Request $request)
{

    if(Auth::check()){
        $paid_order = new Confirm_payment;

        $paid_order->paid_amount     = $request->total_paid;
        $paid_order->order_id        = $request->order_id;
        $paid_order->product_id      = $request->product_id;
        $paid_order->shop_name       = $request->shopname;
        $paid_order->rockpos_shop_id = $request->shop_id;
        $paid_order->device_order    = $request->device;
        $paid_order->created_at      = $request->current_date;

        $paid_order->save();

				//check if customer exisit in rockpos
					if( Shared_customer::where('ie_customerid','=',$request->id_customer)->count()==0)
					{
						$customer = POS_customer::find(2799);
            $customer_template = $customer->replicate();

            if($customer_template->save())
						{
                $new_customer = POS_customer::findOrFail($customer_template->id_customer);

                $new_customer->firstname = $request->firstname;
                $new_customer->lastname = $request->lastname;
                $new_customer->email = $request->email;
                if($new_customer->save())
								{
                    $share_customer = new Shared_customer;
                    $share_customer->ie_customerid = $request->id_customer;
                    $share_customer->pos_customerid = $new_customer->id_customer;
                    $share_customer->created_at = date("Y-m-d H:i:s");
                    $share_customer->save();
                }
             }
					}


					
					$d = POS_customer::find(2799)->id_customer;

					return response()->json(['data' => $d]);


    }


}

}