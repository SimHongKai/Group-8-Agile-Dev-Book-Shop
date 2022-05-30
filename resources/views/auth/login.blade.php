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
        <div id='signInContent'>
            <div id='sign-in-up-form'>
             <h1><font face='Impact'>Sign In</font></h1>
                <hr>
                <form action="{{route('login-user')}}" method="post">
                    @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                    @endif
                    @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="id">User Email</label>
                        <input type="text" class="form-control" placeholder="Enter Email" name="userEmail" value="{{old('userEmail')}}">
                        <span class="text-danger">@error('userEmail') {{$message}} @enderror</span>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label for="password">Password (Upper & Lower Case, Special Character, Number)</label>
                        <input type="password" class="form-control" placeholder="Enter Password" name="userPassword" value="{{old('userPassword')}}">
                        <span class="text-danger">@error('userPassword') {{$message}} @enderror</span>
                    </div>
                    <br>
                    <br>
            
                    <div class="form-group">
                        <button class="btn btn-block btn-primary" type="submit">Sign In</button>
                    </div>
                    <br>
                    <p1>Would you like to create an account ?</p1>
                    <a href ="registration">Sign Up</a>
                </form> 
            </div>
            @include('footer')
        </div>
    </div>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>

