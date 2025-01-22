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

        .img {
            width: 100px;
            height: 100px;
            border-radius: 20px;

        }

    </style>
</head>

<body>


    <div class="container-fluid">
        <div class="row header">
            @include('supplierFolder.header')
        </div>



        @if (session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
        @endif








        @if (session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
        @endif
        <div class="row bg-secondary">
            <!-- Sidebar -->
            <div class="col-2 side_header" style="border-right:3px white solid;min-height:93vh" aria-label="Sidebar">
                @include('supplierFolder.side_header')
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

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const confirmButton = document.getElementById('confirmButton');
            const cancelButton = document.getElementById('cancelButton');
            const editOrderForm = document.getElementById('editorder');

            const table = $('#order_table').DataTable({
                processing: true
                , serverSide: true
                , responsive: true
                , ajax: {
                    url: '{{ route("supplier-home") }}'
                    , type: 'GET'
                    , headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                        , 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    , }
                    , error: function(xhr, error, code) {
                        console.error('Error fetching data:', error);
                        Swal.fire('Error!', 'Failed to load data from server.', 'error');
                    }
                , }
                , columns: [{
                        data: null
                        , render: function(data, type, row) {
                            return `<input type="checkbox" name="order[]" value="${row.id}" class="order-checkbox" />`;
                        }
                    , }
                    , {
                        data: 'id'
                        , name: 'order_id'
                    }
                    , {
                        data: 'book_id'
                        , name: 'book_id'
                        , render: function(data) {
                            return `<a href="javascript:void(0)" style="text-decoration:none;color:black" onclick="showBook(${data})">${data}</a>`;
                        }
                    , }
                    , {
                        data: 'quantity'
                        , name: 'quantity'
                    }
                    , {
                        data: 'user_id'
                        , name: 'user_id'
                    }
                    , {
                        data: 'status'
                        , name: 'status'
                    }
                    , {
                        data: 'created_at'
                        , name: 'created_at'
                        , render: function(data) {
                            return moment(data).format('D-M-Y HH:mm');
                        }
                    , }
                , ]
                , lengthChange: true
                , searching: true
                , ordering: true
            , });

            function toggleButtons() {
                const anyChecked = $('input.order-checkbox:checked').length > 0;
                confirmButton.style.display = anyChecked ? 'inline-block' : 'none';
                cancelButton.style.display = anyChecked ? 'inline-block' : 'none';
            }

            function updateSelectAllCheckbox() {
                const allChecked =
                    $('input.order-checkbox:checked').length ===
                    $('input.order-checkbox').length;
                selectAllCheckbox.checked = allChecked;
            }

            selectAllCheckbox.addEventListener('change', function(e) {
                const isChecked = e.target.checked;
                $('input.order-checkbox').prop('checked', isChecked);
                toggleButtons();
            });

            $('#order_table').on('change', '.order-checkbox', function() {
                toggleButtons();
                updateSelectAllCheckbox();
            });

            // window.submitFormOrder = function(route) {
            //     editOrderForm.action = route;
            //     editOrderForm.submit();
            // };
        });





        //to  show a product on admin panel

        // This function will be triggered when a row is clicked
        function showBook(bookId) {
            // You can use AJAX to fetch book details by ID from the server
            $.ajax({
                url: '/get-book-details/' + bookId, // Make sure to set the correct route for fetching book details
                method: 'GET'
                , success: function(response) {
                    // Dynamically populate the modal with the book details
                    var book = response.book; // Assuming 'book' is the returned object
                    var modalContent = `
                <img  src="{{ asset('books_picture/') }}/${book.picture}" style="width:250px;height:250px" alt="Book Image" class="img-fluid" />

                <p class="px-3"><strong>Title:</strong> ${book.title}</p>
                <p class="px-3"><strong>Author:</strong> ${book.author}</p>
                <p class="px-3"><strong>Price:</strong> $${book.price}</p>
            `;
                    // Insert the content into the modal body
                    $('#bookDetailsContent').html(modalContent);

                    // Open the modal
                    $('#bookDetailsModal').modal('show');
                }
                , error: function(xhr, status, error) {
                    console.error("Error fetching book details:", error);
                }
            });
        }


        // Submit form to a specific route
        function submitFormOrder(route) {


            if (route !== "/supplier-confirm-order") {
                Swal.fire({
                    title: 'Reason!'
                    , input: 'text', // Input type (e.g., text, number, email, etc.)
                    inputPlaceholder: 'Give the reason to ' + route + ' these orders'
                    , showCancelButton: true
                    , confirmButtonText: 'Save'
                    , cancelButtonText: 'Cancel'
                    , preConfirm: (value) => {
                        if (!value) {
                            Swal.showValidationMessage('Input cannot be empty');
                        }
                        return value;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const userInput = result.value;
                        console.log('User input:', userInput);

                        // Fetch the form element
                        const orderForm = document.getElementById("editorder");

                        // Create FormData from the form
                        const formData = new FormData(orderForm);

                        formData.append("reason", userInput);
                        // Perform the AJAX request
                        $.ajax({
                            url: route, // URL for the request
                            data: formData, // Form data
                            method: "POST", // HTTP method
                            processData: false, // Prevents jQuery from processing the data
                            contentType: false, // Prevents jQuery from setting the content type
                            success: function(response) {
                                window.location.href = "/supplier-home";
                            }
                            , error: function(xhr, status, error) {
                                console.error('Error:', error);
                                Swal.fire('Error!', 'An error occurred while processing the order.', 'error');
                            }
                        });
                    }
                });
            } else {
                // Fetch the form element
                const orderForm = document.getElementById("editorder");

                // Create FormData from the form
                const formData = new FormData(orderForm);

                // Perform the AJAX request
                $.ajax({
                    url: route, // URL for the request
                    data: formData, // Form data
                    method: "POST", // HTTP method
                    processData: false, // Prevents jQuery from processing the data
                    contentType: false, // Prevents jQuery from setting the content type
                    success: function(response) {
                        window.location.href = "/supplier-home";
                    }
                    , error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while processing the order.', 'error');
                    }
                });
            }
        }

    </script>


    {{-- modal to show dynamic books --}}

    <!-- Modal Structure -->
    <div class="modal fade" id="bookDetailsModal" tabindex="-1" aria-labelledby="bookDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookDetailsModalLabel">Book Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="bookDetailsContent">
                        <!-- Dynamic book details will be injected here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
