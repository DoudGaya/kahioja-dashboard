<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\User;
use App\Models\Bag;
use App\Models\Product;
use App\Models\VendorOrder;
use App\Models\LogisticsDelivery;;
use Datatables;
use PDF;
use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables($status)
    {
        if($status == 'pending'){
            $datas = Order::where('status','=','pending')->where('payment_status', 'completed')->get();
        }
        else if($status == 'processing') {
            $datas = Order::where('status','=','processing')->where('payment_status', 'completed')->get();
        }
        else if($status == 'completed') {
            $datas = Order::where('status','=','completed')->where('payment_status', 'completed')->orderby('id','desc')->get();
        }
        else if($status == 'ready for delivery') {
            $datas = Order::where('status','=','ready for delivery')->where('payment_status', 'completed')->orderby('id','desc')->get();
        }
        else if($status == 'accept delivery') {
            $datas = Order::where('status','=','accept delivery')->where('payment_status', 'completed')->orderby('id','desc')->get();
        }
        else if($status == 'pick up for delivery') {
            $datas = Order::where('status','=','pick up for delivery')->where('payment_status', 'completed')->orderby('id','desc')->get();
        }
        else if($status == 'on delivery') {
            $datas = Order::where('status','=','on delivery')->where('payment_status', 'completed')->orderby('id','desc')->get();
        }
        else if($status == 'delivered') {
            $datas = Order::where('status','=','delivered')->where('payment_status', 'completed')->orderby('id','desc')->get();
        }
        else if($status == 'declined') {
            $datas = Order::where('status','=','declined')->where('payment_status', 'completed')->get();
        }
        else{
          $datas = Order::orderBy('id','desc')->where('payment_status', 'completed')->get();  
        }
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('id', function(Order $data) {
                                $id = '<a href="'.route('admin-order-invoice',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('pay_amount', function(Order $data) {
                                return $data->currency_sign . round($data->pay_amount * $data->currency_value , 2);
                                // return $data->currency_sign .$data->pay_amount;
                            })
                            ->addColumn('action', function(Order $data) {
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> Delivery Status</a>';
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a><a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send</a><a href="javascript:;" data-href="'. route('admin-order-track',$data->id) .'" class="track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> Track Order</a>'.$orders.'</div></div>';
                            }) 
                            ->rawColumns(['id','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function index()
    {
        return view('admin.order.index');
    }

    public function edit($id)
    {
        $data = Order::find($id);
        return view('admin.order.delivery',compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {

        //--- Logic Section
        $data = Order::findOrFail($id);
               
        $input = $request->all();

        if($data->status == "delivered"){
            // Then Save Without Changing it.
                $input['status'] = "delivered";
                $data->update($input);
                //--- Logic Section Ends
        
            //--- Redirect Section          
            $msg = 'Status Updated Successfully.';
            return response()->json($msg);    
            //--- Redirect Section Ends     
        }else{
            if($input['status'] == "delivered"){
                // The Admin would not be completing the transaction!!!
                foreach($data->vendororders as $vorder)
                {
                    $uprice = User::findOrFail($vorder->user_id);
                    $uprice->current_balance = $uprice->current_balance + $vorder->price;
                    $uprice->update();

                    $updateDeliveryStatus = LogisticsDelivery::where('order_number','=',$data)->where('vendor_id','=',$vorder->user_id)->update(['delivery_status' => 3]);
                    
                    // Logistic get his money
                    $company = VendorOrder::where('logistics_id','=',$vorder->logistics_id)->where('order_number','=',$data)->first();
                    if($company != null){
                        $total_sell = VendorOrder::where('logistics_id','=',$vorder->logistics_id)->where('user_id','=',$vorder->user_id)->where('order_number','=',$data)->sum('ship_fee');    
                        $company->current_balance = $company->current_balance + $total_sell;
                        $company->update();
                    }
                }
    
                // if( User::where('id', $data->affilate_user)->exists() ){
                //     $auser = User::where('id', $data->affilate_user)->first();
                //     $auser->affilate_income += $data->affilate_charge;
                //     $auser->update();
                // }
                $gs = Generalsetting::findOrFail(1);
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Confirmed!',
                        'body' => "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.",
                    ];
    
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);                
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Confirmed!';
                   $msg = "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.";
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);                
                }
            }

            if ($input['status'] == "declined"){

                $cart = unserialize(bzdecompress(utf8_decode($data->cart)));

                foreach($cart->items as $prod)
                {
                    $x = (string)$prod['stock'];
                    if($x != null)
                    {
                        $product = Product::findOrFail($prod['item']['id']);
                        $product->stock = $product->stock + $prod['qty'];
                        $product->update();               
                    }
                }


                foreach($cart->items as $prod)
                {
                    $x = (string)$prod['size_qty'];
                    if(!empty($x))
                    {
                        $product = Product::findOrFail($prod['item']['id']);
                        $x = (int)$x;
                        $temp = $product->size_qty;
                        $temp[$prod['size_key']] = $x;
                        $temp1 = implode(',', $temp);
                        $product->size_qty =  $temp1;
                        $product->update();               
                    }
                }


                
                $gs = Generalsetting::findOrFail(1);
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Declined!',
                        'body' => "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.",
                    ];
                $mailer = new GeniusMailer();
                $mailer->sendCustomMail($maildata);
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Declined!';
                   $msg = "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.";
                   $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);
                }
    
            }

            $data->update($input);

            if($request->track_text)
            {
                    $title = ucwords($request->status);
                    $ck = OrderTrack::where('order_id','=',$id)->where('title','=',$title)->first();
                    if($ck){
                        $ck->order_id = $id;
                        $ck->title = $title;
                        $ck->text = $request->track_text;
                        $ck->update();  
                    }
                    else {
                        $data = new OrderTrack;
                        $data->order_id = $id;
                        $data->title = $title;
                        $data->text = $request->track_text;
                        $data->save();            
                    }
    
    
            } 


        $order = VendorOrder::where('order_id','=',$id)->update(['status' => $input['status']]);

         //--- Redirect Section          
         $msg = 'Status Updated Successfully.';
         return response()->json($msg);    
         //--- Redirect Section Ends    
    
            }

        //--- Redirect Section          
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends  

    }

    public function pending()
    {
        return view('admin.order.pending');
    }
    public function processing()
    {
        return view('admin.order.processing');
    }
    public function completed()
    {
        return view('admin.order.completed');
    }
    public function readyfordelivery()
    {
        return view('admin.order.readyfordelivery');
    }
    public function acceptdelivery()
    {
        return view('admin.order.acceptdelivery');
    }
    public function pickedupfordelivery()
    {
        return view('admin.order.pickedupfordelivery');
    }
    public function ondelivery()
    {
        return view('admin.order.ondelivery');
    }
    public function delivered()
    {
        return view('admin.order.delivered');
    }
    public function declined()
    {
        return view('admin.order.declined');
    }
    public function show($id)
    {
        if(!Order::where('id',$id)->exists())
        {
            return redirect()->route('admin.dashboard')->with('unsuccess',__('Sorry the page does not exist.'));
        }
        $order = Order::findOrFail($id);
        // $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $order_no = $order->order_number;
        // $bags = Bag::where('order_no', $order_no)->get();

        $bags = DB::table('bags')
        ->join('users','bags.vendor_id','=','users.id')
        ->join('products','bags.product_id','=','products.id')
        ->select(
            ['products.id AS product_id', 'products.name AS product_name', 'products.photo AS product_photo',
            'bags.quantity AS quantity', 'bags.amount AS amount', 'bags.ship_fee AS ship_fee', 'bags.status AS order_status', 'bags.paid AS paid', 'bags.order_no AS order_no', 'bags.created_at AS time_ordered', 
            'users.shop_name AS shop_name', 'users.shop_address AS shop_address', 'users.shop_number AS shop_number',
        ])
        ->where('bags.order_no','=',$order_no)
        ->orderby('bags.id','desc')
        ->get();
        
        // dd($bags);
        
        return view('admin.order.details',compact('order','bags'));
    }
    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        $order_no = $order->order_number;
        $cart = DB::table('bags')
        ->join('users','bags.vendor_id','=','users.id')
        ->join('products','bags.product_id','=','products.id')
        ->join('orders','bags.order_no','=','orders.order_number')
        ->select(
            ['products.id AS product_id', 'products.name AS product_name', 'products.photo AS product_photo',
            'bags.quantity AS quantity', 'bags.amount AS amount', 'bags.ship_fee AS ship_fee', 'bags.status AS order_status', 'bags.paid AS paid', 'bags.order_no AS order_no', 'bags.created_at AS time_ordered', 
            'users.shop_name AS shop_name', 'users.shop_address AS shop_address', 'users.shop_number AS shop_number',
            'orders.pay_amount AS total_cost'
        ])
        ->where('bags.order_no','=', $order_no)
        ->orderby('bags.id','desc')
        ->get();

        return view('admin.order.invoice',compact('order','cart'));
    }
    public function emailsub(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);
        if($gs->is_smtp == 1)
        {
            $data = 0;
            $datas = [
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'body' => $request->message,
            ];

            $mailer = new GeniusMailer();
            $mail = $mailer->sendCustomMail($datas);
            if($mail) {
                $data = 1;
            }
        }
        else
        {
            $data = 0;
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            $mail = mail($request->to,$request->subject,$request->message,$headers);
            if($mail) {
                $data = 1;
            }
        }

        return response()->json($data);
    }

    public function printpage($id)
    {
        $order = Order::findOrFail($id);
        $order_no = $order->order_number;
        $cart = DB::table('bags')
        ->join('users','bags.vendor_id','=','users.id')
        ->join('products','bags.product_id','=','products.id')
        ->join('orders','bags.order_no','=','orders.order_number')
        ->select(
            ['products.id AS product_id', 'products.name AS product_name', 'products.photo AS product_photo',
            'bags.quantity AS quantity', 'bags.amount AS amount', 'bags.ship_fee AS ship_fee', 'bags.status AS order_status', 'bags.paid AS paid', 'bags.order_no AS order_no', 'bags.created_at AS time_ordered', 
            'users.shop_name AS shop_name', 'users.shop_address AS shop_address', 'users.shop_number AS shop_number',
            'orders.pay_amount AS total_cost'
        ])
        ->where('bags.order_no','=', $order_no)
        ->orderby('bags.id','desc')
        ->get();
        
        return view('admin.order.print',compact('order','cart'));
    }

    public function license(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $cart->items[$request->license_key]['license'] = $request->license;
        $order->cart = utf8_encode(bzcompress(serialize($cart), 9));
        $order->update();       
        $msg = 'Successfully Changed The License Key.';
        return response()->json($msg);
    }
}