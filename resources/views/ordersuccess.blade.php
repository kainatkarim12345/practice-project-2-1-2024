@include('layouts/header')

        <!-- Banner Section Start-->
        <div class="container-fluid banner bg-secondary" style="margin-top:10%">
            <div class="container py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="py-4">
                            <h1 class="display-3 text-white">
                                @if(session('orderstatus'))
                                    {{ session('orderstatus') }}
                                @endif
                            </h1>
                            <p class="fw-normal display-3 text-dark mb-4">in Our Store</p>
                            <p class="mb-4 text-dark">The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic words etc.</p>
                            <a href="/" class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">BUY</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative">
                            <img src="img/baner-2.png" class="img-fluid w-100 rounded" alt="">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner Section End -->

@include('layouts/footer')