@extends('layouts.vendor') 

@section('content') 

<input type="hidden" id="headerdata" value="{{ __('COMPLETED DELIVERY') }}">
 
                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __('Completed Delivery') }}</h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('vendor-dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('all-delivery') }}">{{ __('Completed Delivery') }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <div class="product-area">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mr-table allproduct">
                                        @include('includes.admin.form-success') 
                                        <div class="table-responsiv">
                                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Order Number') }}</th>
                                                            <th>{{ __('Customer Name') }}</th>
                                                            <th>{{ __('Customer Phone') }}</th>
                                                            <th>{{ __('Customer Address') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($datas as $data)
                                                            <tr>
                                                                <td>{{ $data->order_number }}</td>
                                                                <td>{{ $data->customer_name }}</td>
                                                                <td>{{ $data->customer_phone }}</td>
                                                                <td>{{ $data->customer_address }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


@endsection    

@section('scripts')

{{-- DATA TABLE --}}
<!-- 
    <script type="text/javascript">

        var table = $('#kkgeniustable').DataTable({
               ordering: false,
               processing: true,
               serverSide: true,
               ajax: '{{-- route('vendor-completed-delivery-datatables') --}}',
               columns: [
                        { data: 'order_number', name: 'order_number' },
                        { data: 'customer_name', name: 'customer_name' },
                        { data: 'customer_phone', name: 'customer_phone' },
                        { data: 'customer_address', name: 'customer_address' },
                     ],
               language : {
                    processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                },
                drawCallback : function( settings ) {
                        $('.select').niceSelect();  
                }
            });
                                                                
    </script> -->

{{-- DATA TABLE --}}
    
@endsection   