<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
            <div class="col-2 side_header" style="border-right:3px white solid;min-height:94vh" aria-label="Sidebar">
                @include('adminFolder.side_header')
            </div>
            <!-- Main Content -->
            <div class="col-10 bg-light " aria-label="Main Content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-oCmvLJlxoaILjS+UcJgCl1HtL+NdhU2pFr4UkwHTGcDI9UNUZ/z+J1jtmFv6MA+c" crossorigin="anonymous"></script>

</body>
</html>
