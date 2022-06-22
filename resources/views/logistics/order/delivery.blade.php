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
                                                @foreach($cart as $product)
                                                    @php
                                                        $vendor_id = App\Models\Product::where('id', $product->product_id)->pluck('user_id')->first();
                                                    @endphp
                                                    @if($vendor_id == $data->user_id)
                                                        <tr>
                                                            <td>
                                                                @php
                                                                    $name = App\Models\Product::select('name')->where('id','=',$product->product_id)->pluck('name')->first();
                                                                @endphp
                                                                {{mb_strlen($name,'utf-8') > 30 ? mb_substr($name,0,30,'utf-8').'...' : $name}}
                                                            </td>
                                                            <td>
                                                                <p>
                                                                    <strong>{{ $langg->lang754 }} :</strong> {{$order->currency_sign}}{{$product->amount }}
                                                                </p>
                                                                <p>
                                                                    <strong>{{ $langg->lang311 }} :</strong> {{$product->quantity }}
                                                                </p>
                                                            </td>
                                                            <td>{{$order->currency_sign}}{{ ($product->quantity * $product->amount) }}</td>
                                                            <td>
                                                                @if($product->ship_fee != 0)
                                                                    {{$order->currency_sign}}{{ $product->ship_fee }}
                                                                @else
                                                                    Free Delivery
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
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