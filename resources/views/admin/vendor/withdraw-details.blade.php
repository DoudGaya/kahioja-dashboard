@extends('layouts.load')
@section('content')

                        <div class="content-area no-padding">
                            <div class="add-product-content1">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="product-description">
                                            <div class="body-area">

                                    <div class="table-responsive show-table">
                                        <table class="table">
                                            <tr>
                                                <th>{{ __("Vendor ID#") }}</th>
                                                <td>{{$withdraw->user->id}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Vendor Name") }}</th>
                                                <td>
                                                    <a href="{{route('admin-user-show',$withdraw->user->id)}}" target="_blank">{{$withdraw->user->name}}</a>
                                                </td>
                                            </tr>
                                            @if($withdraw->status == 'pending')
                                            <tr>
                                                <th>{{ __("Current Balance") }}</th>
                                                <td>{{$sign->sign}}{{ ($withdraw->user->current_balance + $withdraw->amount) }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th>{{ __("Withdraw Amount") }}</th>
                                                <!--<td>{{$sign->sign}}{{ round($withdraw->amount * $sign->value , 2) }}</td>-->
                                                <td>{{$sign->sign}}{{ ($withdraw->amount - $withdraw->fee) }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Withdraw Charge") }}</th>
                                                <td>{{$sign->sign}}{{ $withdraw->fee }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Withdraw Process Date") }}</th>
                                                <td>{{date('d-M-Y',strtotime($withdraw->created_at))}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Withdraw Status") }}</th>
                                                <td>{{ucfirst($withdraw->status)}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Vendor Email") }}</th>
                                                <td>{{$withdraw->user->email}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Vendor Phone") }}</th>
                                                <td>{{$withdraw->user->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Withdraw Method") }}</th>
                                                <td>{{$withdraw->method}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Tracking Order") }}</th>
                                                <td>{{$withdraw->order_no}}</td>
                                            </tr>
                                            @if($withdraw->method != "Bank")
                                            <!-- <tr>
                                                <th>{{$withdraw->method}} {{ __("Email") }}:</th>
                                                <td>{{$withdraw->acc_email}}</td>
                                            </tr> -->
                                            @else 
                                            <!-- <tr>
                                                <th>{{$withdraw->method}} {{ __("Account") }}:</th>
                                                <td>{{$withdraw->iban}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Account Name") }}:</th>
                                                <td>{{$withdraw->acc_name}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Country") }}</th>
                                                <td>{{ucfirst(strtolower($withdraw->country))}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Address") }}</th>
                                                <td>{{$withdraw->address}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{$withdraw->method}} {{__("Swift Code")}}:</th>
                                                <td>{{$withdraw->swift}}</td>
                                            </tr> -->
                                            @endif
                                        </table>
                                    </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

@endsection