@include('layouts/header')
<style> 
input[type=text] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 3px solid #ccc;
  -webkit-transition: 0.5s;
  transition: 0.5s;
  outline: none;
}

input[type=text]:focus {
  border: 3px solid #555;
}
</style>

<script>
 
            @if(session('status'))
                const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
                });
                Toast.fire({
                icon: "success",
                title: "{{ session('status') }}"
                });
            
            @endif
        </script>

        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Cart</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Cart</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Cart Page Start -->
        @if (is_array($productData) || is_object($productData))
            <div class="container-fluid py-5">
                <div class="container py-5">
                    <div id="item_removed"></div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Products</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col"></th>
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
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ (!empty($key->feature_image)) ? url('storage/images/'.$key->feature_image) : url('storage/images/no-attachment.png') }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                                </div>
                                            </th>
                                    <td>
                                        <p class="mb-0 mt-4">{{$key->product}}</p>
                                    </td>
                                    <td>
                                        @if($key->discount)
                                            @php
                                                $originalPrice = $key->price;
                                                $discountedPrice = $originalPrice - ($originalPrice * ($key->discount / 100));
                                                $afterDiscount = $discountedPrice;
                                            @endphp
                                            <p class="mb-0 mt-4" style="text-decoration-line: line-through;">{{$key->price}} $</p>
                                            <p class="mb-0 mt-4">{{$afterDiscount}} $</p>
                                        @else
                                        <p class="mb-0 mt-4">{{$key->price}} $</p>
                                        @endif
                                    </td>
                                    <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <input 
                                            type="number" 
                                            max="{{$key->stock}}" 
                                            min="1" 
                                            autofocus 
                                            class="form-control text-center quantity-input" 
                                            value="{{$key->quantity}}"
                                            data-product-id="{{$key->product_id}}">
                                    </div>
                                    </td>
                                    <td>
                                    <p class="mb-0 mt-4 total" data-product-id="{{$key->product_id}}">
                                        @if($key->discount)
                                            @php
                                                $originalPrice = $key->price;
                                                $discountedPrice = $originalPrice - ($originalPrice * ($key->discount / 100));
                                                $afterDiscount = $discountedPrice;
                                            @endphp
                                            <span class="price_value" data-product-id="{{$key->product_id}}">{{$afterDiscount * $key->quantity}}</span> $
                                        @else
                                            <span class="price_value" data-product-id="{{$key->product_id}}">{{$key->price * $key->quantity}}</span> $
                                        @endif
                                    </p>
                                    </td>
                                    <td>
                                        <button onclick='cart_item_remove({{$key->product_id}})' class="btn btn-md rounded-circle bg-light border mt-4" >
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
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
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row g-4 justify-content-end">
                        <div class="col-8"></div>
                        <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                            <div class="bg-light rounded">
                                <div class="p-4">
                                    <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                        <h5 class="mb-0 ps-4 me-4">Subtotal</h5>
                                        <p class="mb-0 pe-4" id="subtotal">{{ number_format($subtotal, 2) }} $</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mb-0 me-4">Shipping</h5>
                                        <div class="">
                                            <p class="mb-0">Flat rate: $3.00</p>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-end">Shipping to Ukraine.</p>
                                </div>
                                <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                    <h5 class="mb-0 ps-4 me-4">Total</h5>
                                    <p class="mb-0 pe-4">${{ number_format($subtotal, 2) }}</p>
                                </div>
                                <a href="/checkout" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" >Proceed Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
                    <div class="row g-4 justify-content-center">
                        <div class="col-8"></div>
                        <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                            <div class="bg-light rounded">
                                <div class="p-4">
                                    <h1 class="display-6 mb-4 text-center">Empty Cart</h1>
                                </div>
                            </div>
                        </div>
                    </div>
        @endif
        <!-- Cart Page End -->

        <script type="text/javascript">
            function cart_item_remove(product_id) {
   
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    data: {product_id:product_id},
                    url: '/cart_item_remove',
                    success: function (data) {
                        if (data) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "success",
                                title: data.message
                            });

                            window.location.href = 'cart';

                        } else {
                            alert("Unexpected response from the server");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error:", textStatus, errorThrown);
                        console.log("Status Code:", jqXHR.status);
                        console.log(jqXHR.responseText);
                    }
                });
            }

            function updateSubtotal() {
                var subtotal = 0;

                $('.total').each(function () {
                    subtotal += parseFloat($(this).text().replace(' $', ''));
                });

                $('#subtotal').text(subtotal.toFixed(2) + ' $');
            }

            $('.quantity-input').on('input', function (e) {
                e.preventDefault();
                var product_id = $(this).data('product-id');

                updateTotal(product_id);
                updateSubtotal();
                
            });

            function updateTotal(product_id) {
                var quantityInput = $('input[data-product-id="'+product_id+'"]');
                var totalElement = $('.total[data-product-id="'+product_id+'"]');
                var priceElement = $('.price_value[data-product-id="'+product_id+'"]');

                if (quantityInput.length && totalElement.length && priceElement.length) {
                    var price = parseFloat(priceElement.text());
                    var quantity = parseInt(quantityInput.val());
                    var total = price * quantity;

                    $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: "/addtToCart",
                    data: {"product_id":product_id, "newQuantity":quantity, "_token": "{{ csrf_token() }}"},
                    
                    success: function(response){

                        console.log(response.message);
                        window.location.href = 'cart';

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error:", textStatus, errorThrown);
                        console.log("Status Code:", jqXHR.status);
                        console.log(jqXHR.responseText);
                    }
                    
                
                  });

                    totalElement.text(total.toFixed(2) + ' $');
                } else {
                    console.error('Error: Elements not found for product ID ' + product_id);
                }
            }
           
        </script>
        @include('layouts/footer')