<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Sign In Page</title>
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
                                <img class="card-img-top" src="{{ asset('book_covers')}}/{{$stock->coverImg }}"/><br>
                                <h5>{{ $stock->bookName }}</h5><br>
                                <h5>Price: RM{{ $stock->retailPrice }}</h4><br>
                                <div id="home-button">
                                <a href="#" class="btn btn-info">Add to Cart</a>
                                </div>
                        </li>
                    @endforeach
                </ul>
                </div>
            </div>
        </div>
    <div>
    @include('footer')
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>

