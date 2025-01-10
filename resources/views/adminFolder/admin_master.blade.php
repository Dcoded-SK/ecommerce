<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables Implementation</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables Core CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

    <!-- DataTables Bootstrap CSS (Optional for Bootstrap Styling) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

    <style>
        .header {
            background-color: #efd9dc;
            margin-bottom: 1px;
        }

        .side_header {
            background-color: #d6bcc0;
        }

        .side_btn {
            background-color: #efd9dc;
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row header">
            @include('adminFolder.header')
        </div>
        <div class="row bg-secondary">
            <!-- Sidebar -->
            <div class="col-2 side_header" style="border-right:3px white solid;min-height:93vh" aria-label="Sidebar">
                @include('adminFolder.side_header')
            </div>
            <!-- Main Content -->
            <div class="col-10 bg-light" aria-label="Main Content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- jQuery (Always Load Before DataTables Scripts) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables Core JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Bootstrap JS (Optional for Bootstrap Styling) -->
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#customertable').DataTable({
                processing: true
                , serverSide: true
                , ajax: {
                    url: '{{route("view_customers")}}'
                    , type: 'GET'
                    , headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
                , columns: [{
                    data: 'name'
                    , name: 'name'
                }, {
                    data: 'email'
                    , name: 'email'
                }, {
                    data: 'role'
                    , name: 'role'
                }]
            });


            // to show suppliers


            $('#suppliertable').DataTable({
                processing: true
                , serverSide: true
                , ajax: {
                    url: '{{route("view_suppliers")}}'
                    , type: 'GET'
                    , headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
                , columns: [{
                    data: 'name'
                    , name: 'name'
                }, {
                    data: 'email'
                    , name: 'email'
                }, {
                    data: 'role'
                    , name: 'role'
                }]
            });


            // to show the admin list

            $('#admintable').DataTable({
                processing: true
                , serverSide: true
                , ajax: {
                    url: '{{route("view_admins")}}'
                    , type: 'GET'
                    , headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
                , columns: [{
                    data: 'name'
                    , name: 'name'
                }, {
                    data: 'email'
                    , name: 'email'
                }, {
                    data: 'role'
                    , name: 'role'
                }]
            });


            // to show all the genre of books
            $('#genretable').DataTable({
                processing: true
                , serverSide: true
                , responsive: true, // Makes the table responsive
                ajax: {
                    url: '{{ route("view_genre") }}'
                    , type: 'GET'
                    , headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    , }
                    , error: function(xhr, error, code) {
                        console.error('Error fetching data:', error);
                    }
                , }
                , columns: [{
                        data: 'id'
                        , name: 'id'
                    }
                    , {
                        data: 'name'
                        , name: 'name'
                    }
                    , {
                        data: 'created_at'
                        , name: 'created_at'
                        , render: function(data, type, row) {
                            return moment(data).format('YYYY-MM-DD HH:mm:ss'); // Format the date
                        }
                    }
                , ]
                , lengthChange: true, // Allows changing the number of rows displayed
                searching: true, // Enables the search bar
                ordering: true, // Enables column-based ordering
            });

        });

        function newGenre() {
            $('#genreform').show();
        }

        function exportGenre() {
            $.ajax({
                url: '/export-genre'
                , method: "get"
                , error: function(error) {
                    console.error(error);
                }
            });
        }

    </script>
</body>

</html>
