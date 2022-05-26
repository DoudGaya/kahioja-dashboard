@extends('layouts.logistics') 

@section('content')  
                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __('Accept Delivery') }}</h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('logistics.dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('logistics-pick-up-for-packaging-index') }}">{{ __('Accept Delivery') }}</a>
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
                                            <strong>You don't have any pick up for packaging!</strong><a href="{{ route('logistics-ready-for-packaging-index') }}"> Click to Pick Up </a>
                                            <strong>Or </strong><a href="{{ route('logistics-completed-packaging-index') }}"> Click here to view all your packaging deliveries.</a>
                                        @else
                                        <div class="table-responsiv">
                                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Order Number') }}</th>
                                                            <th>{{ __('Shop Name') }}</th>
                                                            <th>{{ __('Shop Address') }}</th>
                                                            <th>{{ __('Time Picked') }}</th>
                                                        </tr>
                                                    </thead>


                                                <tbody>
                                                    
                                                    @foreach($datas as $data)
                                                
                                                        <tr>
                                                            <td>{{$data->order_number}}</a></td>
                                                            <td>{{$data->shop_name}}</td>
                                                            <td>{{$data->shop_address}}</td>
                                                            <td>{{\Carbon\Carbon::parse($data->time_pickup)->diffForHumans()}}</td>
                                                            <td>
                                                                @if($data->pickup_status == 1)
                                                                    <button type="submit" class="text-white btn btn-warning">
                                                                        On the way to the Vendor Shop
                                                                    </button>
                                                                @elseif($data->pickup_status == 2)
                                                                    <button type="submit" class="text-white btn btn-primary">
                                                                        On the way to the Fulfilment Center
                                                                    </button>
                                                                @elseif($data->pickup_status == 3)
                                                                    <button type="submit" class="text-white btn btn-success">
                                                                        Delivered to Fulfilment Center
                                                                    </button>
                                                                @endif
                                                            </td>
                                                            @if($data->pickup_status == 1)
                                                            <td>
                                                                <form action="{{ route('accept-packaging-order-cancel',$data->order_number) }}" method="POST" enctype="multipart/form-data">
                                                                {{csrf_field()}}        
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