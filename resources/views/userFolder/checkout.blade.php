@extends("userFolder.userMaster")

@section("user_content")

<div class="container bg-light card shadow my-2  w-50">

    <div class="row">
        <div class="col-md-4 align-center order-md-2 ">

            <ul class="list-group">

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


            </ul>

        </div>

        <div class="col-md-7 order-md-1">
            <h4 class="mb-3">Billing address</h4>
            <form action="/checkout" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user_add->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Contact No.</label>
                        <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="lastName" name="contact_number" value="{{ old('contact_number', $user_add->contact) }}" required>
                        @error('contact_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="username">Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="username" name="email" value="{{ old('email', $user_add->email) }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $user_add->address) }}" required>
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="country">Country</label>
                        <select class="custom-select d-block w-100 form-control @error('country') is-invalid @enderror" name="country" id="country" required>
                            <option value="">Choose Country...</option>
                            <option {{ old('country',$user_add->country) == 'India' ? 'selected' : '' }} value="India">India</option>
                            <option {{ old('country',$user_add->country) == 'Nepal' ? 'selected' : '' }} value="Nepal">Nepal</option>
                            <option {{ old('country',$user_add->country) == 'Srilanka' ? 'selected' : '' }} value="Srilanka">Srilanka</option>
                            <option {{ old('country',$user_add->country) == 'China' ? 'selected' : '' }} value="China">China</option>
                        </select>
                        @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="state">State</label>
                        <select class="custom-select d-block w-100 form-control @error('state') is-invalid @enderror" name="state" id="state" required>
                            <option value="">Choose State...</option>
                            <option {{ old('state',$user_add->state)== 'Gujrat' ? 'selected' : '' }} value="Gujrat">Gujrat</option>
                            <option {{ old('state',$user_add->state) == 'Up' ? 'selected' : '' }} value="Up">Up</option>
                            <option {{ old('state',$user_add->state) == 'Bihar' ? 'selected' : '' }} value="Bihar">Bihar</option>
                            <option {{ old('state',$user_add->state) == 'Noida' ? 'selected' : '' }} value="Noida">Noida</option>
                            <option {{ old('state',$user_add->state) == 'California' ? 'selected' : '' }} value="California">California</option>
                        </select>
                        @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zip">Pin Code</label>
                        <input type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" id="zip" value="{{ old('pin_code',$user_add->pin_code )}}" required>
                        @error('pin_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <hr>
                <h3>Payment:</h3>
                <div class="row">
                    <div class="col-6 d-flex">
                        <label for="payment">
                            <input type="checkbox" name="payment_method" value="cash" class="mx-2 rounded"> Cash on Delivery
                        </label>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>






        </div>
    </div>

</div>

@endsection
