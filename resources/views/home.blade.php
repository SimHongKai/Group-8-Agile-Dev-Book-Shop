<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    @include('header')
    <div class="container">
        <div id='content'>
            <h1><font face='Impact'>HOME PAGE</font></h1>
            
        <div class="container">
            <div class="card2">
                <ul>
                    @foreach ($stocks as $stock) 
                        <li>
                        <a href = "{{ route('bookDetails', [ 'ISBN13'=> $stock->ISBN13 ]) }}">
                            <img class="card-img-top" src="{{ asset('book_covers')}}/{{$stock->coverImg }}"/></a><br>
                        <a href = "{{ route('bookDetails', [ 'ISBN13'=> $stock->ISBN13 ]) }}">
                                <h5>{{ $stock->bookName }}</h5></a><br>
                                <h5>Price: RM{{ $stock->retailPrice }}</h4><br>
                                @if (session()->get('userPrivilige') == 2)
                                @elseif ($stock->qty > 0)
                                <div id="home-button">
                                    <button name="addButton" onclick="addItemToCart({{ $stock->ISBN13 }})" 
                                    class="btn btn-info">Add to Cart</button>
                                </div>
                                @else
                                <span class="home-text-details" style="background-color: red">OUT OF STOCK</span>
                                @endif
                        </li>
                    @endforeach
                </ul>
                </div>
            </div>
        </div>
    <div>
    @include('footer')
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js">
</script>

<script>
    function addItemToCart(ISBN13){
    fetch('home/add-to-cart', {
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
        if (response.login){
            var cartQty = document.getElementById('cartQty');
            var cartPrice = document.getElementById('cartPrice');
                       
            console.log(response);
            cartQty.innerHTML = response.qty;
            cartPrice.innerHTML = response.price;
        }
        else{
            window.location.href = "{{ route('LoginUser') }}";
        }
    })
    .catch(function(error){
        console.log(error)
    });    
}

</script>
</html>

