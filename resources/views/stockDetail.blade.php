<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Stock Levels</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        
    </head>

    <body>
        @include('header')
        <div class = "container">
            <div id='content'>
                <h1><font face='Impact'>Stock Levels</font></h1>
                @csrf
                <div id="cardStock" class="cardStock">
                    <div class="row">
                        <div class="innerLeft">
                            <img class="card-img-left" src="{{ asset('book_covers')}}/{{$stock->coverImg }}" height="200" width="150"/>
                        </div>
                         <div class="innerRight">
                            <div class="horizontal-card-footer"><br>
                                <a href = "{{ route('stockDetails', [ 'ISBN13'=> $stock->ISBN13 ]) }}">
                                    <span class="card-text-stock">Book Title: {{ $stock->bookName }}</span></a><br><br>
                                <span class="card-text-stock">ISBN-13 Number: {{ $stock->ISBN13 }}</span><br><br>
                                <span class="card-text-stock">Quantity: {{ $stock->qty }}</span><br><br>
                                <span class="card-text-stock">Price: {{ $stock->retailPrice }}</span>
                            </div>
                         </div>
                    </div>
                </div>
                @include('footer') 
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>