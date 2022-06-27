<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Payment Page</title>
</head>

<body>
    @include('header')
    <div class="add-stock-container">
        <div id="add-stock-content">
        <h1>Payment Page</h1>
        <table id="payment-table">
            <tr>
                <?php
                $price = Session::get('priceItem');
                $itemCount = Session::get('numItem');
                ?>
                <td>Paying For: <p id="totalPrice">RM<?php echo $price?></p><br><br>
                Billing Address:<br>
                    {{$user->address}},<br>
                    {{$user->district}},<br>
                    {{$user->postcode}}, {{$user->state}}<br>
                    {{$user->country}} 
                </td>
                <td>
                <form action="{{route('payment')}}" method="post" enctype="multipart/form-data">
                        <label for="cardnumber" class="col-4 col-form-label">Card Number</label>
                        <div class="col-8">
                            <input id="cardnumber" name="cardnumber" placeholder="CardNumber" type="text" class="form-control" 
                            required="required" value="{{old('cardnumber')}}"><br>
                        </div>
                        <label for="recipientname" class="col-4 col-form-label">Cardholder Name</label>
                        <div class="col-8">
                            <input id="recipientname" name="recipientname" placeholder="Cardholder Name" type="text" class="form-control" 
                            required="required" value="{{old('recipientname')}}"><br>
                        </div>
                        <label for="expiredate" class="col-4 col-form-label">Expiry Date</label>
                        <div class="col-8">
                            <input id="expiredate" name="expiredate" placeholder="Card Expiry Date" type="text" class="form-control" 
                            required="required" value="{{old('expiredate')}}"><br>
                        </div>
                        <label for="ccv" class="col-4 col-form-label">CCV</label>
                        <div class="col-8">
                            <input id="ccv" name="ccv" placeholder="CCV" type="text" class="form-control" 
                            required="required" value="{{old('ccv')}}"><br>
                        </div>
                        <button class="btn btn-block btn-primary" type="submit">Confirm Payment</button>
                </td>        
            </tr>
        </table>
            </form>
        </div>
    </div>

    @include('footer')
</body>
</html>
