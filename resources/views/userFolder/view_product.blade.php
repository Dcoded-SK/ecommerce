@extends("userFolder.userMaster")

@section("user_content")



<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8 col-xl-6">
            <div class="card text-black p-3" style="width:300px;height:600px">
                <i class="fab fa-apple fa-lg  pb-1 px-3"></i>
                <img src="{{ asset('books_picture/'.$book->picture) }}" style="width: 80%" class="card-img-top align-center" alt="Apple Computer" />
                <div class="card-body">
                    <div class="text-center">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="text-muted mb-4">{{ $book->author }}</p>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between">
                            <span>Genre</span><span>{{ $book->genre->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Author</span><span>{{ $book->author }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Price</span><span>RS. {{ $book->price }}/book</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between total font-weight-bold mt-4">
                        {{-- <span>Total</span><span>$7,197.00</span> --}}
                        <a href="/cart">
                            <div class="btn btn-secondary">Back to Cart</div>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
