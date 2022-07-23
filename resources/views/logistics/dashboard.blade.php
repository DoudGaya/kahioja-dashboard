@extends('layouts.logistics')

@section('content')
    <div class="content-area">

        @include('includes.form-success')
        <div class="row row-cards-one">

                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="mycard bg2">
                        <div class="left">
                            <h5 class="title">Available Balance</h5>
                            <span class="number">₦{{$data->current_balance}}</span>
                        </div>
                        <!--<div class="right d-flex align-self-center">-->
                        <!--    <div class="icon">-->
                        <!--       <i class="icofont-dollar-true"></i>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="mycard bg4">
                        <div class="left">
                            <h5 class="title">Current Balance</h5>
                            <span class="number">₦{{ App\Models\Withdraw::where('user_id','=',$logistics_id)->where('status','=','pending')->sum('amount') }}</span>
                        </div>
                        <!--<div class="right d-flex align-self-center">-->
                        <!--    <div class="icon">-->
                        <!--       <i class="icofont-dollar-true"></i>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="mycard bg6">
                        <div class="left">
                            <h5 class="title">Total Earnings!</h5>
                            <span class="number">{{App\Models\Product::vendorConvertPrice( App\Models\VendorOrder::where('logistics_id','=',$logistics_id)->where('status','=','delivered')->sum('ship_fee') )}}</span>
                        </div>
                        <!--<div class="right d-flex align-self-center">-->
                        <!--    <div class="icon">-->
                        <!--       <i class="icofont-dollar-true"></i>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                </div>
                
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="mycard bg3">
                        <div class="left">
                            <h5 class="title">Delivered to Customers</h5>
                            <span class="number">{{$delivery->count()}}</span>
                            <a href="{{route('logistics-completed-delivery-index')}}" class="link">View All</a>
                        </div>
                        <div class="right d-flex align-self-center">
                            <div class="icon">
                                <i class="icofont-truck-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--<div class="col-md-12 col-lg-6 col-xl-4">-->
                <!--    <div class="mycard bg6">-->
                <!--        <div class="left">-->
                <!--            <h5 class="title">Total Earnings!</h5>-->
                <!--            <span class="number">0.0</span>-->
                <!--        </div>-->
                <!--        <div class="right d-flex align-self-center">-->
                <!--            <div class="icon">-->
                <!--               <i class="icofont-dollar-true"></i>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->

            </div>
    </div>

@endsection