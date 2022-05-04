<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Add Stocks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    @include('header')
    <div class="container">
        <div id='add-stock-content'>
            <div id = 'add-stock-form'>
            <h1><font face='Impact'>Add Stocks Form</font></h1>
                <form action="{{route('add-stock')}}" method="post">
                    @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                    @endif
                    @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="ISBN13">ISBN-13</label>
                        <input type="text" class="form-control" id="ISBN13" maxlength="13" value="{{old('ISBN13')}}">
                        <span class="text-danger">@error('ISBN13') {{$message}} @enderror</span>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="bookName">Book Name</label>
                        <input type="text" class="form-control" id="bookName" value="{{old('bookName')}}">
                        <span class="text-danger">@error('bookName') {{$message}} @enderror</span>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="bookDesc">Book Description</label>
                        <input type="text" class="form-control" id="bookDesc" value="{{old('bookDesc')}}">
                        <span class="text-danger">@error('bookDesc') {{$message}} @enderror</span>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="bookAuthor">Book Author</label>
                        <input type="text" class="form-control" id="bookAuthor" value="{{old('bookAuthor')}}">
                        <span class="text-danger">@error('bookAuthor') {{$message}} @enderror</span>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="publicationDate">Publication Date</label>
                        <input type="date" class="form-control" placeholder="YYYY-MM-DD" id="publicationDate" value="{{old('publicationDate')}}">
                        <span class="text-danger">@error('publicationDate') {{$message}} @enderror</span>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="text" class="form-control" id="qty" value="{{old('qty')}}">
                        <span class="text-danger">@error('qty') {{$message}} @enderror</span>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <button class="btn btn-block btn-primary" type="submit">Add Stosck</button>
                    </div>
                    <br>
                </form> 
            </div>
            @include('footer')
        </div>
    </div>
    
</body>
<!-- Include jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
    $(document).ready(function(){
        var date_input=$('input[name="publicationDate"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy-mm-dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>

</html>

