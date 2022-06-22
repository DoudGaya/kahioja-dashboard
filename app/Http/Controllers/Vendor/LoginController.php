<?php

namespace App\Http\Controllers\Vendor;

use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\Logistic;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;


class LoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:web', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
      return view('vendor.login');
    }

    public function login(Request $request)
    {
        //--- Validation Section
        $rules = [
                  'email'   => 'required|email',
                  'password' => 'required'
                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

      // Attempt to log the user in
      if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        if(Auth::guard('web')->user()->email_verified == 'No')
        {
          Auth::guard('web')->logout();
          return response()->json(array('errors' => [ 0 => 'Your Email is not Verified' ]));   
        }

        if(Auth::guard('web')->user()->ban == 1)
        {
          Auth::guard('web')->logout();
          return response()->json(array('errors' => [ 0 => 'Your Account Has Been Banned' ]));   
        }

        if(Auth::guard('web')->user()->is_vendor < 1)
        {
            Auth::guard('web')->logout();
            return response()->json(array('errors' => [ 0 => 'Not Vendor!' ]));         
        }
        // if successful, then redirect to their intended location
        return response()->json(route('vendor-dashboard'));
      }

      // if unsuccessful, then redirect back to the login with the form data
          return response()->json(array('errors' => [ 0 => 'Credentials Doesn\'t Match !' ]));     
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }
}
