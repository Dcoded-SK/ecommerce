@extends("userFolder.userMaster")

@section("user_content")

<div class="container bg-light card shadow my-2 py-5 w-50">

    <div class="row">
        <div class="col-md-4 align-center order-md-2 ">

            <ul class="list-group  sticky-top  ">

                <h4 class="d-flex justify-content-between p-3  align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                </h4>

                <?php $total_price=0?>
                @foreach ($cart_items as $cart_item)
                <li class="list-group-item  justify-content-between p-3 lh-condensed">

                    <div class="row">
                        <div class="col-6">
                            <label for="title">Book: </label>
                            <label for="title">
                                <h5>{{ $cart_item->books->title }}</h5>
                            </label>
                        </div>

                        <div class="col-6">
                            <label for="title">Genre: </label>
                            <label for="title">
                                <h5>{{ $cart_item->books->genre->name }}</h5>
                            </label>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label for="title">Quantity: </label>
                            <label for="title">
                                <h5>{{ $cart_item->quantity }}</h5>
                            </label>
                        </div>

                        <div class="col-6">
                            <label for="title">Price: </label>
                            <label for="title">
                                <?php $total_price=$total_price+$cart_item->quantity*$cart_item->books->price?>
                                <h5>RS. {{ $cart_item->quantity*$cart_item->books->price }}</h5>
                            </label>
                        </div>

                    </div>

                </li>
                @endforeach


                <li class="list-group-item d-flex justify-content-between p-3">
                    <span>Total (INR)</span>
                    <strong>Rs. {{ $total_price }}</strong>
                </li>

                {{-- <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </div>
                </form> --}}
            </ul>

        </div>
        <div class="col-md-7 order-md-1">
            <h4 class="mb-3">Billing address</h4>
            <form class="needs-validation" id="" novalidate="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="" value="{{ Auth::user()->name }}" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Contact No.</label>
                        <input type="text" class="form-control" id="lastName" placeholder="" name="contact_number" value="{{ auth()->user()->contact_number }}" required="">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="username">Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input type="text" class="form-control" id="username" placeholder="" name="emmail" value="{{ auth()->user()->email }}" required="">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ auth()->user()->address }}" required="">
                    <div class="invalid-feedback"> Please enter your shipping address. </div>
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="country">Country</label>
                        <select class="custom-select d-block w-100" id="country" required="">
                            <option value="">Choose...</option>
                            <option>United States</option>
                        </select>
                        <div class="invalid-feedback"> Please select a valid country. </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="state">State</label>
                        <select class="custom-select d-block w-100" id="state" required="">
                            <option value="">Choose...</option>
                            <option>California</option>
                        </select>
                        <div class="invalid-feedback"> Please provide a valid state. </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zip">Zip</label>
                        <input type="text" class="form-control" id="zip" placeholder="" required="">
                        <div class="invalid-feedback"> Zip code required. </div>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="same-address"> Shipping address is the same as my billing address<span>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="save-info"> Save this information for next time
                </div>
                {{-- <hr class="mb-4">
                <h4 class="mb-3">Payment</h4>
                <div class="d-block my-3">
                    <div class="custom-control custom-radio d-flex">
                        <label for=""><input id="credit" name="paymentMethod" type="radio" class="custom-control-input mx-1" value="credit" checked="" required> </label>
                        <label class="custom-control-label" for="credit">Credit card</label>
                    </div>
                    <div class="custom-control custom-radio d-flex">
                        <label for=""><input id="debit" name="paymentMethod" type="radio" class="custom-control-input mx-1" value="debit" required> </label>
                        <label class="custom-control-label" for="debit">Debit card</label>
                    </div>
                    <div class="custom-control custom-radio d-flex">
                        <label for=""><input id="paypal" name="paymentMethod" type="radio" class="custom-control-input mx-1" value="paypal" required> </label>
                        <label class="custom-control-label" for="paypal">PayPal</label>
                    </div>
                </div>

                <!-- Credit Card Form -->
                <div id="credit-form" class="payment-form">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cc-name">Name on card</label>
                            <input type="text" class="form-control" id="cc-name" placeholder="" required>
                            <small class="text-muted">Full name as displayed on card</small>
                            <div class="invalid-feedback"> Name on card is required </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cc-number">Credit card number</label>
                            <input type="text" class="form-control" id="cc-number" placeholder="" required>
                            <div class="invalid-feedback"> Credit card number is required </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="cc-expiration">Expiration</label>
                            <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                            <div class="invalid-feedback"> Expiration date required </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cc-cvv">CVV</label>
                            <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                            <div class="invalid-feedback"> Security code required </div>
                        </div>
                    </div>
                </div>

                <!-- Debit Card Form -->
                <div id="debit-form" class="payment-form" style="display: none;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="debit-name">Name on card</label>
                            <input type="text" class="form-control" id="debit-name" placeholder="" required>
                            <div class="invalid-feedback"> Name on card is required </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="debit-number">Debit card number</label>
                            <input type="text" class="form-control" id="debit-number" placeholder="" required>
                            <div class="invalid-feedback"> Debit card number is required </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="debit-expiration">Expiration</label>
                            <input type="text" class="form-control" id="debit-expiration" placeholder="" required>
                            <div class="invalid-feedback"> Expiration date required </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="debit-cvv">CVV</label>
                            <input type="text" class="form-control" id="debit-cvv" placeholder="" required>
                            <div class="invalid-feedback"> Security code required </div>
                        </div>
                    </div>
                </div>

                <!-- PayPal Form -->
                <div id="paypal-form" class="payment-form" style="display: none;">
                    <div class="mb-3">
                        <label for="paypal-email">PayPal Email</label>
                        <input type="email" class="form-control" id="paypal-email" placeholder="email@example.com" required>
                        <div class="invalid-feedback"> PayPal email is required </div>
                    </div>
                </div> --}}

                <hr class="mb-1">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>


            {{-- <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const paymentMethodInputs = document.querySelectorAll('input[name="paymentMethod"]');
                    const creditForm = document.getElementById("credit-form");
                    const debitForm = document.getElementById("debit-form");
                    const paypalForm = document.getElementById("paypal-form");

                    paymentMethodInputs.forEach(input => {
                        input.addEventListener("change", function() {
                            // Hide all forms initially
                            creditForm.style.display = "none";
                            debitForm.style.display = "none";
                            paypalForm.style.display = "none";

                            // Show the selected form
                            if (this.value === "credit") creditForm.style.display = "block";
                            else if (this.value === "debit") debitForm.style.display = "block";
                            else if (this.value === "paypal") paypalForm.style.display = "block";
                        });
                    });
                });

            </script> --}}

        </div>
    </div>

</div>

@endsection
