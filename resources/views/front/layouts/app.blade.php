<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Parts OFF</title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />

    <meta property="og:locale" content="en_AU" />
    <meta property="og:type" content="website" />
    <meta property="fb:admins" content="" />
    <meta property="fb:app_id" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="" />
    <meta property="og:image:height" content="" />
    <meta property="og:image:alt" content="" />

    <meta name="twitter:title" content="" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:image:alt" content="" />
    <meta name="twitter:card" content="summary_large_image" />

    <!--CSS links-->
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick-theme.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.css') }}" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap"
        rel="stylesheet">

    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />

    <meta name="csrf-token" content="{{csrf_token()}}">
</head>

<body data-instant-intensity="mousedown">

    <div class="top-header" style="background-color:#6b21a8">
        <div class="container">
            <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
                <div class="col-lg-4 logo">
                    <a href="{{Route('front.home')}}" class="text-decoration-none">
                        <span class="h1 text-uppercase text-primary bg-dark px-2">Parts</span>
                        <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">OFF</span>
                    </a>
                </div>
                <div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">
                    
                    <a href="{{Route('account.login')}}" class="nav-link text-dark">My Account</a>
                    {{-- <form action="">
                        <div class="input-group">
                            <input type="text" placeholder="Search For Products" class="form-control"
                                aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>

    <header class="bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-xl" id="navbar">
                <a href="index.php" class="text-decoration-none mobile-logo">
                    <span class="h2 text-uppercase text-primary bg-dark">Parts</span>
                    <span class="h2 text-uppercase text-white px-2">OFF</span>
                </a>
                <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <!-- <span class="navbar-toggler-icon icon-menu"></span> -->
                    <i class="navbar-toggler-icon fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php" title="Products">Home</a>
        </li> -->

                        <!--HEADER CATEGORIES-->
                        @if (getCategories()->isNotEmpty())
                            @foreach (getCategories() as $category)
                                <li class="nav-item">
                                    <button class="btn btn-dark" aria-expanded="false">
                                        {{ $category->name }}
                                    </button>
                                </li>
                                <!-- old category block incase of sub category implementation -->
                                {{-- <li class="nav-item dropdown">
						<button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
							{{ $category->name }}
						</button>
						<ul class="dropdown-menu dropdown-menu-dark">
							<li><a class="dropdown-item nav-link" href="#">Mobile</a></li>
							<li><a class="dropdown-item nav-link" href="#">Tablets</a></li>
							<li><a class="dropdown-item nav-link" href="#">Laptops</a></li>
							<li><a class="dropdown-item nav-link" href="#">Speakers</a></li>
							<li><a class="dropdown-item nav-link" href="#">Watches</a></li>
						</ul>
					</li> --}}
                            @endforeach
                        @endif


                    </ul>
                </div>
                <div class="right-nav py-0">
                    <a href="{{route('front.cart')}}}" class="ml-3 d-flex pt-2">
                        <i class="fas fa-shopping-cart text-primary"></i>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="mt-5" style="background-color:#6b21a8">
        <div class="container pb-5 pt-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-card">
                        <h3><i class="fas fa-info-circle"></i> About Us</h3>
                        <p>Parts OFF is your go-to website to sell or buy<br>
                            second hand computer parts or accessories. We<br>
                            offer good service and quality products. We are<br>
                            sure you can find what you are looking for!<br>
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="footer-card">
                        <h3><i class="fas fa-phone-square"></i> Contact Us</h3>
                        <ul>
                            <li><i class="far fa-envelope"></i> PartsOff@business.com</li>
                            <li><i class="fas fa-phone"></i> 09156612352</li>
                            <li><i class="fas fa-map-marker-alt"></i> Arellano Street, Dagupan City</li>
                            <li>Pangasinan</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="footer-card">
                        <h3><i class="fas fa-link"></i> Follow Us Here</h3>
                        <ul>
                            <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                            <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-dark copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="copy-right text-center">
                            <a href="{{Route('admin.login')}}"><p>© Copyright 2024 Parts OFF. All Rights Reserved</p></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--js links-->
    <script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/instantpages.5.1.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/lazyload.17.6.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/slick.min.js') }}"></script>
	<script src="{{ asset('front-assets/js/custom.js') }}"></script>

    <script>
        window.onscroll = function() {
            myFunction()
        };

        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;

        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }

        $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
        function addToCart(id){
            $.ajax({
                url:'{{route("front.addToCart")}}',
                type:'post',
                data:{id:id},
                dataType:'json',
                success: function(response){
                    if(response.status ==true){
                        window.location.href="{{route('front.cart')}}";
                    }else{
                        alert(response.message);
                    }

                }

            });
        }
    </script>
</body>

</html>
