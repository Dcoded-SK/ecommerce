@extends('adminFolder.admin_master')


@section('content')

<div class="row">
    <!-- Recent Orders Section -->
    <div class="col-6 card shadow border p-3">
        <h3 class="text-center">Recent Orders</h3>

        <table class="table table-success table-hover table-striped">
            <thead>

                <th>SN.</th>
                <th>Picture</th>
                <th>Name</th>
                <th>Supplier</th>
            </thead>

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
            <tbody>
                <td>1</td>
                <td>Sugar</td>
                <td>dfdsa</td>
                <td>Sagar</td>
            </tbody>
        </table>
    </div>

    <!-- Featured Books Section -->
    <div class="col-6 card shadow border p-3">
        <h3 class="text-center">Books</h3>
        <table class="table table-light table-hover table-striped">
            <thead>

                <th class="text-center">SN.</th>
                <th class="text-center">Picture</th>
                <th class="text-center">Title</th>
                <th class="text-center">Author</th>
            </thead>

            @foreach ($books as $book)

            <tr>

                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center"><img class="img" src="{{ asset('books_picture/' . $book->picture) }}" alt="Book Picture"></td>
                <td class="text-center">{{ $book->title }}</td>
                <td class="text-center">{{ $book->author }}</td>
            </tr>

            @endforeach

        </table>
        <a href="/view-books" style="text-decoration: none">
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
    <div class="col-4 col-4 card shadow border p-3">
        <h3 class="text-center">Roles</h3>
        <table class="table table-success table-hover table-striped table-responsive">
            <thead>
                <th>SN.</th>
                <th>Role</th>
                <th>Permissions</th>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr onclick="window.location.href='/assign-permissions-{{ $role->name}}'" style="cursor: pointer">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @if($role->permissions->isNotEmpty())
                        {{ $role->permissions->pluck('name')->join(', ') }}
                        @else
                        No permissions assigned
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>
</div>



@endsection
