<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    @include('header')
    <div class="add-stock-container">
        <div id='add-stock-content'>
            <div id = 'add-stock-form'>
                <h1><font face='Impact'>Shopping Cart</font></h1>
                <table class = "shopping-cart-table">
                    <tr>
                        <th>Book</th>
                        <th>Price By Unit</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Remove</th>
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
                            <!--Add quantity-->
                            <a onclick="addQuantity({{ $shoppingCarts->ISBN13 }})"><img src="{{ asset('images/add_image.png') }}" width="20px" height="20px"></a>
                            <!--Current quantity-->
                            <p id ="{{ $shoppingCarts->ISBN13}}Qty">{{ $shoppingCarts -> qty }}</p>
                            <!--Minus quantity-->
                            <a onclick="minusQuantity({{ $shoppingCarts->ISBN13 }})"><img src="{{ asset('images/minus_image.png') }}"width="20px" height="20px"> </a>
                        </td>
                        <!-- Total price of the book -->
                        <td id = "{{ $shoppingCarts->ISBN13}}Price"><p>RM{{ $shoppingCarts -> retailPrice * $shoppingCarts -> qty }}</p></td>
                        <!-- Remove button -->
                        <td>
                            <a onclick="removeEntry({{ $shoppingCarts->ISBN13 }})"><img src="{{ asset('images/remove_button.jpg') }}"width="40px" height="40px"> </a> 
                        </td>
                    </tr>
                    @endforeach
                    <!-- Retrieve item quantity and total price-->
                    <?php
                    $price = Session::get('priceItem');
                    $itemCount = Session::get('numItem');
                    ?>
                    <tr>
                        <th></th>
                        <th>Total:</th>
                        <th><p id = "totalQty"><?php echo $itemCount ?></p> items</th>
                        <th><p id = "totalPrice">RM<?php echo $price ?></p></th>
                        <th></th>
                    </tr>

                </table>
                <!-- If no entries are found in the database, display this-->
                @else
                    <p>No items in the shopping cart</p>
                @endif
                        
            </div>
            <div class="shipping-address-container">
            <div id='shipping-address-content'>
            <div class = 'shipping-address-form'>
                <h1><font face='Impact'>Shipping Address</font></h1>
                <form action="{{route('update-address')}}" method="post" enctype="multipart/form-data">
                    <!-- Print error message that address was NOT updated -->
                    @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                    @endif
                    @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                    @endif
                    @csrf
                    <div class="form-group row">
                        <label for="Country" class="col-4 col-form-label">Country</label> 
                        <div class="col-8">
                            <input id="Country" name="Country" placeholder="Country" type="text" class="form-control" 
                            required="required" value="{{old('Country')}}"><br>
                            <span class="text-danger">@error('Country') {{$message}} @enderror</span>
                        </div>
                        <label for="State" class="col-4 col-form-label">State</label>
                        <div class="col-8">
                            <input id="State" name="State" placeholder="State" type="text" class="form-control" 
                            required="required" value="{{old('State')}}"><br>
                        </div>
                        <label for="District" class="col-4 col-form-label">District</label>
                        <div class="col-8">
                            <input id="District" name="District" placeholder="District" type="text" class="form-control" 
                            required="required" value="{{old('District')}}"><br>
                        </div>
                        <label for="Postal" class="col-4 col-form-label">Postal</label>
                        <div class="col-8">
                            <input id="Postal" name="Postal" placeholder="Postal Code" type="text" class="form-control" 
                            required="required" value="{{old('Postal')}}"><br>
                        </div>
                        <label for="Address" class="col-4 col-form-label">Address</label>
                        <div class="col-8">
                            <input id="Address" name="Address" placeholder="Address" type="text" class="form-control" 
                            required="required" value="{{old('Address')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-block btn-primary" type="submit">Save as Default</button>
                    </div>    
                </form> 
            </div>    
            </div>
            </div>
            <br><br><a href="{{ route('checkout')}}"><button class="btn btn-block btn-primary">Place Order</button></a>
        </div>
            @include('footer')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript">
    </script>

    <script>
        function addQuantity(ISBN13){
        fetch('shoppingCart/add-quantity', {
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
            if (response){
                var cartQty = document.getElementById('cartQty');
                var cartPrice = document.getElementById('cartPrice');
                var itemQty = document.getElementById(ISBN13 + 'Qty');
                var itemPrice = document.getElementById(ISBN13 + 'Price');
                var totalQty = document.getElementById('totalQty');
                var totalPrice = document.getElementById('totalPrice');

                console.log(response);
                cartQty.innerHTML = response.qty;
                cartPrice.innerHTML = "RM" + response.price;
                itemQty.innerHTML = response.subtotalQty;
                itemPrice.innerHTML = "RM" + response.subtotalPrice;
                totalQty.innerHTML = response.qty;
                totalPrice.innerHTML = "RM" + response.price;
            }
        })
        .catch(function(error){
            console.log(error)
        });    
    }
    </script>

    <script>
        function minusQuantity(ISBN13){
        fetch('shoppingCart/minus-quantity', {
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
            if (response){
                var cartQty = document.getElementById('cartQty');
                var cartPrice = document.getElementById('cartPrice');
                var itemQty = document.getElementById(ISBN13 + 'Qty');
                var itemPrice = document.getElementById(ISBN13 + 'Price');
                var totalQty = document.getElementById('totalQty');
                var totalPrice = document.getElementById('totalPrice');
                var shippingPrice = document.getElementById('shippingPrice');

                console.log(response);
                cartQty.innerHTML = response.qty;
                cartPrice.innerHTML = "RM" + response.price;
                itemQty.innerHTML = response.subtotalQty;
                itemPrice.innerHTML = "RM" + response.subtotalPrice;
                totalQty.innerHTML = response.qty;
                totalPrice.innerHTML = "RM" + response.price;
            }
        })
        .catch(function(error){
            console.log(error)
        });    
    }
    </script>

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
            
            row.remove();

            
        })
        .catch(function(error){
            console.log(error)
        });    
    }
    </script>

    <script type="text/javascript">
        // detect Country API
        document.body.onload = function() {
            getAddress()
        };

        function getAddress(){
            fetch('shoppingCart/get-user-address', {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-Token': $('meta[name="csrf_token"]').attr('content')
                },
                method: 'post',
                credentials: "same-origin",})
            .then(function (response) {
                return response.json();
            })
            .then(function (user) {
                if (user.country){
                    var Country = document.getElementById('Country');
                    var State = document.getElementById('State');
                    var District = document.getElementById('District');
                    var Postal = document.getElementById('Postal');
                    var Address = document.getElementById('Address');
                            
                    Country.value = user.country;
                    State.value = user.state;
                    District.value = user.district;
                    Postal.value = user.postcode;
                    Address.value = user.address;
                
                    //if country is Malaysia, set to local
                    if(user.country == 'Malaysia') {
                        <?php 
                            Session::put('postageBase', $postage[0]->local_base); 
                            Session::put('postageIncrement', $postage[0]->local_increment);
                        ?>
                    }
                    //if not Malaysia, set to international
                    else {
                        <?php
                            Session::put('postageBase', $postage[0]->international_base);
                            Session::put('postageIncrement', $postage[0]->international_increment);
                        ?>
                    }

                }else{ // otherwise call API to get user country
                getCountry();
                }
            })
            .catch(function(error){
                console.log(error)
            });    
        }
        function getCountry(){
            fetch('https://api.ipregistry.co/?key=tryout')
            .then(function (response) {
                return response.json();
            })
            .then(function (payload) {
                document.getElementById("Country").value = payload.location.country.name;
                //set to local just in case
                <?php 
                    Session::put('postageBase', $postage[0]->local_base); 
                    Session::put('postageIncrement', $postage[0]->local_increment);
                ?>
                console.log(payload);
            })
            .catch(function(error){
                console.log(error)
            });    
        } 
    </script>
</body>
</html>