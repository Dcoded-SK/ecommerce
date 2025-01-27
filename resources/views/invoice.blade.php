<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{asset('css/normalize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('icomoon/icomoon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/vendor.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">

</head>
<body>

    <div class="container invoice">
        <div class="invoice-header">
            <div class="ui left aligned grid">
                <div class="row">
                    <div class="left floated left aligned six wide column">
                        <div class="ui">
                            <h1 class="ui header pageTitle">Invoice <small class="ui sub header">With Credit</small></h1>
                            <h4 class="ui sub header invDetails">NO: {{ $order_data->id }} | Date: {{ $order_data->created_at->format('d/M/y') }}</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="ui segment cards">

            <div class="ui card customercard">
                <div class="content">
                    <div class="header">Customer Details</div>
                </div>
                <div class="content">
                    <ul>
                        <li> <strong> Name: {{ $order_data->bill->name }}</strong> </li>
                        <li><strong> Address: </strong> {{ $order_data->bill->address }}</li>
                        <li><strong> Phone: </strong> (+91){{ $order_data->bill->contact }}</li>
                        <li><strong> Email: </strong> {{ $order_data->bill->email }}</li>
                    </ul>
                </div>
            </div>

            <div class="ui segment itemscard">
                <div class="content">
                    <table class="ui celled table">
                        <thead>
                            <tr>
                                <th>Item / Title</th>
                                <th class="text-center">Author</th>
                                <th class="text-center">Genre</th>
                                <th class="text-center colfix">Unit Cost</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center colfix">Total Cost</th>

                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td class="text-center">
                                    {{ $book->id }} / {{$book->title}}
                                </td>
                                <td class="text-center">{{ $book->author }}</td>
                                <td class="text-center">{{ $book->genre->name }}</td>
                                <td class="text-center">
                                    Rs. {{ $book->price }}

                                </td>
                                <td class="text-center">
                                    {{ $order_data->quantity }}
                                </td>
                                <td class="text-center">
                                    Rs. {{ $order_data->total_price }} only
                                </td>

                            </tr>


                        </tbody>

                    </table>

                </div>
            </div>


        </div>
    </div>

</body>
</html>
