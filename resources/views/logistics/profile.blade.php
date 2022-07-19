@extends('layouts.logistics')
@section('content')

						<div class="content-area">
							<div class="mr-breadcrumb">
								<div class="row">
									<div class="col-lg-12">
											<h4 class="heading">{{ __('Edit Profile') }}</h4>
											<ul class="links">
												<li>
													<a href="{{ route('logistics.dashboard') }}">{{ __('Dashboard') }} </a>
												</li>
												<li>
													<a href="{{ route('logistics.profile') }}">{{ __('Edit Profile') }} </a>
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
											<form id="geniusform" action="{{ route('logistics.profile.update') }}" method="POST" enctype="multipart/form-data">
												{{csrf_field()}}

                        @include('includes.admin.form-both')  

						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                                <h4 class="heading">{{ __('Current Company Icon') }} *</h4>
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <div class="img-upload">
						                                <div id="image-preview" class="img-preview" style="background: url({{ $data->photo ? asset('assets/images/logistics/'.$data->photo):asset('assets/images/noimage.png') }});">
						                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __('Upload Image') }}</label>
						                                    <input type="file" name="photo" class="img-upload" id="image-upload">
						                                  </div>
						                            </div>
						                          </div>
						                        </div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Company') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="company" placeholder="{{ __('Company') }}" required="" value="{{$data->company}}">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Email') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="email" class="input-field" name="email" placeholder="{{ __('Email Address') }}" required="" value="{{$data->email}}">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Phone') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="phone" placeholder="{{ __('Phone Number') }}" required="" value="{{$data->phone}}">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Address') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="address" placeholder="{{ __('Address') }}" required="" value="{{$data->address}}">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Bank Name *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="bank_name" placeholder="Bank Name" required="" value="{{$data->bank_name}}">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">Account No *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="account_no" placeholder="Account Number" required="" value="{{$data->account_no}}">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">Account Name *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="account_name" placeholder="Account Name" required="" value="{{ $data->account_name }}">
													</div>
												</div>

						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                              
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <button class="addProductSubmit-btn" type="submit">{{ __('Update Profile') }}</button>
						                          </div>
						                        </div>

											</form>


											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

@endsection