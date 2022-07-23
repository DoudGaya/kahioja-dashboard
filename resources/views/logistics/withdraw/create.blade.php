@extends('layouts.logistics')
@section('content')

                        <div class="content-area">
                            <div class="mr-breadcrumb">
                                <div class="row">
                                    <div class="col-lg-12">
                                            <h4 class="heading">Withdraw Now <a class="add-btn" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> Back</a></h4>
                                            <ul class="links">
                                                <li>
                                                    <a href="{{ route('logistics-wt-index') }}">Dashbord My Withdraws  </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">Withdraw</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;"> Now</a>
                                                </li>
                                            </ul>
                                    </div>
                                </div>
                            </div>


                            <div class="add-product-content1">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="product-description">
                                            <div class="body-area">

                                          <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>

                                                    @include('includes.admin.form-both') 
                         <form id="geniusform" class="form-horizontal" action="{{route('logistics-wt-store')}}" method="POST" enctype="multipart/form-data">

                                                    {{ csrf_field() }}


                                <div class="item form-group">
                                    <label class="control-label col-sm-12" for="name"><b>Current Balance : ₦{{ Auth::user()->current_balance }}</b></label>
                                </div>


                                <div class="item form-group">
                                    <label class="control-label col-sm-12" for="name">Withdraw Amount *

                                    </label>
                                    <div class="col-sm-12">
                                        <input name="amount" placeholder="Withdraw Amount" class="form-control"  type="text" value="{{ old('amount') }}" required>
                                    </div>
                                </div>

                                <!-- <div id="bank">

                                    <div class="item form-group">
                                        <label class="control-label col-sm-12" for="name">Account No *
                                        
                                        </label>
                                        <div class="col-sm-12">
                                            <input name="iban" value="{{ old('iban') }}" placeholder="Account No" class="form-control" type="text">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-sm-12" for="name">Account Name *

                                        </label>
                                        <div class="col-sm-12">
                                            <input name="acc_name" value="{{ old('accname') }}" placeholder="Account Name" class="form-control" type="text">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-sm-12" for="name">Bank Name *

                                        </label>
                                        <div class="col-sm-12">
                                            <input name="bank_name" value="{{ old('bank_name') }}" placeholder="Bank Name" class="form-control" type="text">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-sm-12" for="name">Enter Address

                                        </label>
                                        <div class="col-sm-12">
                                            <input name="address" value="{{ old('address') }}" placeholder="Enter Address" class="form-control" type="text">
                                        </div>
                                    </div>

                                </div> -->

                                <div class="item form-group">
                                    <label class="control-label col-sm-12" for="name">Additional Reference (Optional) 

                                    </label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="reference" rows="6" placeholder="Additional Reference (Optional)">{{ old('reference') }}</textarea>
                                    </div>
                                </div>

                                <div id="resp" class="col-md-12">

                                                                            <span class="help-block">
                                <strong>Withdraw Fee {{ $sign->sign }}{{ $gs->withdraw_fee }} and {{ $gs->withdraw_charge }}% will deduct from your account</strong>
                            </span>
                                                                    </div>

                                            <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="mybtn1">Withdraw</button>
                                            </div>
                                        </form>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

@endsection

@section('scripts')
<script type="text/javascript">

    $("#withmethod").change(function(){
        var method = $(this).val();
        if(method == "Bank"){

            $("#bank").show();
            $("#bank").find('input, select').attr('required',true);

            $("#paypal").hide();
            $("#paypal").find('input').attr('required',false);

        }
        if(method != "Bank"){
            $("#bank").hide();
            $("#bank").find('input, select').attr('required',false);

            $("#paypal").show();
            $("#paypal").find('input').attr('required',true);
        }
        if(method == ""){
            $("#bank").hide();
            $("#paypal").hide();
            $("#bank").find('input, select').attr('required',false);
             $("#paypal").find('input').attr('required',false);           
        }

    })

</script>
@endsection