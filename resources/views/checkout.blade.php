<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Checkout</title>
</head>

<body>
    @include('header')
    <div class="add-stock-container">
        <div id='add-stock-content'>
            <div id = 'add-stock-form'>
                <h1><font face='Impact'>Checkout</font></h1>
               
                @if($insufficientStock)
                    @foreach($insufficientStock as $insufficientStocks) 
                        <p>hi</p>
                    @endforeach
                @endif
               
                <table class = "shopping-cart-table">
                    <tr>
                        <th>Book</th>
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
                        <th>Total:</th>
                        <th><p id = "totalQty"><?php echo $itemCount ?></p> items</th>
                        <th><p id = "totalPrice">RM<?php echo $price ?></p></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Shipping Fees:</th>
                        <th><p id = "shippingPrice">RM<?php echo $shippingFee ?></p></th>
                    </tr>
                    <tr>
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
                            </div>
                                <br><a href ="shoppingCart"><button div id = 'returnButton'>Return to Shopping Cart</button></a></div>
                            </div>
                        </td>
                        
                        <td>
                            </div>
                                <br><button class="btn btn-block btn-primary" type="submit"><b>Pay Now</b></button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            @include('footer')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript">
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
            shippingPrice.innerHTML = "RM" + (response.price + <?php echo Session::get('postageBase'); ?> + (<?php echo Session::get('postageIncrement'); ?> * response.qty));
            
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