@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                <li class="breadcrumb-item">{{$product->title}}</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-7 pt-3 mb-3">
    <div class="container">
        <div class="row ">
            <div class="col-md-5">
                <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner bg-light">

                        @if ($product->product_images)
                            @foreach($product->product_images as $key => $productImage)
                            <div class="carousel-item {{($key==0) ? 'active' : ''}}">
                                <img class="w-200 h-200" src="{{asset('uploads/product/large/'
                                .$productImage->image)}}" alt=Image>
                            </div>

                            @endforeach

                        @endif
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <div class="bg-light right">
                    <h1>{{$product->title}}</h1>
                    <h2 class="price ">₱{{$product->price}}</h2>
                    <h6 class="qty" style="mb-1">Stock Available:{{$product->qty}}</h6>
                    <br>
                    <div>{!!$product->product_detail!!}</div>
                    {{-- <a href="javascript:void(0)" onclick="addToCart({{$product->id}});" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a> --}}
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
        </div>
    </div>
</section>
<section class="section-7 pt-3 mb-3">
    <div class="container">
        <div class="col-md-12 mt-5">
            <div class="bg-light">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <p>{!!$product->description!!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
