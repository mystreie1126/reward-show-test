<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;
use App\pos_customer;
use App\pos_reward;

class rewardController extends Controller

{

     public function __construct()
    {
        $this->middleware('auth');
    }



    public function rewardOnline(Request $request){
        	DB::table('ps_rewards')->where('id_order',$request->id_order)
        	->update(['id_reward_state'=>4]);
        	return redirect()->route('homepage');;
        

    }

    public function remainReward(Request $request){

    }

    public function rewardPos(Request $request){
        
        /*
          1.online customer firstname,lastname,email
          2.online id_order and id_customer 
          3.credits
        */
      
        // $this->validate($request,[
        //     'id_order'=>'required|integer',
        //     'id_customer'=>'required|integer',
        //     'credits'=>'required|integer',
        //     'firstname'=>'required',
        //     'lastname'=>'required',
        //     'email'=>'required'
        // ]);
       
        //update firstname,lastname and email



        DB::table('ps_orders')->where('id_order',$request->id_order)->update(['current_state'=>2]);


        $customer = pos_customer::find(2680);
        $customer_template = $customer->replicate();
        $customer_template->save();



        //update credits id customer
        $reward = pos_reward::find(2885);
        $reward_template = $reward->replicate();
        $reward_template->save();

        
        $new_customer = pos_customer::findOrFail($customer_template->id_customer);

        $new_customer->firstname = $request->firstname;
        $new_customer->lastname = $request->lastname;
        $new_customer->email = $request->email;

        $new_customer->save();


        $new_reward = pos_reward::findOrFail($reward_template->id_reward);

        
        $new_reward->id_customer = $new_customer->id_customer;
        $new_reward->credits = $request->credits;

        $new_reward->save();

        return redirect()->route('homepage');
        return 2;


    }
}
