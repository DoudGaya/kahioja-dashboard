<?php

namespace App\Http\Controllers\Logistics;

use App\Models\User;
use App\Models\Withdraw;
use App\Models\Generalsetting;
use Auth;
use App\Models\Currency;
use App\Models\Logistic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:logistics');
    }

  	public function index()
    {
        $withdraws = Withdraw::where('user_id','=',Auth::guard('logistics')->user()->id)->where('type','=','logistics')->orderBy('id','desc')->get();
        $sign = Currency::where('is_default','=',1)->first();        
        return view('logistics.withdraw.index',compact('withdraws','sign'));
    }


    public function create()
    {
        $sign = Currency::where('is_default','=',1)->first();
        return view('logistics.withdraw.create' ,compact('sign'));
    }


    public function store(Request $request)
    {

        $from = Logistic::findOrFail(Auth::guard('logistics')->user()->id);
        $curr = Currency::where('is_default','=',1)->first(); 
        $withdrawcharge = Generalsetting::findOrFail(1);
        $charge = $withdrawcharge->withdraw_fee;

        if($request->amount > 0){

            $amount = $request->amount;
            //$amount = round(($amount / $curr->value),2);
            // $fee = (($withdrawcharge->withdraw_charge / 100) * $amount) + $charge;
            // $finalamount = $amount + $fee;
            
            if($from->current_balance >= $amount){

                $from->current_balance = $from->current_balance - $amount;
                $from->update();

                $finalamount = number_format((float)$amount,2,'.','');
            
                $newwithdraw = new Withdraw();
                $newwithdraw['user_id'] = Auth::user()->id;
                $newwithdraw['method'] = 'Requested';
                $newwithdraw['acc_email'] = $request->acc_email;
                $newwithdraw['iban'] = $request->iban;
                $newwithdraw['country'] = $request->acc_country;
                $newwithdraw['acc_name'] = $request->acc_name;
                $newwithdraw['bank_name'] = $request->bank_name;
                $newwithdraw['address'] = $request->address;
                //$newwithdraw['swift'] = $request->swift;
                $newwithdraw['reference'] = $request->reference;
                $newwithdraw['amount'] = $finalamount;
                $newwithdraw['fee'] = 0;
                $newwithdraw['type'] = 'logistics';
                $newwithdraw->save();

                return response()->json('Withdraw Request Sent Successfully.'); 

            }else{
                 return response()->json(array('errors' => [ 0 => 'Insufficient Balance.' ])); 
            }
        }
            return response()->json(array('errors' => [ 0 => 'Please enter a valid amount.' ])); 

    }
}