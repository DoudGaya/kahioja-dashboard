@extends('layouts.logistics')
     
@section('styles')


@endsection


@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                        <h4 class="heading">{{ __("Ready for Packaging") }} <a class="add-btn" href="{{ route('logistics-ready-for-packaging-index') }}"><i class="fas fa-arrow-left"></i> {{ $langg->lang550 }}</a></h4>
                        <ul class="links">
                            <li>
                                <a href="{{ route('logistics.dashboard') }}">{{ $langg->lang441 }} </a>
                            </li>
                            <li>
                                <a href="javascript:;">{{ __("Packaging Details") }}</a>
                            </li>
                        </ul>
                </div>
            </div>
            <div class="order-table-wrap">
                            @include('includes.admin.form-both')
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="special-box">
                                        <div class="heading-area">
                                            <h4 class="title">
                                            {{ __('Order Details') }}
                                            </h4>
                                        </div>
                                        <div class="table-responsive-sm">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <th class="45%" width="45%">{{ __('Order ID') }}</th>
                                                    <td width="10%">:</td>
                                                    <td class="45%" width="45%">{{$order->order_number}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">{{ __('Total Product') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{$order->totalQty}}</td>
                                                </tr>
                                                @if($order->shipping_cost != 0)
                                                @php 
                                                $price = round(($order->shipping_cost / $order->currency_value),2);
                                                @endphp
                                                @if(DB::table('shippings')->where('price','=',$price)->count() > 0)
                                                <tr>
                                                    <th width="45%">{{ DB::table('shippings')->where('price','=',$price)->first()->title }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{ $order->currency_sign }}{{ round($order->shipping_cost, 2) }}</td>
                                                </tr>
                                                @endif
                                                @endif
                                                @if($order->packing_cost != 0)
                                                @php 
                                                $pprice = round(($order->packing_cost / $order->currency_value),2);
                                                @endphp
                                                @if(DB::table('packages')->where('price','=',$pprice)->count() > 0)
                                                <tr>
                                                    <th width="45%">{{ DB::table('packages')->where('price','=',$pprice)->first()->title }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{ $order->currency_sign }}{{ round($order->packing_cost, 2) }}</td>
                                                </tr>
                                                @endif
                                                @endif

                                                <tr>
                                                    <th width="45%">{{ __('Total Cost') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">{{ __('Ordered Date') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{date('d-M-Y H:i:s a',strtotime($order->created_at))}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">{{ __('Payment Method') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{$order->method}}</td>
                                                </tr>
                
                                                @if($order->method != "Cash On Delivery")
                                                @if($order->method=="Stripe")
                                                <tr>
                                                    <th width="45%">{{$order->method}} {{ __('Charge ID') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{$order->charge_id}}</td>
                                                </tr>                        
                                                @endif
                                                <tr>
                                                    <th width="45%">{{$order->method}} {{ __('Transaction ID') }}</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%">{{$order->txnid}}</td>
                                                </tr>                         
                                                @endif

                                                <tr>
                                                    <th width="45%">{{ __('Payment Status') }}</th>
                                                    <th width="10%">:</th>
                                                    <td width="45%">{!! $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>Unpaid</span>":"<span class='badge badge-success'>Paid</span>" !!}</td>
                                                </tr>  
                                                @if(!empty($order->order_note))
                                                <tr>
                                                    <th width="45%">{{ __('Order Note') }}</th>
                                                    <th width="10%">:</th>
                                                    <td width="45%">{{$order->order_note}}</td>
                                                </tr>  
                                                @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>



                            <div class="row">
                                    <div class="col-lg-12 order-details-table">
                                        <div class="mr-table">
                                            <h4 class="title">{{ __('Products Ordered') }}</h4>
                                            <div class="table-responsiv">
                                                    <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                <tr>
                                    <th width="10%">{{ __('Product ID#') }}</th>
                                    <th>{{ __('Shop Name') }}</th>
                                    <th>{{ __('Vendor Status') }}</th>
                                    <th>{{ __('Product Title') }}</th>
                                    <th width="20%">{{ __('Details') }}</th>
                                    <th width="10%">{{ __('Total Price') }}</th>
                                </tr>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                @foreach($cart->items as $key => $product)
                                    <tr>
                                        
                                            <td><input type="hidden" value="{{$key}}">{{ $product['item']['id'] }}</td>

                                            <td>
                                                @if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                @endphp
                                                @if(isset($user))
                                                <a target="_blank" href="{{route('admin-vendor-show',$user->id)}}">{{$user->shop_name}}</a>
                                                @else
                                                {{ __('Vendor Removed') }}
                                                @endif
                                                @else 
                                                <a  href="javascript:;">{{ App\Models\Admin::find(1)->shop_name }}</a>
                                                @endif

                                            </td>
                                            <td>
                                                @if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->first();
                                                @endphp

                                                    @if($order->dp == 1 && $order->payment_status == 'Completed')

                                                    <span class="badge badge-success">{{ __('Completed') }}</span>

                                                    @else
                                                        @if($user->status == 'pending')
                                                        <span class="badge badge-warning">{{ucwords($user->status)}}</span>
                                                        @elseif($user->status == 'processing')
                                                        <span class="badge badge-info">{{ucwords($user->status)}}</span>
                                                       @elseif($user->status == 'on delivery')
                                                        <span class="badge badge-primary">{{ucwords($user->status)}}</span>
                                                       @elseif($user->status == 'completed')
                                                        <span class="badge badge-success">{{ucwords($user->status)}}</span>
                                                       @elseif($user->status == 'declined')
                                                        <span class="badge badge-danger">{{ucwords($user->status)}}</span>
                                                       @endif
                                                    @endif

                                            @endif
                                            </td>


                                            <td>
                                                <input type="hidden" value="{{ $product['license'] }}">

                                                @if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                @endphp
                                                @if(isset($user))
                                              <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                                @else
                                                <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                                @endif
                                                @else 

                                                <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                            
                                                @endif


                                                @if($product['license'] != '')
                              <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete" class="btn btn-info product-btn" id="license" style="padding: 5px 12px;"><i class="fa fa-eye"></i> {{ __('View License') }}</a>
                                                @endif

                                            </td>
                                            <td>
                                                @if($product['size'])
                                               <p>
                                                    <strong>{{ __('Size') }} :</strong> {{str_replace('-',' ',$product['size'])}}
                                               </p>
                                               @endif
                                               @if($product['color'])
                                                <p>
                                                        <strong>{{ __('color') }} :</strong> <span
                                                        style="width: 20px; height: 20px; display: inline-block; vertical-align: middle;  background: #{{$product['color']}};"></span>
                                                </p>
                                                @endif
                                                <p>
                                                        <strong>{{ __('Price') }} :</strong> {{$order->currency_sign}}{{ round($product['item_price'] * $order->currency_value , 2) }}
                                                </p>
                                               <p>
                                                    <strong>{{ __('Qty') }} :</strong> {{$product['qty']}} {{ $product['item']['measure'] }}
                                               </p>
                                                    @if(!empty($product['keys']))

                                                    @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)
                                                    <p>

                                                        <b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} 

                                                    </p>
                                                    @endforeach

                                                    @endif




                                            </td>

                                            <td>{{$order->currency_sign}}{{ round($product['price'] * $order->currency_value , 2) }}</td>

                                    </tr>
                                @endforeach
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center mt-2">
                                        <form action="{{ route('accept-packaging-order-status',$order->order_number) }}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}        
                                            <button type="submit" class="text-white btn btn-success">
                                                Click to Accept
                                            </button>
                                        </form>
                                    </div>
                                </div>
                        </div>
            </div>    
        </div>

    </div>

@endsection


@section('scripts')

@endsection