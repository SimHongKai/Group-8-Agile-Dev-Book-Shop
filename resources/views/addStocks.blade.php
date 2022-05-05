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
                <h1><font face='Impact'>Add Stocks Form</font></h1>
                <form action="{{route('add-stock')}}" method="post">
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
                            <input id="ISBN13" name="ISBN13" placeholder="ISBN-13" type="text" class="form-control" 
                            required="required" value="{{old('ISBN13')}}">
                            <span class="text-danger">@error('ISBN13') {{$message}} @enderror</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bookName" class="col-4 col-form-label">Book Name</label> 
                        <div class="col-8">
                            <input id="bookName" name="bookName" placeholder="Book Name" type="text" class="form-control" 
                            required="required" value="{{old('bookName')}}">
                            <span class="text-danger">@error('bookName') {{$message}} @enderror</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bookDesc" class="col-4 col-form-label">Book Description</label> 
                        <div class="col-8">
                            <textarea id="bookDesc" name="bookDesc" placeholder="Book Description" class="form-control" 
                            rows="5" required="required" value="{{old('bookDesc')}}"></textarea>
                            <span class="text-danger">@error('bookDesc') {{$message}} @enderror</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bookAuthor" class="col-4 col-form-label">Book Author</label> 
                        <div class="col-8">
                            <input id="bookAuthor" name="bookAuthor" placeholder="Book Author" type="text" class="form-control" 
                            required="required" value="{{old('bookAuthor')}}">
                            <span class="text-danger">@error('bookAuthor') {{$message}} @enderror</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="publicationDate" class="col-4 col-form-label">Publication Date</label> 
                        <div class="col-8">
                            <input id="publicationDate" name="publicationDate" placeholder="Publication Date" type="date" 
                            class="form-control" required="required" value="{{old('publicationDate')}}">
                            <span class="text-danger">@error('publicationDate') {{$message}} @enderror</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tradePrice" class="col-4 col-form-label">Trade Price</label>
                        <div class="col-8">
                        <input id="tradePrice" name="tradePrice" placeholder="0.00" type="number" 
                            class="form-control" step="0.01" required="required" min="20" max="100" value="{{old('tradePrice')}}">
                            <span class="text-danger">@error('tradePrice') {{$message}} @enderror</span>
                        </div>  
                    </div>
                    <div class="form-group row">
                        <label for="retailPrice" class="col-4 col-form-label">Retail Price</label>
                        <div class="col-8">
                        <input id="retailPrice" name="retailPrice" placeholder="0.00" type="number" 
                            class="form-control" step="0.01" required="required" min="20" max="100" value="{{old('retailPrice')}}">
                            <span class="text-danger">@error('retailPrice') {{$message}} @enderror</span>
                        </div> 
                    </div>
                    <div class="form-group row">
                        <label for="qty" class="col-4 col-form-label">Quantity</label>
                        <div class="col-8">
                        <input id="qty" name="qty" placeholder="Quantity" type="number" 
                            class="form-control" required="required" value="{{old('qty')}}">
                            <span class="text-danger">@error('qty') {{$message}} @enderror</span>
                        </div>  
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Cover Image</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="coverImg" name="coverImg" aria-describedby="fileInput">
                            <label class="custom-file-label" for="coverImg">Cover Image</label>
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
    
</body>
</html>

