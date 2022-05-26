@extends('layouts.logistics') 

@section('content')  
                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __('On Delivery') }}</h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('logistics.dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('logistics-on-delivery') }}">{{ __('On Delivery') }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <div class="product-area">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mr-table allproduct">
                                        @include('includes.form-success') 
                                        @if(count($datas) == 0)
                                            <strong>You don't have any pick up for Delivery!</strong><a href="{{ route('logistics-ready-for-delivery-index') }}"> Click to Pick Up a Delivery </a>
                                            <strong>Or </strong><a href="{{ route('logistics-completed-delivery-index') }}"> Click here to view all your deliveries.</a>
                                        @else
                                        <div class="table-responsiv">
                                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Order Number') }}</th>
                                                            <th>{{ __('Customer Name') }}</th>
                                                            <th>{{ __('Customer Phone') }}</th>
                                                            <th>{{ __('Customer Address') }}</th>
                                                            <th>{{ __('Time Picked') }}</th>
                                                        </tr>
                                                    </thead>


                                                <tbody>
                                                    
                                                    @foreach($datas as $data)
                                                
                                                        <tr>
                                                            <td>{{$data->order_number}}</a></td>
                                                            <td>{{$data->customer_name}}</td>
                                                            <td>{{$data->customer_phone}}</td>
                                                            <td>{{$data->customer_address}}</td>
                                                            <td>{{\Carbon\Carbon::parse($data->time_pickup_delivery)->diffForHumans()}}</td>
                                                            <td>
                                                                @if($data->delivery_status == 1)
                                                                    <button type="submit" class="text-white btn btn-warning">
                                                                        On the way to the Vendor Shop
                                                                    </button>
                                                                @elseif($data->delivery_status == 2)
                                                                    <button type="submit" class="text-white btn btn-primary">
                                                                        On Delivery
                                                                    </button>
                                                                @elseif($data->delivery_status == 3)
                                                                    <button type="submit" class="text-white btn btn-success">
                                                                        Delivered
                                                                    </button>
                                                                @endif
                                                            </td>
                                                            @if($data->delivery_status == 1)
                                                            <td>
                                                                <form action="{{ route('accept-delivery-order-cancel',$data->order_number) }}" method="POST" enctype="multipart/form-data">
                                                                {{csrf_field()}}
                                                                <input type="hidden" name="vendor_id" value="{{ $data->vendor_id }}">        
                                                                    <button type="submit" class="text-white btn btn-danger">
                                                                        Cancel Pick Up
                                                                    </button>
                                                                </form>
                                                            </td>
                                                            @endif

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                    
                                                </table>
                                        </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


@endsection    

@section('scripts')

@endsection   