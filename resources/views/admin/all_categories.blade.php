@extends('admin/masterfile')

@section("nav_bar")
   
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
          <li class="breadcrumb-item active">Products</li>
          <li class="breadcrumb-item active">Categories</li>
        </ol>
    
@endsection

@section("main_content")
<section class="section dashboard">
      <div class="row">
    
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="card">
              <div class="card-body"><br>
              <button id="add_category" class="btn btn-warning"><b><i class="bi bi-plus"></i>Add Category</b></button><br>
                <h5 class="card-title">Categories</h5>
                <!-- Table with stripped rows -->
                <table class="table datatable">
                  @if(sizeOf($all_categories))
                  <thead>
                    <tr>
                      <th>Category</th>
                      <th>Created At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($all_categories as $key)
                      <tr>
                        <td>{{$key->category}}</td>
                        <td>{{ \Carbon\Carbon::parse($key->created_at)->format('Y-m-d') }}</td>
                        <td>
                        <select class="form-select text-success" aria-label="Default select example" onchange="window.location.href=this.value;">
                            <option value="/home">Click</option>
                            <option value="/home">View</option>
                            <option value="/home">Edit</option>
                            <option value="/home">Delete</option>
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