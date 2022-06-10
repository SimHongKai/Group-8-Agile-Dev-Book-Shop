S<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    @include('header')
    <div class="add-stock-container">
        <div id='add-stock-content'>
            <div class = 'shipping-address-form'>
                <h1><font face='Impact'>Shipping Address</font></h1>
                <form action="{{route('update-address')}}" method="post" enctype="multipart/form-data">
                    <!-- Print error message that address was NOT updated -->
                    @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                    @endif
                    @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                    @endif
                    @csrf
                    <div class="form-group row">
                        <label for="Country" class="col-4 col-form-label">Country</label> 
                        <div class="col-8">
                            <input id="Country" name="Country" placeholder="Country" type="text" class="form-control" 
                            required="required" value="{{old('Country')}}"><br>
                            <span class="text-danger">@error('Country') {{$message}} @enderror</span>
                        </div>
                        <label for="State" class="col-4 col-form-label">State</label>
                        <div class="col-8">
                            <input id="State" name="State" placeholder="State" type="text" class="form-control" 
                            required="required" value="{{old('State')}}"><br>
                        </div>
                        <label for="District" class="col-4 col-form-label">District</label>
                        <div class="col-8">
                            <input id="District" name="District" placeholder="District" type="text" class="form-control" 
                            required="required" value="{{old('District')}}"><br>
                        </div>
                        <label for="Postal" class="col-4 col-form-label">Postal</label>
                        <div class="col-8">
                            <input id="Postal" name="Postal" placeholder="Postal Code" type="text" class="form-control" 
                            required="required" value="{{old('Postal')}}"><br>
                        </div>
                        <label for="Address" class="col-4 col-form-label">Address</label>
                        <div class="col-8">
                            <input id="Address" name="Address" placeholder="Address" type="text" class="form-control" 
                            required="required" value="{{old('Address')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-block btn-primary" type="submit">Save as Default</button>
                    </div>
                    <br>
                </form> 
            </div>
            @include('footer')
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.2.1.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript">
    </script>
    <script type="text/javascript">
        // detect Country API
        document.body.onload = function() {
            getAddress()
        };

        function getAddress(){
            fetch('shoppingCart/get-user-address', {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-Token': $('meta[name="csrf_token"]').attr('content')
                },
                method: 'post',
                credentials: "same-origin",})
            .then(function (response) {
                return response.json();
            })
            .then(function (user) {
                if (user.country){
                    var Country = document.getElementById('Country');
                    var State = document.getElementById('State');
                    var District = document.getElementById('District');
                    var Postal = document.getElementById('Postal');
                    var Address = document.getElementById('Address');
                            
                    Country.value = user.country;
                    State.value = user.state;
                    District.value = user.state;
                    Postal.value = user.postcode;
                    Address.value = user.address;
                
                }else{ // otherwise call API to get user country
                getCountry();
                }
            })
            .catch(function(error){
                console.log(error)
            });    
        }
        function getCountry(){
            fetch('https://api.ipregistry.co/?key=tryout')
            .then(function (response) {
                return response.json();
            })
            .then(function (payload) {
                document.getElementById("Country").value = payload.location.country.name;
                console.log(payload);
            })
            .catch(function(error){
                console.log(error)
            });    
        } 
    </script>
</body>
</html>