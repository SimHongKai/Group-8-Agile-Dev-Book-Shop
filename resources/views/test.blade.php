<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Add Stocks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    @include('header')
    <div class="add-stock-container">
        <div id='add-stock-content'>
            <div id = 'add-stock-form'>
                <h1><font face='Impact'>Test API Form</font></h1>
                <form action="{{route('add-stock')}}" method="post" enctype="multipart/form-data">
                    <!-- Print error message that stock was NOT updated -->
                    @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                    @endif
                    @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                    @endif
                    @csrf
                    <div class="form-group row">
                        <label for="ISBN13" class="col-4 col-form-label">ISBN-13</label> 
                        <div class="col-8">
                            <input id="Country" name="Country" placeholder="Country" type="text" class="form-control" 
                            required="required" value="{{old('Country')}}">
                            <span class="text-danger">@error('Country') {{$message}} @enderror</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-block btn-primary" type="submit">Add Stock</button>
                    </div>
                    <br>
                </form> 
            </div>
            @include('footer')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        type="text/javascript">
    </script>