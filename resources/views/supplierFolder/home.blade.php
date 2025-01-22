@extends('supplierFolder.supplier_master')


@section('content')

<div class="row">
    <!-- Recent Orders Section -->
    <div class="col-6 card shadow border p-3" style="height:450px; overflow-y:auto;">
        <h3 class="text-center mx-3">Recent Orders</h3>
        <div class="row">
            <div class="col-2">
                <div class="btn btn-primary text-center my-2" id="confirmButton" style="display:none;" onclick="submitFormOrder('/supplier-confirm-order')">
                    Confirm
                </div>
            </div>
            <div class="col-2">
                <div class="btn btn-warning text-center my-2" id="cancelButton" style="display:none;" onclick="submitFormOrder('/supplier-cancel-order')">
                    Cancel
                </div>
            </div>
            {{-- <div class="col-2">
                <div class="btn btn-danger text-center my-2" id="removeButton" style="display:none;" onclick="submitFormOrder('/remove-order')">
                    Delete
                </div>
            </div> --}}
        </div>

        <form action="" method="post" id="editorder">
            @csrf
            <!-- Include CSRF token for form security -->
            <table class="table table-success table-hover table-striped" id="order_table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll" />
                        </th>
                        <th>Order_Id</th>
                        <th>Book_id</th>
                        <th>Quantity</th>
                        <th>User_id</th>
                        <th>Status</th>
                        <th>Ordered_at</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated by DataTables -->
                </tbody>
            </table>
        </form>
    </div>




    <!-- Featured Books Section -->
    <div class="col-6 card shadow border p-3" style="height: 450px; overflow-y: auto;">
        <h3 class="text-center">Books</h3>
        <table class="table table-light table-hover table-striped">
            <thead>

                <th class="text-center">SN.</th>
                <th class="text-center">Picture</th>
                <th class="text-center">Title</th>
                <th class="text-center">Author</th>
            </thead>
            <tbody>
                @foreach ($books as $book)

                <tr onclick="showBook({{ $book->id }})" style="cursor: pointer">

                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center"><img class="img" src="{{ asset('books_picture/' . $book->picture) }}" alt="Book Picture"></td>
                    <td class="text-center">{{ $book->title }}</td>
                    <td class="text-center">{{ $book->author }}</td>
                </tr>

                @endforeach
            </tbody>
        </table>
        <a href="/supplier-view-books" style="text-decoration: none">
            <div class="btn">All Books</div>
        </a>

    </div>
</div>


<div class=" row my-2">
    <div class="col-4 col-4 card shadow border p-3">
        <h3 class="text-center">
            Best Suppliers
        </h3>

        <table class="table table-warning table-hover table-striped">
            <thead>

                <th>SN.</th>
                <th>Picture</th>
                <th>Name</th>
                <th>Total supplied</th>
            </thead>

            <tbody>
                <td>1</td>
                <td>Sugar</td>
                <td>dfdsa</td>
                <td>3</td>
            </tbody>
            <tbody>
                <td>1</td>
                <td>Sugar</td>
                <td>dfdsa</td>
                <td>Sagar</td>
            </tbody>
            <tbody>
                <td>1</td>
                <td>Sugar</td>
                <td>dfdsa</td>
                <td>Sagar</td>
            </tbody>
            <tbody>
                <td>1</td>
                <td>Sugar</td>
                <td>dfdsa</td>
                <td>Sagar</td>
            </tbody>
        </table>

    </div>
    <div class="col-4 col-4 card shadow border p-3">
        <h3 class="text-center">Feedbacks</h3>
        <table class="table table-success table-hover table-striped">
            <thead>

                <th>SN.</th>
                <th>Gmail</th>
                <th>Subject</th>
                <th>Message</th>
            </thead>

            <tbody>
                <td>1</td>
                <td>sagar@gmailcom</td>
                <td>dfdsa</td>
                <td>Sagfdsf dfdar</td>
            </tbody>
            <tbody>
                <td>1</td>
                <td>Sugar</td>
                <td>dfdsa</td>
                <td>Sagar</td>
            </tbody>
            <tbody>
                <td>1</td>
                <td>Sugar</td>
                <td>dfdsa</td>
                <td>Sagar</td>
            </tbody>
            <tbody>
                <td>1</td>
                <td>Sugar</td>
                <td>dfdsa</td>
                <td>Sagar</td>
            </tbody>
        </table>
    </div>

</div>



@endsection
