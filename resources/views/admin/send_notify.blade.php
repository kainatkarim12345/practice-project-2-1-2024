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
                <div class="card-header">
                    {{ __('SEND NOTIFICATION FORM') }}
                </div>
                <div class="card-body card-header">
              <form action="{{url('/send_notify_process')}}" method="POST" enctype='multipart/form-data'>
                @csrf
                  <div class="row">
                      <div class="col-md-4 mb-3">
                      <label for="name">Name<span style="color:red">*</span></label><br>
                        @if ($errors->has('name'))
                          <span class="text-danger">
                            {{ $errors->get('name')[0] }}
                          </span>
                        @endif
                          <input type="text" class="form-control" value="{{ old('name') }}" id="name" name="name">
                      </div>
                      <div class="col-md-4 mb-3">
                      <label for="price">Price<span style="color:red">*</span></label><br>
                        @if ($errors->has('price'))
                          <div class="text-danger">
                            {{ $errors->get('price')[0] }}
                          </div>
                        @endif
                          
                          <input type="number" class="form-control" id="price" value="{{ old('price') }}" name="price">
                      </div>
                      <div class="col-md-4 mb-3">
                          <label for="stock">Stock<span style="color:red">*</span></label><br>
                          @if ($errors->has('stock'))
                          <div class="text-danger">
                            {{ $errors->get('stock')[0] }}
                          </div>
                        @endif
                          <input type="number" class="form-control" id="stock" value="{{ old('stock') }}" name="stock">
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                        <div class="mb-12">
                        <label for="description">Product Description<span style="color:red">*</span></label>
                          <br>
                        @if ($errors->has('description'))
                          <div class="text-danger">
                            {{ $errors->get('description')[0] }}
                          </div>
                        @endif
                        <textarea class="form-control" id="description" name="description"></textarea>
                      </div>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                        <label for="image">Product Image<span style="color:red">*</span></label>
                          <br>
                        @if ($errors->has('image'))
                          <div class="text-danger">
                            {{ $errors->get('image')[0] }}
                          </div>
                        @endif
                          <input type="file" class="form-control" id="image" name="image">
                      </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-4">
                        <label for="discount">Discount (%)</label>
                          <br>
                          <input type="number" class="form-control" id="discount" name="discount">
                      </div>
                    </div>
                    <div class="col-sm-3">
                    <label class="custom-control-label" for="terms">Status</label>
                      <div class="custom-control form-control custom-checkbox mb-3">
                        <input type="radio" class="custom-control-input" id="terms" value="active" checked name="status">&nbsp;Active
                        <input type="radio" class="custom-control-input" id="terms" value="inactive" name="status">&nbsp;Deactive
                      </div>
                    </div>
                  </div>
                  
                  <button class="btn btn-primary btn-block" type="submit">Add Product</button>
              </form>
                </div>
            </div>
      </div>
    </section>
@endsection
