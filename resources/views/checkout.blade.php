<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}"> 
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <title>Checkout</title>
</head>

<body>
    @include('header')
    <div class="add-stock-container">
        <div id='add-stock-content'>
                <h1><font face='Impact'>Checkout</font></h1>
                
                <!-- Display items removed from shopping cart due to insufficient stock -->
                @if($insufficientStock)
                    <div class="alert alert-success">
                        <p>The following items were removed from your shopping cart due to insufficient stock:</p>
                        @foreach($insufficientStock as $bookName => $qtyChanged) 
                            <p>{{ $bookName }}: {{ $qtyChanged }}</p>
                        @endforeach
                    </div>
                @endif
                <table cellspacing="10">
                    <tr>
                        <td>
                            <div>
                                <br><a href ="shoppingCart"><button div id = 'returnButton' onclick="return confirm('Are you sure you want to return to shopping cart?')">Return to Shopping Cart</button></a></div>
                            </div>
                        </td>
                    </tr>
                </table>
                <br>
                
                <table class = "shopping-cart-table">
                    <tr>
                        <th>Book</th>
                        <th>Book Name</th>
                        <th>Price By Unit</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    @if(!$shoppingCart->isEmpty())
                    @foreach($shoppingCart as $shoppingCarts) 
                    <?php
                    $price = Session::get('priceItem');
                    $itemCount = Session::get('numItem');
                    ?>
                    <tr id = "{{ $shoppingCarts->ISBN13}}Row">
                    <td><img src="{{ asset('book_covers')}}/{{$shoppingCarts->coverImg }}" width="150px" height="200px"></td>
                        <td>{{ $shoppingCarts -> bookName }}</td>
                        <!-- Price per unit of the book -->
                        <td>{{ $shoppingCarts -> retailPrice }}</td>
                        <td>
                        <!--Current quantity-->
                        <p id ="{{ $shoppingCarts->ISBN13}}Qty">{{ $shoppingCarts -> qty }}</p>
                        </td>
                        <!-- Total price of the book -->
                        <td id = "{{ $shoppingCarts->ISBN13}}Price"><p>RM{{ $shoppingCarts -> retailPrice * $shoppingCarts -> qty }}</p></td>
                    </tr>
                    @endforeach
                    <!-- Retrieve item quantity and total price-->
                    <?php
                    $price = Session::get('priceItem');
                    $itemCount = Session::get('numItem');
                    $postage_base = Session::get('postageBase');
                    $postage_increment = Session::get('postageIncrement');
                    $shippingPrice = $price + $postage_base + ($postage_increment * $itemCount);
                    $shippingFee = $postage_base + ($postage_increment * $itemCount);
                    ?>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Total:</th>
                        <th><p id = "totalQty"><?php echo $itemCount ?></p> items</th>
                        <th><p id = "totalPrice">RM<?php echo $price ?></p></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Shipping Fees:</th>
                        <th><p id = "shippingPrice">RM<?php echo $shippingFee ?></p></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Total Price with Shipping Fees:</th>
                        <th><p id = "shippingPrice">RM<?php echo $shippingPrice ?></p></th>
                    </tr>
                </table>
                @endif
                <table cellspacing="10">
                    <tr>
                        <td>
                            <br><a href="{{ route('payment')}}"><button class="btn btn-block btn-primary" onclick="return confirm('Continue to payment?')" type="submit"><b>Pay Now</b></button></a>
                        </td>
                    </tr>
                </table>
        </div>
        @include('footer')
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js">
    </script>
    <!--
        <script>
        function removeEntry(ISBN13){
            fetch('shoppingCart/remove-entry', {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $('meta[name="csrf_token"]').attr('content')
            },
            body: JSON.stringify({bookISBN: ISBN13}),
            method: 'post',
            credentials: "same-origin",})
        .then(function (response) {
            return response.json();
        })
        .then(function (response) {
            var cartQty = document.getElementById('cartQty');
            var cartPrice = document.getElementById('cartPrice');
            var totalQty = document.getElementById('totalQty');
            var totalPrice = document.getElementById('totalPrice');
            var shippingPrice = document.getElementById('shippingPrice');
            var row = document.getElementById(ISBN13+'Row');
            
            console.log(response);
            cartQty.innerHTML = response.qty;
            cartPrice.innerHTML = "RM" + response.price;
            totalQty.innerHTML = response.qty;
            totalPrice.innerHTML = "RM" + response.price;
            //calculate shipping price
            shippingPrice.innerHTML = "RM" + (response.price + 
            row.remove();

            
        })
        .catch(function(error){
            console.log(error)
        });    
    }
    </script>
    -->
</body>
</html>