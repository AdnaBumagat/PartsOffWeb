@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                <li class="breadcrumb-item">Checkout</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-9 pt-4">
    <div class="container">
        <form id="orderForm" name="orderForm" action="" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="first_name" id="first_name"
                                         class="form-control" placeholder="First Name" value="{{(!empty($customerAddress)) ? $customerAddress->first_name : ''}}">
                                         <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="last_name" id="last_name"
                                         class="form-control" placeholder="Last Name" value="{{(!empty($customerAddress)) ? $customerAddress->last_name : ''}}">
                                         <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email"
                                         class="form-control" placeholder="Email" value="{{(!empty($customerAddress)) ? $customerAddress->email : ''}}">
                                         <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="province" id="province" class="form-control">
                                            <option value="">Select a Province</option>
                                            @if($provinces->isNotEmpty())
                                                @foreach ($provinces as $province)
                                                    <option {{(!empty($customerAddress) && $customerAddress->province_id == $province->id) ? 'selected' : ''}} value="{{$province->id}}">{{$province->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3"
                                         placeholder="Address" class="form-control">{{(!empty($customerAddress)) ? $customerAddress->address : ''}}</textarea>
                                    </div>
                                    <p></p>
                                </div>


                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" class="form-control"
                                         placeholder="City" value="{{(!empty($customerAddress)) ? $customerAddress->city : ''}}">
                                         <p></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="barangay" id="barangay"
                                         class="form-control" placeholder="Barangay" value="{{(!empty($customerAddress)) ? $customerAddress->barangay : ''}}">
                                         <p></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="zip" id="zip"
                                         class="form-control" placeholder="Zip" value="{{(!empty($customerAddress)) ? $customerAddress->zip : ''}}">
                                         <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile"
                                         class="form-control" placeholder="Mobile No." value="{{(!empty($customerAddress)) ? $customerAddress->mobile : ''}}">
                                         <p></p>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summary</h3>
                    </div>
                    <div class="card cart-summery">
                        <div class="card-body">

                            @foreach (Cart::content() as $item)
                            <div class="d-flex justify-content-between pb-2">
                                <div class="h6">{{$item->name}} X {{$item->qty}}</div>
                                <div class="h6">₱{{$item->price*$item->qty}}</div>
                            </div>
                            @endforeach

                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>₱{{Cart::subtotal()}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong>₱{{$shipping}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong>₱{{Cart::subtotal()}}</strong></div>
                            </div>
                                <div class="h5"><strong>₱{{$grandTotal}}</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="card payment-form ">

                        <h3 class="card-title h5 mb-3">Payment Method</h3>
                        <div class="form-check" style="display: none;">
                            <input checked type="radio" name="payment_method" value="cod" id="payment_method_one">
                            <label for="payment_method_one" class="form-check-label">Cash on Delivery<label>
                        </div>
                        <div>Cash on Delivery</div>

                        <div class="pt-4">
                            {{-- <a href="#" class="btn-dark btn btn-block w-100">Pay Now</a> --}}
                            <div style="text-align: center"> Prepare your payment upon on delivery</div>
                            <button type="submit" class="btn-dark btn btn-block w-100">Place your Order</button>
                        </div>
                    </div>
                    <!-- CREDIT CARD FORM ENDS HERE -->
                </div>
            </div>
        </form>
    </div>
</section>
<script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
<script>
    $("#payment_method_one").click(function(){
        if($(this).is(":checked") == true){
            $("#card-payment-form").addClass('d-none');
        }
    })
    // $("payment_method_two").click(function(){
    //     if($(this).is(":checked") == true){
    //         $("#card-payment-form").removeClass('d-none');
    //     }
    // })

    $("#orderForm").submit(function(event){
        event.preventDefault();

        $('button[type="submit"]').prop('disabled',true);

        $.ajax({
            url:'{{route("front.processCheckout")}}',
            type:'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                var errors =response.errors;
                $('button[type="submit"]').prop('disabled',false);

                if(response.status ==false){
                    //First Name
                    if(errors.first_name){
                        $("#first_name").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.first_name);
                    }else{
                        $("#first_name").removeClass('is-invalid')
                            .siblings("p")
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                    //Last Name
                    if(errors.last_name){
                        $("#last_name").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.last_name);
                    }else{
                        $("#last_name").removeClass('is-invalid')
                            .siblings("p")
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                    //Email
                    if(errors.email){
                        $("#email").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.email);
                    }else{
                        $("#email").removeClass('is-invalid')
                            .siblings("p")
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                    //Province
                    if(errors.province){
                        $("#province").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.province);
                    }else{
                        $("#province").removeClass('is-invalid')
                            .siblings("p")
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                    //Address
                    if(errors.address){
                        $("#address").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.address);
                    }else{
                        $("#address").removeClass('is-invalid')
                            .siblings("p")
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                    //City
                    if(errors.city){
                        $("#city").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.city);
                    }else{
                        $("#city").removeClass('is-invalid')
                            .siblings("p")
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                    //Barangay
                    if(errors.barangay){
                        $("#barangay").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.barangay);
                    }else{
                        $("#barangay").removeClass('is-invalid')
                            .siblings("p")
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                    //Zip
                    if(errors.zip){
                        $("#zip").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.zip);
                    }else{
                        $("#zip").removeClass('is-invalid')
                            .siblings("p")
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                    //Mobile
                    if(errors.mobile){
                        $("#mobile").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.mobile);
                    }else{
                        $("#mobile").removeClass('is-invalid')
                            .siblings("p")
                            .removeClass('invalid-feedback')
                            .html('');
                    }

                }else{
                    window.location.href="{{url('/thanks/')}}/"+response.orderId;
                }


            }
        });

    });
</script>


@endsection
