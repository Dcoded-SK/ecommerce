@extends("adminFolder.admin_master")

@section("content")

<div class="container">

    <a href="/add-book">
        <div class="btn btn-primary m-2">+ Book</div>
    </a>
    <div class="col-8 card shadow border p-3 my-4">
        <h3 class="text-center">Books</h3>
        <table class="table table-light table-hover table-striped">
            <thead>
                <tr>
                    <th class="text-center">SN.</th>
                    <th class="text-center">Picture</th>
                    <th class="text-center">Title</th>
                    <th class="text-center">Author</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                <tr onclick="showBook({{ $book->id }})">
                    <td>{{ $books->firstItem() + $loop->index }}</td>
                    <td class="text-center">
                        <img class="img" src="{{ asset('books_picture/' . $book->picture) }}" alt="Book Picture">
                    </td>
                    <td class="text-center">{{ $book->title }}</td>
                    <td class="text-center">{{ $book->author }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
            {{ $books->links() }}
        </div>

    </div>
</div>

@endsection
