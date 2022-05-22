<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Stock Levels</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        
    </head>

    <body>
        @include('header')
        <div class = "container">
            <div id='content'>
                <h1><font face='Impact'>Stock Levels</font></h1>
                <div id = 'stock_buttons'>
                    <a href="<?php echo route('addStocks') ?>" class="btn btn-info">Add Stocks</a>
                    <a href="<?php echo route('editStocks') ?>" class="btn btn-info">Edit Stocks</a>
                </div><br>

                <form method="post" action="{{route('stock-filtering')}}" enctype="multipart/form-data">
                @csrf
                     <div class="form-group row">
                        <label for="bookName" class="col-sm-1 col-form-label">Book Title:</label>
                        <div class="col-sm-9">
                        <input name="bookName" type="text" class="form-control" id="bookName" placeholder="Book Title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="qty" class="col-sm-1 col-form-label">Quantity:</label>
                        <div class="col-sm-9">
                            <input name="qty" type="number" class="form-control" id="qty"
                                placeholder="Quantity">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-sm-3 col-sm-6">
                        <button class="btn btn-block btn-primary" type="submit">Filter</button>
                        </div>
                    </div>
                </form>
                
                <!-- Print message that stock was updated -->
                @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('fail'))
                <div class="alert alert-danger">{{Session::get('fail')}}</div>
                @endif
                @csrf
                @foreach ($stocks as $stock)
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
                @endforeach
                @include('footer') 
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>

    
    
