@extends('admin/masterfile')

@section("nav_bar")
   
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
          <li class="breadcrumb-item active">Orders</li>
        </ol>
    
@endsection

@section("main_content")
<section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Orders</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                @if(sizeOf($orders))
                <thead>
                  <tr>
                    <th>Order Number</th>
                    <th>Customer Name</th>
                    <th>City</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($orders as $key)
                    <tr>
                      <td>{{$key->order_number}}</td>
                      <td>{{$key->name}}</td>
                      <td>{{$key->city}}</td>
                      <td>{{$key->method}}</td>
                        @if($key->order_status == 'recieved')
                            <td class="text-center"><span class="badge bg-primary">{{$key->order_status}}</span></td>
                        @elseif($key->order_status == 'process')
                            <td class="text-center"><span class="badge bg-warning">{{$key->order_status}}</span></td>
                        @elseif($key->order_status == 'cancelled')
                            <td class="text-center"><span class="badge bg-danger">{{$key->order_status}}</span></td>
                        @elseif($key->order_status == 'completed')
                            <td class="text-center"><span class="badge bg-success">{{$key->order_status}}</span></td>
                        @endif
                      <td>
                        <select class="form-select bg-success text-light" aria-label="Default select example" onchange="window.location.href=this.value;">
                            <option value="/home">Click</option>
                            <option value="{{ route('orderDetail', ['id' => $key->cart_id]) }}">View</option>
                            <option value="/home">Edit</option>
                        </select>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                @endif
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
        </div><!-- End Left side columns -->


      </div>
    </section>
@endsection