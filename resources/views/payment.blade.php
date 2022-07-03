<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Payment Page</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}"> 
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <script src="https://use.fontawesome.com/29ecae9da7.js"></script>
</head>

<body>
    @include('header')
    <div class="add-stock-container">
        <div id="add-stock-content">
        <h1><font face='Impact'>Payment Page</font></h1>
        <!-- Print message that order was made -->
        @if(Session::has('success'))
        <div class="alert alert-success">{{Session::get('success')}}</div>
        @endif
        @if(Session::has('fail'))
        <div class="alert alert-danger">{{Session::get('fail')}}</div>
        @endif
            <?php
                $price = Session::get('priceItem');
                $postagePrice = Session::get('postagePrice');
                $itemCount = Session::get('numItem');
            ?>
            <h2>Paying For: <p id="totalPrice">RM<?php echo $price + $postagePrice?></p></h2><br><br>
            <div class="shipping-address-container">
            <div id='shipping-address-content'>
            <div class = 'shipping-address-form'>
            <form action="{{route('submitpayment')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-50">
                <label for="acceptedcard" style="font-size:25px;">Payment Form</label><br><br>
                <label for="acceptedcards" style="color:grey;font-size:20px">Accepted Cards</label>
                    <div class="icon-container">
                        <i class="fa fa-cc-visa fa-3x" style="color:blue;"></i>
                        <i class="fa fa-cc-amex fa-3x" style="color:grey;"></i>
                        <i class="fa fa-cc-mastercard fa-3x" style="color:red;"></i>
                        <i class="fa fa-cc-discover fa-3x" style="color:orange;"></i>
                    </div>
                </div>
                <label for="cardlabel" class="col-4 col-form-label">Card Number</label>
                <div class="col-4">
                <input id="cardnumber" name="cardnumber" type="tel" inputmode="numeric" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx" class="form-control" 
                    required="required" value="{{old('cardnumber')}}"><br>
                    <span class="text-danger">@error('cardnumber') {{$message}} @enderror</span>
                </div>
                <label for="recipientname" class="col-4 col-form-label">Name on Card</label>
                <div class="col-4">
                    <input id="recipientname" name="recipientname" placeholder="Eg: John Smith" type="text" class="form-control" 
                    required="required" value="{{old('recipientname')}}"><br>
                    <span class="text-danger">@error('recipientname') {{$message}} @enderror</span>
                </div>
                <div class="col-2">
                    <label for="expiredate" class="col-4 col-form-label">Expiry Date: </label>
                    <input id="expirydate" name="expirydate" placeholder="MM/YY" type="text" class="form-control" 
                    required="required" size="5" maxlength="5" value="{{old('expirydate')}}"><br>
                    <span class="text-danger">@error('expirydate') {{$message}} @enderror</span>
                </div>
                    <div class="col-2">
                    <label for="ccv">CVV: </label>
                    <input id="cvv" name="cvv" size="3" placeholder="123" type="password" class="form-control" 
                    required="required" value="{{old('cvv')}}"><br>
                    </div>
                    <span class="text-danger">@error('cvv') {{$message}} @enderror</span>
                </div>
                <table cellspacing="10">
                    <tr>
                        <td>
                            </div>
                                <br><a href="{{ route('submitpayment')}}"><button class="btn btn-block btn-primary" type="submit"><b>Confirm Order</b></button></a>
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
            <table cellspacing="10">
                    <tr>
                        <td>
                            <div>
                                <br><a href ="{{ route('return-to-checkout')}}"><button div id = 'returnButton'>Return to Checkout Page</button></a></div>
                            </div>
                        </td>
                    </tr>
                </table>
                <br>
        </div>
        </div>
        </div>
    </div>

    @include('footer')

<script>
document.getElementById('cardnumber').oninput = function () {
    var foo = this.value.split(" ").join("");
    if (foo.length > 0) {
        foo = foo.match(new RegExp('.{1,4}', 'g')).join(" ");
    }
    this.value = foo;
};
</script>
</body>
</html>
