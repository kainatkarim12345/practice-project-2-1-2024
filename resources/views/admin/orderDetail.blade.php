@extends('admin/masterfile')

@section("nav_bar")
   
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
          <li class="breadcrumb-item">Orders</li>
          <li class="breadcrumb-item active">Order Detail</li>
        </ol>
    
@endsection

@section("main_content")
<section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
        
          <!-- Default Card -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><b>Order Number </b>{{ $orderDetail[0]->order_number }}</h5>
                              @if($orderDetail[0]->order_status = 'recieved')
                                <span class="badge bg-primary">{{ $orderDetail[0]->order_status }}</span>
                              @elseif($orderDetail[0]->order_status = 'process')
                                <span class="badge bg-warning">{{ $orderDetail[0]->order_status }}</span>
                              @elseif($orderDetail[0]->order_status = 'cancelled')
                                <span class="badge bg-danger">{{ $orderDetail[0]->order_status }}</span>
                              @elseif($orderDetail[0]->order_status = 'completed')
                                <span class="badge bg-success">{{ $orderDetail[0]->order_status }}</span>
                              @endif
                      @php
                         $subtotal = 0; 
                      @endphp
                @if(sizeOf($orderDetail)>0)
                <br>
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Ordered Items:</h5>

                      <!-- Table with stripped rows -->
                      <table class="table table-secondary">
                        <thead>
                          <th></th>
                          <th>Name</th>
                          <th>Cost</th>
                          <th>Quantity</th>
                          <th>Total</th>
                        </thead>
                        
                          
                          <tbody>
                              @foreach($orderDetail as $key)
                              <tr>
                                <td style="width:15%"><img src="{{ (!empty($key->feature_image)) ? url('storage/images/'.$key->feature_image) : url('storage/images/no-attachment.png') }}"  class="img-fluid me-5 rounded-circle" style="width: 100px; height: 100px;"  alt=""></td>
                                <td>{{$key->product}}</td>
                                  @if($key->discount)
                                      @php
                                        $originalPrice = $key->price;
                                        $discountedPrice = $originalPrice - ($originalPrice * ($key->discount / 100));
                                        $afterDiscount = $discountedPrice;
                                      @endphp
                                  <td>
                                    <span style="text-decoration-line: line-through;">{{$key->price}} $</span>
                                    <span>{{$afterDiscount}} $</span>
                                  </td>
                                @else
                                    <td >{{$key->price}} $</td>
                                @endif
                                <td>{{$key->quantity}}</td>
                                  @if($key->discount)
                                      @php
                                        $originalPrice = $key->price;
                                        $discountedPrice = $originalPrice - ($originalPrice * ($key->discount / 100));
                                        $afterDiscount = $discountedPrice;
                                      @endphp
                                    <td>{{$afterDiscount * $key->quantity}} $</td> 
                                  @else
                                    <td>{{$key->price * $key->quantity}} $</td> 
                                  @endif
                              </tr>
                                  @php
                                      if($key->discount) {
                                          $subtotal += $afterDiscount * $key->quantity;
                                      } else {
                                          $subtotal += $key->price * $key->quantity;
                                      }
                                  @endphp
                              @endforeach

                              <tr>
                                <td colspan="3"></td>
                                <td><b>Shipping Free</b></td>
                                <td>{{ number_format(0, 2) }} $</td>
                              </tr>
                              <tr>
                                <td colspan="3"></td>
                                <td><b>SubTotal</b></td>
                                <td><b>{{ number_format($subtotal, 2) }} $</b></td>
                              </tr>
                              </tbody>
                      </table>
                      <!-- End Table with stripped rows -->
                            
                    </div>
                  </div>
                  <div class="row">
                <div class="col-sm-6">
                  <!-- Card with header and footer -->
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Customer Information</h5>
                        <table class="table table-bordered border-primary">
                            <tr>
                              <th scope="col">Name</th>
                              <td scope="col">{{$orderDetail[0]->name}}</td>
                            </tr>
                            <tr>
                              <th scope="col">Email</th>
                              <td scope="col">{{$orderDetail[0]->email}}</td>
                            </tr>
                            <tr>
                              <th scope="col">Contact</th>
                              <td scope="col">{{$orderDetail[0]->mobile_number}}</td>
                            </tr>
                            <tr>
                              <th scope="col">City</th>
                              <td scope="col">{{$orderDetail[0]->city}}</td>
                            </tr>
                            <tr>
                              <th scope="col">Country</th>
                              <td scope="col">{{$orderDetail[0]->country}}</td>
                            </tr>
                            <tr>
                              <th scope="col">Address</th>
                              <td scope="col">{{$orderDetail[0]->address}}</td>
                            </tr>
                        </table>
                    </div>
                  </div><!-- End Card with header and footer -->
                </div>
                <div class="col-sm-6">
                  <!-- Card with header and footer -->
                  <div class="card">
                    <div class="card-header">Order Status</div>
                    <div class="card-body">
                    <table class="table table-secondary">
                        <tbody>
                              <tr>
                                <th>Shipping Address</th>
                                <td>{{$orderDetail[0]->shipping_address}}</td>
                              </tr>
                              <tr>
                                <th>Billing Address</th>
                                <td>{{$orderDetail[0]->billing_address}}</td>
                              </tr>
                              <tr>
                                <th>Payment Method</th>
                                <td>{{$orderDetail[0]->method}}</td>
                              </tr>
                              <tr>
                                <th>Order Status</th>
                                <td>{{$orderDetail[0]->order_status}}</td>
                              </tr>
                              <form action="{{route('orderStatusChange')}}" method="POST">
                                @csrf
                                <tr>
                                  <td colspan="2" class="text-center">
                                        @if ($errors->has('order_status'))
                                        <span class="text-danger">
                                            {{ $errors->get('order_status')[0] }}
                                        </span>
                                        @endif
                                    <select class="form-select text-success text-center" name="order_status">
                                      @if($orderDetail[0]->order_status = 'recieved')
                                        <option value='process'>Process</option>
                                        <option value='completed'>Completed</option>
                                        <option value='cancelled'>Cancelled</option>
                                      @elseif($orderDetail[0]->order_status = 'process')
                                        <option value='recieved'>Recieved</option>
                                        <option value='completed'>Completed</option>
                                        <option value='cancelled'>Cancelled</option>
                                      @elseif($orderDetail[0]->order_status = 'cancelled')
                                        <option value='recieved'>Recieved</option>
                                        <option value='process'>Process</option>
                                        <option value='completed'>Completed</option>
                                      @elseif($orderDetail[0]->order_status = 'completed')
                                        <option value='recieved'>Recieved</option>
                                        <option value='process'>Process</option>
                                        <option value='cancelled'>Cancelled</option>
                                      @endif
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="text-center">
                                  <input type="hidden" name="order_id" value="{{$orderDetail[0]->order_id}}">
                                  <input type="hidden" name="cart_id" value="{{$orderDetail[0]->cart_id}}">
                                    <button type="submit" class="btn btn-success btn-lg">Change Order Status</button>
                                  </td>
                                </tr>
                              </form>
                        </tbody>
                      </table>
                    </div>
                  </div><!-- End Card with header and footer -->
                </div>
              </div>
                  @endif
                        
            </div>
          </div><!-- End Default Card -->

          

        </div>
      </div>
    </section>
@endsection
