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


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Shop Detail</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Shop Detail</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Single Product Start -->
        <div class="container-fluid py-5 mt-5">
            <div class="container py-5">
                <div class="row g-4 mb-5">
                    <div class="col-lg-8 col-xl-9">
                        @if(sizeOf($product)>0)
                            @foreach($product as $key)
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="border rounded">
                                            <a href="#">
                                                <img src="{{ (!empty($key->feature_image)) ? url('storage/images/'.$key->feature_image) : url('storage/images/no-attachment.png') }}" class="img-fluid rounded"  alt="Image">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="fw-bold mb-3">{{$key->product}}</h4>
                                        <p class="mb-3">Category: {{$key->category}}</p>
                                        <h5 class="fw-bold mb-3">{{$key->price}} $</h5>
                                        <div class="d-flex mb-4">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <p class="mb-4">{{$key->description}}</p>
                                        
                                        <form action="{{ route('addtToCart') }}" method="POST">
                                            @csrf
                                            <label class="form-label my-3 fw-bold">Quantity</label>

                                            <div class="input-group quantity mb-5" style="width: 100px;">
                                                <input type="number" autofocus name="quantity" class="form-control text-center" min="1" max="{{ $key->stock }}"
                                                    value="{{ session('cart.0.product_id') === $key->product_id ? session('cart.0.quantity') : '1' }}">

                                                <input type="hidden" name="product_id" value="{{ $key->product_id }}">
                                            </div>
                                            <button type="submit" name="addtocart" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                            </button>
                                        </form>
                                        </div>
                                    <div class="col-lg-12">
                                        <nav>
                                            <div class="nav nav-tabs mb-3">
                                                <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                                    id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                                    aria-controls="nav-about" aria-selected="true">Description</button>
                                                <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                                    id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                                    aria-controls="nav-mission" aria-selected="false">Reviews</button>
                                            </div>
                                        </nav>
                                        <div class="tab-content mb-5">
                                            <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                                <p>The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic words etc. 
                                                    Susp endisse ultricies nisi vel quam suscipit </p>
                                                <p>Sabertooth peacock flounder; chain pickerel hatchetfish, pencilfish snailfish filefish Antarctic 
                                                    icefish goldeye aholehole trumpetfish pilot fish airbreathing catfish, electric ray sweeper.</p>
                                            </div>
                                            <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                                <div class="d-flex">
                                                    <img src="img/avatar.jpg" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;" alt="">
                                                    <div class="">
                                                        <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                                        <div class="d-flex justify-content-between">
                                                            <h5>Jason Smith</h5>
                                                            <div class="d-flex mb-3">
                                                                <i class="fa fa-star text-secondary"></i>
                                                                <i class="fa fa-star text-secondary"></i>
                                                                <i class="fa fa-star text-secondary"></i>
                                                                <i class="fa fa-star text-secondary"></i>
                                                                <i class="fa fa-star"></i>
                                                            </div>
                                                        </div>
                                                        <p>The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic 
                                                            words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <img src="img/avatar.jpg" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;" alt="">
                                                    <div class="">
                                                        <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                                        <div class="d-flex justify-content-between">
                                                            <h5>Sam Peters</h5>
                                                            <div class="d-flex mb-3">
                                                                <i class="fa fa-star text-secondary"></i>
                                                                <i class="fa fa-star text-secondary"></i>
                                                                <i class="fa fa-star text-secondary"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                            </div>
                                                        </div>
                                                        <p class="text-dark">The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic 
                                                            words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="nav-vision" role="tabpanel">
                                                <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor sit. Aliqu diam
                                                    amet diam et eos labore. 3</p>
                                                <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos labore.
                                                    Clita erat ipsum et lorem et sit</p>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="#">
                                        <h4 class="mb-5 fw-bold">Leave a Reply</h4>
                                        <div class="row g-4">
                                            <div class="col-lg-6">
                                                <div class="border-bottom rounded">
                                                    <input type="text" class="form-control border-0 me-4" placeholder="Yur Name *">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="border-bottom rounded">
                                                    <input type="email" class="form-control border-0" placeholder="Your Email *">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="border-bottom rounded my-4">
                                                    <textarea name="" id="" class="form-control border-0" cols="30" rows="8" placeholder="Your Review *" spellcheck="false"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-between py-3 mb-5">
                                                    <div class="d-flex align-items-center">
                                                        <p class="mb-0 me-3">Please rate:</p>
                                                        <div class="d-flex align-items-center" style="font-size: 12px;">
                                                            <i class="fa fa-star text-muted"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="btn border border-secondary text-primary rounded-pill px-4 py-3"> Post Comment</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <div class="row g-4 fruite">
                            <div class="col-lg-12">
                                <div class="input-group w-100 mx-auto d-flex mb-4">
                                    <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                                </div>
                                <div class="mb-4">
                                    <h4>Categories</h4>
                                    <ul class="list-unstyled fruite-categorie">
                                        @if(sizeOf($categories)>0)
                                            @foreach($categories as $key)
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="#"><i class="fa fa-arrow-circle-right me-2" aria-hidden="true"></i>{{$key->category}}</a>
                                                        <span>({{$key->product_count}})</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="fw-bold mb-0">Related products</h1>
                <div class="vesitable">
                    <div class="owl-carousel vegetable-carousel justify-content-center">
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="img/vegetable-item-6.jpg" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Parsely</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$4.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="img/vegetable-item-1.jpg" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Parsely</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$4.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="img/vegetable-item-3.png" class="img-fluid w-100 rounded-top bg-light" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Banana</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="img/vegetable-item-4.jpg" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Bell Papper</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="img/vegetable-item-5.jpg" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Potatoes</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="img/vegetable-item-6.jpg" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Parsely</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="img/vegetable-item-5.jpg" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Potatoes</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="img/vegetable-item-6.jpg" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4>Parsely</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">$7.99 / kg</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Product End -->
    
        @include('layouts/footer')