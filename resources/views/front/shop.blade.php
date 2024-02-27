@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item active">Shop</li>
            </ol>
        </div>
    </div>
    <link rel="stylesheet" href="{{asset('front-assets/css/ion.rangeSlider.min.css')}}">
</section>

<section class="section-6 pt-5">
    <div class="container">
        <div class="row">
            <!--Categories-->
            <div class="col-md-3 sidebar">
                <div class="sub-title">
                    <h2>Categories</h3>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="accordion accordion-flush" id="accordionExample">

                            @if ($categories -> isNotEmpty())

                            @foreach ($categories as $category)
                            <a href="{{route("front.shop",$category->slug)}}" class="nav-time nav-link">{{ $category->name }}</a>
                            @endforeach

                            @endif

                        </div>
                    </div>
                </div>

                <!--PRICE-->
                <div class="sub-title mt-5">
                    <h2>Price</h3>
                </div>

                <div class="card">
                    <div class="card-body">
                        <input type="text" class="js-range-slider" name="my_range" value="" />
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-end mb-4">
                            <div class="ml-2">
                                <select name="sort" id="sort" class="form-control">
                                    <option value="latest"{{($sort == 'latest') ? 'selected': ''}}>Latest</option>
                                    <option value="price_desc"{{($sort == 'price_desc') ? 'selected': ''}}>Price High</option>
                                    <option value="price_asc"{{($sort == 'price_asc') ? 'selected': ''}}>Price Low</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!--Display products-->
                    @if ($products->isNotEmpty())

                    @foreach ($products as $product)
                    @php
                        $productImage = $product->product_images->first();
                    @endphp
                    <div class="col-md-4">
                        <div class="card product-card">
                            <div class="product-image position-relative">

                                <a href="#" class="product-img">
                                @if (!empty($productImage->image))
                                    <img class="card-img-top" src="{{asset('uploads/product/small/'.$productImage->image)}}" />
                                </a>
                                @else
                                    <img class="card-img-top" src="{{asset('admin-assets/img/default-150x150.png')}}" />
                                @endif
                                </a>

                                <div class="product-action">
                                    @if ($product->track_qty == 'Yes')
                                        @if ($product->qty > 0 )
                                        <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$product->id}});">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>
                                        @else
                                        <a class="btn btn-dark" href="javascript:void(0);">
                                            Out of Stock
                                        </a>
                                        @endif
                                    @else
                                    <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$product->id}});">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>
                                    @endif
                                </div> 
                            </div>
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="{{route("front.product",$product->slug)}}">{{ $product->title }}</a>
                                <div class="price mt-2">

                                    <span class="h5"><strong>₱{{ $product->price }}</strong></span>

                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                    @endif

                    <div class="col-md-12 pt-5">
                        {{ $products->withQueryString()->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{asset('front-assets/js/ion.rangeSlider.min.js')}}"></script>
<script src="{{ asset('front-assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('front-assets/js/lazyload.17.6.0.min.js') }}"></script>
<script>
    rangeSlider = $(".js-range-slider").ionRangeSlider({
        type: "double",
        min: 0,
        max: 10000,
        from: {{$priceMin}},
        step: 10,
        to: {{$priceMax}},
        skin: "square",
        max_postfix:"+",
        prefix: "₱",
        onFinish: function(){
            apply_filters()
        }

    });

    var slider = $(".js-range-slider").data("ionRangeSlider");

    $('#sort').change(function(){
        apply_filters();
    });

    function apply_filters(){

        var url = '{{url()->current()}}?';

        //Price Range Filter
        url += '&price_min='+slider.result.from+'&price_max='+slider.result.to;

        //Sorting filter

        url += '&sort='+$("#sort").val()

        window.location.href = url;

        };


</script>
@endsection
