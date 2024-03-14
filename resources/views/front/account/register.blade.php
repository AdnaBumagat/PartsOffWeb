@extends('front.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item">Register</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">
                <form action="" method="post" name="registationForm" id="registrationForm">
                    @csrf
                    <h4 class="modal-title">Register Now</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" id="name" name="name" required>
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control" placeholder="Phone (11 digits)" id="phone" name="phone" pattern="[0-9]{11}" required>
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation" required>
                        <p></p>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                </form>
                <div class="text-center small">Already have an account? <a href="{{ route('account.login') }}">Login Now</a></div>
            </div>
        </div>
    </section>
    <script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript">
        $("#registrationForm").submit(function(event) {
            event.preventDefault();

            $("button[type='submit']").prop('disabled', true);

            var password = $("#password").val();
            var confirmPassword = $("#password_confirmation").val();

            // Check if password and confirm password match
            if (password !== confirmPassword) {
                $("#password_confirmation").siblings("p").addClass('invalid-feedback').html("The password field confirmation does not match.");
                $("#password_confirmation").addClass('is-invalid');
                $("button[type='submit']").prop('disabled', false);
                return; // Stop further execution
            }

            $.ajax({
                url: '{{ route('account.processRegister') }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type='submit']").prop('disabled', false);

                    var errors = response.errors;

                    if (response.status == false) {
                        // Handle other errors as before
                        if(errors.name) {
                            $("#name").siblings("p").addClass('invalid-feedback').html(errors.name);
                            $("#name").addClass('is-invalid');
                        } else{
                            $("#name").siblings("p").removeClass('invalid-feedback').html('');
                            $("#name").removeClass('is-invalid');
                        }

                        if(errors.email) {
                            $("#email").siblings("p").addClass('invalid-feedback').html(errors.email);
                            $("#email").addClass('is-invalid');
                        } else{
                            $("#email").siblings("p").removeClass('invalid-feedback').html('');
                            $("#email").removeClass('is-invalid');
                        }

                        if(errors.phone) {
                            $("#phone").siblings("p").addClass('invalid-feedback').html(errors.phone);
                            $("#phone").addClass('is-invalid');
                        } else{
                            $("#phone").siblings("p").removeClass('invalid-feedback').html('');
                            $("#phone").removeClass('is-invalid');
                        }

                        if(errors.password) {
                            $("#password").siblings("p").addClass('invalid-feedback').html(errors.password);
                            $("#password").addClass('is-invalid');
                        } else{
                            $("#password").siblings("p").removeClass('invalid-feedback').html('');
                            $("#password").removeClass('is-invalid');
                        }
                    } else {
                        // Redirect to login page if registration is successful
                        window.location.href = "{{ route('account.login') }}";
                    }
                },
                error: function(jQXHR, execption) {
                    console.log("Something went wrong");
                }
            });
        });
    </script>
@endsection

@section('customJS')
@endsection
