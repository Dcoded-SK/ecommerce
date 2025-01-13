<!DOCTYPE html>
<html lang="en">

<head>
    <title>BookSaw - Free Book Store HTML CSS Template</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{asset('css/normalize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('icomoon/icomoon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/vendor.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">


</head>


<script>
    // to register new user
    function addNewUser() {
        // Clear previous error messages
        $('.text-danger').remove();

        const form = new FormData(document.getElementById("registeration_form"));

        $.ajax({
            url: "/new-user"
            , method: "POST"
            , data: form
            , processData: false
            , contentType: false
            , success: function(response) {
                alert(response.message); // Should display "Registration successful"
                $('#registerationModal').modal('hide');
                document.getElementById("registeration_form").reset();
            }
            , error: function(xhr) {
                console.error(xhr); // Log the error response for further debugging
                if (xhr.status === 422) { // Validation error
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(field => {
                        const errorMessage = errors[field][0];
                        $(`[name="${field}"]`).after(`<div class="text-danger">${errorMessage}</div>`);
                    });
                } else {
                    alert('Something went wrong. Please try again later.');
                }
            }
        });

    }

    // to login

    function loginKaro() {
        const form = new FormData(document.getElementById("login_form"));
        $('.text-danger').remove(); // Clear previous error messages

        $.ajax({
            url: "/login"
            , method: "POST"
            , processData: false
            , contentType: false
            , data: form
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // CSRF token
            }
            , success: function(response) {
                alert(response.message);
                window.location.href = response.redirect; // Redirect user
            }
            , error: function(xhr) {
                console.error(xhr); // Log the error for debugging
                if (xhr.status === 422) { // Validation error
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(field => {
                        const errorMessage = errors[field][0];
                        $(`[name="${field}"]`).after(`<div class="text-danger">${errorMessage}</div>`);
                    });
                } else {
                    alert('Something went wrong. Please try again later.');
                }
            }
        });
    }

</script>



@if (session('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif








@if (session('error'))
<div class="alert alert-danger">
    {{session('error')}}
</div>
@endif









<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">




    <!-- Login  Modal  Form -->
    <div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Login Here</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="login_form">
                        @csrf

                        <div class="row">

                            <div class="col-6">
                                <label for="">Email:</label>
                                <label for=""><input type="text" name="u_email" placeholder="Enter you email" class="form-control"></label>
                                <div class="text-danger" id="u_email"></div>

                            </div>
                            <div class="col-6">
                                <label for="">Password:</label>
                                <label for=""><input type="password" name="u_password" class="form-control" placeholder="Enter your password"></label>
                                <div class="text-danger" id="u_password"></div>

                            </div>

                        </div>

                    </form>
                    <div class="btn btn-primary" onclick="loginKaro()">Login</div>

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-4">
                            <p class="fw-bold text-primary" style="cursor: pointer;">Forgot password?</p>
                        </div>
                        <div class="col-8">
                            <p>
                                Don't have an account?
                                <span data-bs-toggle="modal" data-bs-target="#registerationModal" class="fw-bold text-primary" style="cursor: pointer;">
                                    Register here
                                </span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Registeration  Modal  Form -->
    <div class="modal fade" id="registerationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">New Regsiteraton</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body my-1">
                    <form id="registeration_form">
                        @csrf

                        <div class="row">
                            <div class="col-6">
                                <label for="">Full Name:</label>
                                <input type="text" name="full_name" class="form-control" value="{{old('full_name')}}">
                                <div class="text-danger" id="error_full_name"></div>
                            </div>
                            <div class="col-6">
                                <label for="">Email:</label>
                                <input type="text" name="email" class="form-control" value="{{old('email')}}">
                                <div class="text-danger" id="error_email"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <label for="">Role:</label>
                                <select name="role" class="form-control">
                                    <option value="user" {{old('role') === 'user' ? 'selected' : ''}}>User</option>
                                    <option value="admin" {{old('role') === 'admin' ? 'selected' : ''}}>Admin</option>
                                    <option value="supplier" {{old('role') === 'supplier' ? 'selected' : ''}}>Supplier
                                    </option>
                                </select>
                                <div class="text-danger" id="error_role"></div>
                            </div>
                            <div class="col-8">
                                <label for="">Create password:</label>
                                <input type="password" name="password" class="form-control">
                                <div class="text-danger" id="error_password"></div>
                            </div>
                        </div>
                    </form>

                    <hr>
                    <div class="row">
                        <div class="col-5">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>


                            <button type="button" class="btn btn-primary btn-sm" onclick="addNewUser()">Submit</button>

                        </div>
                        <div class="col-5">
                            <p>Back to Login: <span class="fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#loginModal" style="cursor: pointer;">Login</span> </p>
                        </div>
                    </div>

                </div>





            </div>
        </div>
    </div>



    <div id="header-wrap">

        <div class="top-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="social-links">
                            <ul>
                                <li>
                                    <a href="#"><i class="icon icon-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="icon icon-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="icon icon-youtube-play"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="icon icon-behance-square"></i></a>
                                </li>
                            </ul>
                        </div>
                        <!--social-links-->
                    </div>
                    <div class="col-md-6">
                        <div class="right-element">

                            @if (Auth::check())
                            <a href="/user-profile" class="user-account for-buy"><i class="icon icon-user"></i><span>
                                    <!-- Button trigger modal -->
                                    Account
                                </span>
                            </a>

                            <a href="cart" class="cart for-buy"><i class="icon icon-clipboard"></i><span>Cart:(0
                                    $)</span></a>
                            @else
                            <a href="" class="user-account for-buy" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="icon icon-user"></i><span>
                                    <!-- Button trigger modal -->
                                    Account
                                </span>
                            </a>

                            <a href="#" class="cart for-buy"><i class="icon icon-clipboard"></i><span>Cart:(0
                                    $)</span></a>
                            @endif

                            <div class="action-menu">

                                <div class="search-bar">
                                    <a href="#" class="search-button search-toggle" data-selector="#header-wrap">
                                        <i class="icon icon-search"></i>
                                    </a>
                                    <form role="search" method="get" class="search-box">
                                        <input class="search-field text search-input" placeholder="Search" type="search">
                                    </form>
                                </div>
                            </div>

                        </div>
                        <!--top-right-->
                    </div>

                </div>
            </div>
        </div>
        <!--top-content-->

        <header id="header">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-2">
                        <div class="main-logo">
                            <a href="index.html"><img src="images/main-logo.png" alt="logo"></a>
                        </div>

                    </div>

                    <div class="col-md-10">

                        <nav id="navbar">
                            <div class="main-menu stellarnav">
                                <ul class="menu-list">
                                    <li class="menu-item active"><a href="/">Home</a></li>

                                    <li class="menu-item"><a href="#featured-books" class="nav-link">Featured</a></li>
                                    <li class="menu-item"><a href="#popular-books" class="nav-link">Popular</a></li>
                                    <li class="menu-item"><a href="#special-offer" class="nav-link">Offer</a></li>
                                    <li class="menu-item"><a href="#latest-blog" class="nav-link">Articles</a></li>
                                    <li class="menu-item"><a href="#download-app" class="nav-link">Download App</a></li>
                                </ul>

                                <div class="hamburger">
                                    <span class="bar"></span>
                                    <span class="bar"></span>
                                    <span class="bar"></span>
                                </div>

                            </div>
                        </nav>

                    </div>

                </div>
            </div>
        </header>

    </div>


    @yield("user_content")



    <script src="{{asset('js/jquery-1.11.0.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="{{asset('js/plugins.js')}}"></script>
    <script src="{{asset('js/script.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


</body>

</html>
