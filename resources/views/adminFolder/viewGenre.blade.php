@extends("adminFolder.admin_master")

@section("content")

<div class="container w-50">
    <table id="genretable" class="table table-success table-hover table-striped">
        <thead>
            <tr>
                <th>SN</th>
                <th>Name</th>
                <th>Created_at</th>
            </tr>
        </thead>
    </table>





</div>
<div class="container w-50">
    <div class="row">

        <div class="col-6">
            <div class="btn btn-primary" onclick="newGenre()">Import</div>

        </div>

        <div class="col-6">
            <div class="btn btn-secondary" onclick="exportGenre()">Import</div>

        </div>
    </div>

    <form class="mt-4" id="genreform" style="display: none" action="/addgenre" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="genres" accept=".xlsx,.xls,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel" class="form-control">
        <br>
        <input type="submit" value="Upload" name="" id="">
    </form>

</div>
@endsection
