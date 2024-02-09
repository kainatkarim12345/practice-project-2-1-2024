@extends('admin/masterfile')

@section("nav_bar")
   
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
          <li class="breadcrumb-item active">Products</li>
        </ol>
    
@endsection

@section("main_content")
<section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Products</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                @if(sizeOf($products))
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Discount</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($products as $key)
                    <tr>
                      <td>{{$key->id}}</td>
                      <td style="width:15%"><img src="{{ (!empty($key->feature_image)) ? url('storage/images/'.$key->feature_image) : url('storage/images/no-attachment.png') }}" width="35%" alt=""></td>
                      <td>{{$key->product}}</td>
                      <td><a href="/">{{$key->category}}</a></td>
                      <td>{{$key->stock}}</td>
                        @if($key->discount)
                          <td class="text-center"><span class="badge bg-danger">- {{$key->discount}} OFF</span></td>
                        @else
                          <td class="text-center">--</td>
                        @endif
                        
                        @if($key->status == 'active')
                            <td class="text-center"><span class="badge bg-primary">{{$key->status}}</span></td>
                        @else
                            <td class="text-center"><span class="badge bg-warning">{{$key->status}}</span></td>
                        @endif
                      <td>{{ \Carbon\Carbon::parse($key->created_at)->format('Y-m-d') }}</td>
                      <td>
                      <select class="form-select bg-success text-light" aria-label="Default select example" onchange="window.location.href=this.value;">
                          <option value="/home">Click</option>
                          <option value="/home">View</option>
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