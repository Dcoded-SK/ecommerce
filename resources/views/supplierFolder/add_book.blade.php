@extends("supplierFolder.supplier_master")

@section("content")

<div class="container mt-5 p-5 card shadow">
    <h2 class="text-center">Add new Books</h2>

    <form action="/supplier-add-book" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-4">
                <label for="">Title</label><br>
                <label for="">
                    <input type="text" style="width:300px" name="title" class="form-control" value="{{ old('title') }}" style="width: 100%">
                </label>
                @error('title')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4">
                <label for="">Genre</label><br>
                <label for="">
                    <select name="genre" style="width:300px" class="form-control">
                        @foreach ($genre as $ge)
                        <option value="{{ $ge->id }}" {{ old('genre') == $ge->name ? 'selected' : '' }}>{{ $ge->name }}</option>
                        @endforeach
                    </select>
                </label>
                @error('genre')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-4">
                <label for="">Price</label><br>
                <label for="">
                    <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                </label>
                @error('price')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row my-3">
            <div class="col-6">
                <label for="">Author</label><br>
                <label for="">
                    <input type="text" style="width:400px" name="author" class="form-control" value="{{ old('author') }}">
                </label>
                @error('author')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <label for="">Picture</label><br>
                <label for="">
                    <input type="file" style="width:400px" name="picture" class="form-control">
                </label>
                @error('picture')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <input type="submit" value="Add" name="" id="">
        <a href="/supplier-home">
            <div class="btn btn-secondary">Cancel</div>
        </a>
    </form>


</div>

@endsection
