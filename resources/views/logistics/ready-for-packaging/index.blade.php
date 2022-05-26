@extends('layouts.logistics') 

@section('content')  
                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __('Ready for Packaging') }}</h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('logistics.dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('logistics-ready-for-packaging-index') }}">{{ __('Ready for Packaging') }}</a>
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
                                            <strong>No data found</strong>
                                        @else
                                        
                                        <div class="table-responsiv">
                                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Order Number') }}</th>
                                                            <th>{{ __('Shop Name') }}</th>
                                                            <th>{{ __('Shop Address') }}</th>
                                                            <th>{{ __('Shop Phone') }}</th>
                                                            <th>{{ __('Details') }}</th>
                                                        </tr>
                                                    </thead>


                                                <tbody>
                                                    @foreach($datas as $data)
                                                
                                                        <tr>
                                                            <td>{{$data->order_number}}</a></td>
                                                            <td>{{$data->shop_name}}</td>
                                                            <td>{{$data->shop_address}}</td>
                                                            <td>{{$data->phone}}</td>
                                                            <td><a href="{{route('logistics-packaging-show',$data->order_number)}}" class="btn btn-primary product-btn"><i class="fa fa-eye"></i> {{ $langg->lang539 }}</a></td>
                                                            <td>
                                                                <form action="{{ route('accept-packaging-order-status',$data->order_number) }}" method="POST" enctype="multipart/form-data">
                                                                {{csrf_field()}}        
                                                                    <button type="submit" class="text-white btn btn-success">
                                                                        Click to Accept
                                                                    </button>
                                                                </form>
                                                            </td>

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