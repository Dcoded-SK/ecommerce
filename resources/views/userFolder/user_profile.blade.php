@extends("userFolder.userMaster")

@section("user_content")

<div class="container mt-2">
    <div class="row gutters-sm">
        <div class="col-md-5 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                        <div class="mt-3">
                            <h4>{{ auth()->user()->name }}</h4>
                            <a href="/logout">
                                <div class="btn btn-secondary">Logout</div>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3 px-5">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                            </svg>Website</h6>
                        <span class="text-dark">https://bootdey.com</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline">
                                <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                            </svg>Github</h6>
                        <span class="text-dark">bootdey</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                            </svg>Twitter</h6>
                        <span class="text-dark">@bootdey</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>Instagram</h6>
                        <span class="text-dark">bootdey</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>Facebook</h6>
                        <span class="text-dark">bootdey</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card mb-3">
                <div class="card-body p-5">
                    <div class="row my-1">
                        <div class="col-sm-3">
                            <h4 class="mb-0">Full Name</h4>
                        </div>
                        <div class="col-sm-9 text-dark">
                            {{auth()->user()->name}}
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-sm-3">
                            <h4 class="mb-0">Email</h4>
                        </div>
                        <div class="col-sm-9 text-dark">
                            {{ auth()->user()->email }}
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-sm-3">
                            <h4 class="mb-0">Role</h4>
                        </div>
                        <div class="col-sm-9 text-dark">
                            {{ auth()->user()->role }}
                        </div>
                    </div>

                    <div class="row my-1">
                        <div class="col-sm-3">
                            <h4 class="mb-0">Permssion</h4>
                        </div>
                        <div class="col-sm-9 text-dark">
                            {{ Auth::user()->getAllPermissions()->pluck('name')->join(', ')}}
                        </div>
                    </div>

                </div>
            </div>

            <div class="row gutters-sm  ">
                <div class="">
                    <div class="card h-350">
                        <h3 class="text-center">Orders</h3>

                        <div class="card-body scroller-hidden-y" style="max-height: 400px; overflow-y: auto;">
                            @if ($orders->isNotEmpty())
                            @foreach ($orders as $order )

                            @foreach ($order->books as $book )
                            <div class="card shadow mb-2">
                                <div class="row p-3">
                                    <div class="col-4 align-center">
                                        <img src="{{ asset('books_picture/'.$book->picture) }}" style="width: 150px; height: 150px" alt="">
                                    </div>
                                    <div class="col-4 py-3">
                                        <h5>Title: {{ $book->title }}</h5>
                                        <h5>Author: {{ $book->author }}</h5>
                                        <h5>Genre: {{ $book->genre->name }}</h5>
                                        <h5>Quantity: {{ $order->quantity }}</h5>
                                        <h5>Total price: {{ $order->quantity* $book->price }}</h5>
                                    </div>
                                    <div class="col-4 py-3">
                                        <h5>Status: {{ $order->status=="pending"? 'On the way':( $order->status=="confirm"?'Confirm': 'Cancelled')}}</h5>
                                        <h5>Del. date: {{ $order->status=="delivered"? $oder->updated_at : 'Estimated date?'}}</h5>

                                        @if($order->status=="confirm")
                                        <a href="invoice-{{ $order->id }}">
                                            <div class="btn btn-primary">Download Invoice</div>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endforeach
                            @else
                            <h5 class="text-center mx-2">You have not shop yet! </h5>

                            <a href="/#popular-books">
                                <p class="text-center" style="font-style: bold;font-size:20px;color:rgb(110, 206, 110)">Shop Now</p>
                            </a>
                            @endif

                        </div>

                    </div>

                </div>
            </div>



        </div>
    </div>
</div>

@endsection
