@extends('layouts.vendor') 

@section('content')  
                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __('Delivery Accepted') }}</h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('logistics.dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('logistics-pick-up-for-packaging-index') }}">{{ __('Delivery Accepted') }}</a>
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
                                            <strong>{{__('No data found!')}}
                                        @else
                                        <div class="table-responsive">
                                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Order Number') }}</th>
                                                            <th>{{ __('Company') }}</th>
                                                            <th>{{ __('Time Picked') }}</th>
                                                        </tr>
                                                    </thead>


                                                <tbody>
                                                    @foreach($datas as $data)
                                                
                                                        <tr>
                                                            <td>{{$data->order_number}}</a></td>
                                                            <td>{{$data->company}}</a></td>
                                                            <td>{{\Carbon\Carbon::parse($data->time_pickup_delivery)->diffForHumans()}}</td>
                                                            <td>
                                                                @if($data->delivery_status == 1)
                                                                    <button type="submit" class="text-white btn btn-warning">
                                                                        On the way to Your Shop
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
                                                                <form action="{{ route('accept-packaging-order-confirm',$data->order_number) }}" method="POST" enctype="multipart/form-data">
                                                                {{csrf_field()}}        
                                                                    <button type="submit" class="text-white btn btn-success">
                                                                        Confirm
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