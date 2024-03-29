@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                <li class="breadcrumb-item">Settings</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">
        <div class="row">
            <div class="col-md-12">
                @include('front.account.common.message')
            </div>
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                    </div>
                    <form action="" method="post" name="profileForm" id="profileForm">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input value="{{$user->name}}" type="text" name="name" id="name" placeholder="Enter Your Name" class="form-control">
                                    <p class="invalid-feedback"></p>
                                </div>
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input value="{{$user->email}}" type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control">
                                    <p class="invalid-feedback"></p>
                                </div>
                                <div class="mb-3">
                                    <label for="phone">Phone</label>
                                    <input value="{{$user->phone}}" type="text" name="phone" id="phone" placeholder="Enter Your Phone" class="form-control">
                                    <p class="invalid-feedback"></p>
                                </div>

                                <div class="d-flex">
                                    <button class="btn btn-dark">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
<script>
$("#profileForm").submit(function(event){
    event.preventDefault();

    var name = $("#name").val().trim();
    var email = $("#email").val().trim();
    var phone = $("#phone").val().trim();
    var phoneRegex = /^\d{11}$/;

    // Name validation
    if (name === '') {
        $("#name").addClass('is-invalid')
            .siblings('p')
            .html('The name field is required')
            .addClass('invalid-feedback');
        return;
    } else {
        $("#name").removeClass('is-invalid')
            .siblings('p')
            .html('')
            .removeClass('invalid-feedback');
    }

    // Email validation
    if (email === '') {
        $("#email").addClass('is-invalid')
            .siblings('p')
            .html('The email field is required')
            .addClass('invalid-feedback');
        return;
    } else {
        $("#email").removeClass('is-invalid')
            .siblings('p')
            .html('')
            .removeClass('invalid-feedback');
    }

    // Phone validation
    if (phone === '') {
        $("#phone").addClass('is-invalid')
            .siblings('p')
            .html('The phone field is required')
            .addClass('invalid-feedback');
        return;
    } else if (!phoneRegex.test(phone)) {
        $("#phone").addClass('is-invalid')
            .siblings('p')
            .html('Phone number must have exactly 11 digits')
            .addClass('invalid-feedback');
        return;
    } else {
        $("#phone").removeClass('is-invalid')
            .siblings('p')
            .html('')
            .removeClass('invalid-feedback');
    }

    // AJAX request
    $.ajax({
        url: '{{route("account.updateProfile")}}',
        type: 'post',
        data: $(this).serializeArray(),
        dataType: 'json',
        success: function(response){
            if(response.status == true){
                // Code for successful update
                window.location.href ='{{route("account.profile")}}';
            } else {
                // Code for handling errors
                var errors = response.errors;
                if(errors.name){
                    $("#name").addClass('is-invalid')
                        .siblings('p')
                        .html(errors.name)
                        .addClass('invalid-feedback');
                } else {
                    $("#name").removeClass('is-invalid')
                        .siblings('p')
                        .html('')
                        .removeClass('invalid-feedback');
                }

                if(errors.email){
                    $("#email").addClass('is-invalid')
                        .siblings('p')
                        .html(errors.email)
                        .addClass('invalid-feedback');
                } else {
                    $("#email").removeClass('is-invalid')
                        .siblings('p')
                        .html('')
                        .removeClass('invalid-feedback');
                }

                if(errors.phone){
                    $("#phone").addClass('is-invalid')
                        .siblings('p')
                        .html(errors.phone)
                        .addClass('invalid-feedback');
                } else {
                    $("#phone").removeClass('is-invalid')
                        .siblings('p')
                        .html('')
                        .removeClass('invalid-feedback');
                }
            }
        }
    });
});
</script>
@endsection
