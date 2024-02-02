@include('layouts/header')


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Checkout</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Checkout</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Checkout Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <h1 class="mb-4">Billing details</h1>
                <form action="{{route('add_order_process')}}" method="POST">
                    @csrf
                    <div class="row g-5">
                        <div class="col-md-12 col-lg-6 col-xl-7">
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-item w-100">
                                        
                                        <label class="form-label my-3">First Name<sup style="color:red">*</sup></label>
                                        @if ($errors->has('first_name'))
                                        <span class="text-danger">
                                            {{ $errors->get('first_name')[0] }}
                                        </span>
                                        @endif
                                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-item w-100">
                                        
                                        <label class="form-label my-3">Last Name<sup style="color:red">*</sup></label>
                                        @if ($errors->has('last_name'))
                                            <span class="text-danger">
                                                {{ $errors->get('last_name')[0] }}
                                            </span>
                                        @endif
                                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                    
                                <label class="form-label my-3">Billing Address <sup style="color:red">*</sup></label>
                                @if ($errors->has('billing_address'))
                                        <span class="text-danger">
                                            {{ $errors->get('billing_address')[0] }}
                                        </span>
                                        @endif
                                <textarea name="billing_address" value="{{ old('billing_address') }}"  class="form-control" placeholder="House Number Street Name"></textarea>
                            </div>
                            @if(sizeOf($cities)>0)
                            <div class="form-item">
                                   
                                <label class="form-label my-3">Town/City<sup style="color:red">*</sup></label>
                                @if ($errors->has('city_id'))
                                        <span class="text-danger">
                                            {{ $errors->get('city_id')[0] }}
                                        </span>
                                    @endif
                                <select name="city_id" class="form-select">
                                    <option value=''>Select City</option>
                                        @foreach($cities as $key)
                                            <option value="{{$key->id}}">{{$key->city}}</option>
                                        @endforeach
                                   
                                </select>
                            </div>
                            @endif
                            @if(sizeOf($countries)>0)
                            <div class="form-item">
                                    
                                <label class="form-label my-3">Country<sup style="color:red">*</sup></label>
                                    @if ($errors->has('country_id'))
                                        <span class="text-danger">
                                            {{ $errors->get('country_id')[0] }}
                                        </span>
                                        @endif
                                <select name="country_id" class="form-select">
                                        @foreach($countries as $key)
                                            <option value="{{$key->id}}">{{$key->country}}</option>
                                        @endforeach
                                   
                                </select>
                            </div>
                            @endif
                            <div class="form-item">
                                    
                                <label class="form-label my-3">Postcode/Zip<sup style="color:red">*</sup></label>
                                @if ($errors->has('zip_code'))
                                        <span class="text-danger">
                                            {{ $errors->get('zip_code')[0] }}
                                        </span>
                                    @endif
                                <input type="number" name="zip_code" value="{{ old('zip_code') }}" class="form-control">
                            </div>
                            <div class="form-item">
                                    
                                <label class="form-label my-3">Mobile<sup style="color:red">*</sup></label>
                                @if ($errors->has('mobile_number'))
                                        <span class="text-danger">
                                            {{ $errors->get('mobile_number')[0] }}
                                        </span>
                                    @endif
                                <input type="number" name="mobile_number" value="{{ old('mobile_number') }}" class="form-control">
                            </div>
                            <div class="form-item">
                                    
                                <label class="form-label my-3">Email Address<sup style="color:red">*</sup></label>
                                @if ($errors->has('email'))
                                        <small class="text-danger">
                                            {{ $errors->get('email')[0] }}
                                        </small>
                                    @endif
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                            </div>
                            <br>
                            <div class="form-item">
                                <textarea name="shipping_address" class="form-control" spellcheck="false" cols="3" rows="3" placeholder="Ship to a different address?"></textarea> 
                            </div>
                        </div>
                        @if (is_array($productData) || is_object($productData))
                            <div class="col-md-12 col-lg-6 col-xl-5">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Products</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                $subtotal = 0; 
                            @endphp
                                            @foreach($productData as $collection)
                                                @foreach($collection as $key)
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="d-flex align-items-center mt-2">
                                                                <img src="{{ (!empty($key->feature_image)) ? url('storage/images/'.$key->feature_image) : url('storage/images/no-attachment.png') }}" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                                            </div>
                                                        </th>
                                                        <td class="py-5">{{$key->product}}</td>
                                                        <td class="py-5">
                                                            @if($key->discount)
                                                                @php
                                                                    $originalPrice = $key->price;
                                                                    $discountedPrice = $originalPrice - ($originalPrice * ($key->discount / 100));
                                                                    $afterDiscount = $discountedPrice;
                                                                @endphp
                                                                <span style="text-decoration-line: line-through;">{{$key->price}} $</span><br>
                                                                <span>{{$afterDiscount}} $</span>
                                                            @else
                                                                {{$key->price}} $
                                                            @endif
                                                        </td>
                                                        <td class="py-5">{{$key->quantity}}</td>
                                                        <td class="py-5">
                                                        @if($key->discount)
                                                            @php
                                                                $originalPrice = $key->price;
                                                                $discountedPrice = $originalPrice - ($originalPrice * ($key->discount / 100));
                                                                $afterDiscount = $discountedPrice;
                                                            @endphp
                                                            {{$afterDiscount * $key->quantity}} $
                                                        @else
                                                            {{$key->price * $key->quantity}} $
                                                        @endif
                                                        </td>
                                                    </tr>
                                                        @php
                                                            if($key->discount) {
                                                                $subtotal += $afterDiscount * $key->quantity;
                                                            } else {
                                                                $subtotal += $key->price * $key->quantity;
                                                            }
                                                        @endphp
                                                @endforeach
                                            @endforeach
                                            <tr>
                                                <th scope="row">
                                                </th>
                                                <td class="py-5"></td>
                                                <td class="py-5"></td>
                                                <td class="py-5">
                                                    <p class="mb-0 text-dark py-3">Subtotal</p>
                                                </td>
                                                <td class="py-5">
                                                    <div class="py-3 border-bottom border-top">
                                                        <p class="mb-0 text-dark">${{ number_format($subtotal, 2) }}</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                    @if(sizeOf($methods)>0)
                                        @foreach($methods as $key)
                                            <div class="col-12">
                                                <div class="form-check text-start my-3">
                                                    <input type="radio" class="form-check-input bg-primary border-0" id="Delivery-1" name="method" value="{{$key->id}}">
                                                    <label class="form-check-label" for="Delivery-1">{{$key->method}}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                    <input type="hidden" value="{{ number_format($subtotal, 2) }}" name="total">
                                    <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place Order</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <!-- Checkout Page End -->

        @include('layouts/footer')