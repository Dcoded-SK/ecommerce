@extends("userFolder.userMaster")

@section("user_content")


<!-- Main content goes here-->

<style>
    .ui-w-40 {
        width: 80px !important;
        height: 100px;
    }

    .card {
        box-shadow: 0 1px 15px 1px rgba(52, 40, 104, .08);
    }

    .ui-product-color {
        display: inline-block;
        overflow: hidden;
        margin: .144em;
        width: .975rem;
        height: .875rem;
        border-radius: 10rem;
        -webkit-box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.15) inset;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.15) inset;
        vertical-align: middle;
    }

</style>
<div class="container px-3 my-5 clearfix">
    <!-- Shopping cart table -->
    <div class="card">
        <div class="card-header">
            <h2>Shopping Cart</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered m-0">
                    <thead>
                        <tr>
                            <!-- Set columns width -->
                            <th class="text-center py-3 px-4" style="min-width: 200px;">Product Name &amp; Details</th>
                            <th class="text-right py-3 px-4" style="width: 100px;">Price</th>
                            <th class="text-center py-3 px-4" style="width: 120px;">Quantity</th>
                            <th class="text-right py-3 px-4" style="width: 100px;">Total</th>
                            <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#" class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart"><i class="ino ion-md-trash"></i></a></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($cart as $cart_item)
                        <!-- Check if the book is in the user's cart -->



                        <tr>
                            <td class="p-4" onclick="window.location.href='/book{{ $cart_item->books->id }}'" style="cursor: pointer">
                                <div class="row">
                                    <div class="media align-items-center col-4">
                                        <img src="{{ asset('books_picture/'. $cart_item->books->picture) }}" class="d-block ui-w-40 ui-bordered mr-4" alt="">
                                        <div class="media-body">
                                            <a href="#" class="d-block text-dark">{{ $cart_item->books->title }}</a>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <h4>Title: <span style="font-size: 15px; color:green"> {{ $cart_item->books->title }}</span></h4>
                                        <h4>Author: <span style="font-size: 15px; color:green"> {{ $cart_item->books->author }}</span></h4>
                                        <h4>Genre: <span style="font-size: 15px; color:green"> {{ $cart_item->books->genre->name }}</span></h4>



                                    </div>
                                </div>

                            </td>

                            <td class="text-right font-weight-semibold align-middle p-4">${{ $cart_item->books->price }}</td> <!-- Assuming you have a price column -->
                            <td class="align-middle p-4">
                                <input type="text" class="form-control text-center" onchange="window.location.href='change-quantity-{{ $cart_item->id }}'" value="{{ $cart_item->quantity }}">
                            </td>
                            <td class="text-right font-weight-semibold align-middle p-4">${{ $cart_item->books->price * $cart_item->quantity }}</td> <!-- Total price -->
                            <td class="text-center align-middle px-0 ">
                                <h2 class="text-danger" onclick="deletCartItem({{ $cart_item->id }})" style="cursor: pointer">x</h2>
                            </td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <!-- / Shopping cart table -->

            <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                <div class="mt-4">
                    <label class="text-muted font-weight-normal">Promocode</label>
                    <input type="text" placeholder="ABC" class="form-control">
                </div>
                <div class="d-flex">
                    <div class="text-right mt-4 mr-5">
                        <label class="text-muted font-weight-normal m-0">Discount</label>
                        <div class="text-large"><strong>$20</strong></div>
                    </div>
                    <div class="text-right mt-4">
                        <label class="text-muted font-weight-normal m-0">Total price</label>
                        <div class="text-large"><strong>$1164.65</strong></div>
                    </div>
                </div>
            </div>

            <div class="float-right">
                <button type="button" class="btn btn-lg btn-default md-btn-flat mt-2 mr-3">Back to shopping</button>
                <button type="button" class="btn btn-lg btn-primary mt-2">Checkout</button>
            </div>

        </div>
    </div>
</div>

@endsection
