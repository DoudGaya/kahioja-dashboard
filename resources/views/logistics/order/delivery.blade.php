@extends('layouts.logistics')
     
@section('styles')

@endsection


@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                        <h4 class="heading">{{ __("Ready for Delivery") }} <a class="add-btn" href="{{ route('logistics-ready-for-delivery-index') }}"><i class="fas fa-arrow-left"></i> {{ $langg->lang550 }}</a></h4>
                        <ul class="links">
                            <li>
                                <a href="{{ route('logistics.dashboard') }}">{{ $langg->lang441 }} </a>
                            </li>
                            <li>
                                <a href="javascript:;">{{ __("Delivery Details") }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="order-table-wrap">
                @include('includes.admin.form-both')
                <h4 class="heading">No of Shops: {{ count($datas) }}</h4>
                <div class="row">
                    @foreach($datas as $data)
                        <div class="col-lg-6">
                            <div class="special-box">
                                <div class="heading-area">
                                    <h4 class="title">
                                    {{ __('Pick Up Information') }}
                                    </h4>
                                </div>
                                <div class="table-responsive-sm">
                                    <table class="table">
                                        <tbody>
                                            @if($order->shipping == "pickup")
                                            <tr>
                                                <th width="45%"><strong>{{ __('Pickup Location') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{$order->pickup_location}}</td>
                                            </tr>
                                            @else
                                            <tr>
                                                <th width="45%"><strong>{{ __('Order No') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td>{{ $loop->index + 1 }}</td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Order ID') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td>{{$data->order_number}}</td>
                                            </tr> 
                                            <tr>
                                                <th width="45%"><strong>{{ __('Shop Name') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td>{{$data->shop_name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Shop Owner') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td>{{$data->owner_name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Shop Address') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td>{{$data->shop_address}}</td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Shop Phone') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td>{{$data->shop_number}}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="heading-area">
                                    <h4 class="title">
                                    {{ __('Delivery Information') }}
                                    </h4>
                                </div>
                                <div class="table-responsive-sm">
                                    <table class="table">
                                        <tbody>
                                            @if($order->shipping == "pickup")
                                            <tr>
                                                <th width="45%"><strong>{{ __('Pickup Location') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{$order->pickup_location}}</td>
                                            </tr>
                                            @else
                                            <tr>
                                                <th width="45%"><strong>{{ __('Customer Name') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td>{{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}</td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Customer Email') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}</td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Customer Phone') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}</td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Customer Address') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}</td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Customer Country') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{$order->shipping_country == null ? $order->customer_country : $order->shipping_country}}</td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Customer City') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}</td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Postal Code') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mr-table">
                                    <div class="heading-area">
                                        <h4 class="title">
                                        {{ __('Product Ordered') }}
                                        </h4>
                                    </div>
                                    <div class="table-responsiv">
                                        <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="30%">{{ __('Product Title') }}</th>
                                                    <th width="30%">{{ __('Details') }}</th>
                                                    <th width="20%">{{ __('Total Price') }}</th>
                                                    <th width="20%">{{ __('Delivery Fee') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cart->items as $key => $product)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" value="{{ $product['license'] }}">

                                                        @if($product['item']['user_id'] == $data->user_id)
                                                            @php
                                                            $user = App\Models\User::find($product['item']['user_id']);
                                                            @endphp
                                                            @if(isset($user))
                                                                <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                                            @else
                                                                <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                                            @endif
                                                        @endif

                                                        @if($product['license'] != '')
                                                            <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete" class="btn btn-info product-btn" id="license" style="padding: 5px 12px;"><i class="fa fa-eye"></i> {{ __('View License') }}</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($product['item']['user_id'] == $data->user_id)
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
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($product['item']['user_id'] == $data->user_id)
                                                            {{$order->currency_sign}}{{ round($product['price'] * $order->currency_value , 2) }}
                                                        @endif    
                                                    </td>
                                                    <td>
                                                        @if($product['item']['user_id'] == $data->user_id)
                                                            @if($product['item']['ship_fee'] != 0)
                                                                {{$order->currency_sign}}{{ round($product['item']['ship_fee'] * $order->currency_value , 2) }}
                                                            @else
                                                                Free Delivery
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center pb-4">
                                    <form action="{{ route('accept-delivery-order-status', $order->order_number) }}" method="POST" enctype="multipart/form-data">
                                    {{csrf_field()}}        
                                        <input type="hidden" name="vendor_id" value="{{ $data->user_id }}">
                                        <button type="submit" class="text-white btn btn-success">
                                            Click to Accept Delivery
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>                 
            </div>    
        </div>

    </div>

@endsection


@section('scripts')

@endsection