<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="ie-edge">
        <title>Book Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        
    </head>

    <body>
        @include('header')
        <div class = "container">
            <div id='content'>
                <h1><font face='Impact'>Book Details</font></h1>
                @csrf
                <div id="cardStock" class="card-book-details">
                    <div class="row">
                        <div class="innerLeft">
                            <img class="stock-details" src="{{ asset('book_covers')}}/{{$stock->coverImg }}" height="200" width="150"/>
                        </div>
                         <div class="innerRight">
                            <div class="horizontal-card-footer"><br>
                                <span class="card-title-product">Book Title:</span><br>
                                <span class="card-product-details">{{ $stock->bookName }}</span></a><br>
                                <span class="card-title-product">ISBN-13 Number:</span><br> 
                                <span class="card-product-details">{{ $stock->ISBN13 }}</span><br>
                                <span class="card-title-product">Author: </span><br>
                                <span class="card-product-details">{{$stock->bookAuthor}}</span><br>
                                <span class="card-title-product">Book Publication Date:</span><br>
                                <span class="card-product-details">{{$stock->publicationDate}}</span><br>
                                <span class="card-title-product">Book Description:</span><br>
                                <span class="card-product-details">{{$stock->bookDescription}}</span><br>
                                <span class="card-title-product">Quantity:</span><br>
                                <span class="card-product-details">{{ $stock->qty }}</span><br>
                                <span class="card-title-product">Price:</span><br>
                                <span class="card-product-details">RM{{ $stock->retailPrice }}</span>
                                @if (session()->get('userPrivilige') == 2)
                                @elseif ($stock->qty > 0)
                                <div id="home-button">
                                    <button name="addButton" onclick="addItemToCart({{ $stock->ISBN13 }})" 
                                    class="btn btn-info">Add to Cart</button>
                                </div>
                                @else
                                <span class="home-text-details" style="background-color: red">OUT OF STOCK</span>
                                @endif
                            </div>
                         </div>
                    </div>
                </div>
                @include('footer') 
            </div>
        </div>
    </body>
    <script>

        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
<script src="https://code.jquery.com/jquery-3.2.1.min.js">
</script>   
<script>
    function addItemToCart(ISBN13){
        fetch('{{ route('addCart')}}', {
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
                        
                console.log(response);
                cartQty.innerHTML = response.qty;
                cartPrice.innerHTML = response.price;
            }
        })
        .catch(function(error){
            console.log(error)
        });    
    }

</script>
</html>