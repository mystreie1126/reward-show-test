<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Confirm_payment;
use App\Models\Shared_customer;
use App\Models\Online_voucher;
use App\Models\POS_voucher;
use App\Models\POS_voucher_name;
use App\Models\POS_customer;
use App\Models\Online_customer;
use App\Models\Online_reward;
use App\Models\POS_reward;
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

	    if(Auth::check())
			{
	        $paid_order = new Confirm_payment;

	        $paid_order->paid_amount     = $request->total_paid;
	        $paid_order->order_id        = $request->order_id;
	        $paid_order->product_id      = $request->product_id;
	        $paid_order->shop_name       = $request->shopname;
	        $paid_order->rockpos_shop_id = $request->shop_id;
	        $paid_order->device_order    = $request->device;
	        $paid_order->created_at      = $request->current_time;

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
		                    $share_customer->created_at = $request->current_time;
		                    $share_customer->save();
		                }
		             }
						}//end of check customer

						$credits = Online_reward::findOrFail($request->id_reward)->credits;

						if($credits > 0){
							$reward = POS_reward::find(2916)->replicate();
							if($reward->save()){
								$pos_reward = $reward::findOrFail($reward->id_reward);
								// $pos_reward->id_reward_state = 2;
								$pos_reward->id_customer = Shared_customer::where('ie_customerid','=',$request->id_customer)->value('pos_customerid');
								$pos_reward->credits = $credits;
								$pos_reward->date_add = $request->current_time;
								$pos_reward->save();

								DB::table('ps_rewards')->where('id_reward',$request->id_reward)->update(['id_reward_state'=>4]);
								//DB::table('ps_orders')->where('id_order',$request->order_id)->update(['current_state'=>2]);
								return response()->json(['pos_credits'=>$pos_reward->credits,
																				 'online_orderid'=>$request->order_id,
																			   'online_customerid'=>$request->id_customer,
																				 'online_rewardid'=>$request->id_reward,
																				 'pos_rewardid'=>$pos_reward->id_reward
																			 ]);
							}

						}else{
							return response()->json(['valid_credits'=>'can not find valid credits']);
						}





				}

	   }//end of this function




public function check_reward(Request $request)
{
	if(Auth::check())
	{

		$pos_reward = new POS_reward;

		$pos_reward->refresh();

		$reward_state = $pos_reward->where('id_reward',$request->pos_rewardid)->value('id_reward_state');
		$cart_rule_id = $pos_reward->where('id_reward',$request->pos_rewardid)->value('id_cart_rule');


		$pos_voucher = new POS_voucher;

		$pos_voucher->refresh();
		$pos_total_reward = $pos_voucher->where('id_cart_rule','>',$cart_rule_id)->where('quantity',1)->sum('reduction_amount');

		if($reward_state == 2){
			return response()->json(['reward_used'=>0]);
		}elseif($reward_state == 4 && $pos_total_reward > 0){
			$update_to_online =	DB::table('ps_rewards')
					->where('id_reward',$request->online_rewardid)
					->where('id_customer',$request->online_customerid)
					->update(['id_reward_state' => 2,'credits'=>$pos_total_reward]);

				if($reward_state){
						$remain_reward = new POS_voucher;
						$remain_reward->refresh();
						$remain_reward->where('id_cart_rule','>',$cart_rule_id)->where('quantity',1)->delete();

						return response()->json(['reward_used'=>1]);
				}


		}


	}
}


public function voucher_results(Request $request){

	$check_customer = DB::table('ps_customer')
										->select('id_customer')
										->where('email','like','%'.$request->email.'%')->get()->first();


	// if($check_customer){
	// 	$r = new Online_reward;
	// 	$r->refresh();
	// 	$check_reward = $r->where($check_customer->id_customer)
	// }
	return response()->json(['id'=>$check_customer->id_customer]);



}








}
