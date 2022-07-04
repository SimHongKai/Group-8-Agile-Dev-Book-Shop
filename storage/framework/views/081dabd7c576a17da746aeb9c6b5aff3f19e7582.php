<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Edit Stocks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="edit-stock-container">
        <div id='edit-stock-content'>
            <div id = 'edit-stock-form'>
                <h1><font face='Impact'>Edit Stocks Form</font></h1>
                <form action="<?php echo e(route('edit-stock')); ?>" method="post" enctype="multipart/form-data">
                    <!-- Print error message that stock was NOT updated -->
                    <?php if(Session::has('success')): ?>
                    <div class="alert alert-success"><?php echo e(Session::get('success')); ?></div>
                    <?php endif; ?>
                    <?php if(Session::has('fail')): ?>
                    <div class="alert alert-danger"><?php echo e(Session::get('fail')); ?></div>
                    <?php endif; ?>
                    <?php echo csrf_field(); ?>
                    <div class="form-group row">
                        <label for="ISBN13" class="col-4 col-form-label">ISBN-13</label> 
                        <div class="col-8">
                            <input id="ISBN13" name="ISBN13" placeholder="ISBN-13" type="text" class="form-control" 
                            required="required" value="<?php echo e(old('ISBN13')); ?>" onkeyup="getExistingStock(this.value)">
                            <span class="text-danger"><?php $__errorArgs = ['ISBN13'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bookName" class="col-4 col-form-label">Book Name</label> 
                        <div class="col-8">
                            <input id="bookName" name="bookName" placeholder="Book Name" type="text" class="form-control" 
                            required="required" value="<?php echo e(old('bookName')); ?>">
                            <span class="text-danger"><?php $__errorArgs = ['bookName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bookDesc" class="col-4 col-form-label">Book Description</label> 
                        <div class="col-8">
                            <textarea id="bookDesc" name="bookDesc" placeholder="Book Description" class="form-control" 
                            rows="5" required="required" value="<?php echo e(old('bookDesc')); ?>"></textarea>
                            <span class="text-danger"><?php $__errorArgs = ['bookDesc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bookAuthor" class="col-4 col-form-label">Book Author</label> 
                        <div class="col-8">
                            <input id="bookAuthor" name="bookAuthor" placeholder="Book Author" type="text" class="form-control" 
                            required="required" value="<?php echo e(old('bookAuthor')); ?>">
                            <span class="text-danger"><?php $__errorArgs = ['bookAuthor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="publicationDate" class="col-4 col-form-label">Publication Date</label> 
                        <div class="col-8">
                            <input id="publicationDate" name="publicationDate" placeholder="Publication Date" type="date" 
                            class="form-control" required="required" value="<?php echo e(old('publicationDate')); ?>">
                            <span class="text-danger"><?php $__errorArgs = ['publicationDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tradePrice" class="col-4 col-form-label">Trade Price</label>
                        <div class="col-8">
                            <input id="tradePrice" name="tradePrice" type="number" step="0.01" required="required" min="20" max="100"
                            value="<?php echo e(old('tradePrice')); ?>" placeholder="0.00" class="form-control">    
                            <div id="sliderBox">
                                <input type="range" id="tradePriceSlider" step="0.01" min="20" max="100" class="form-control">
                            </div>
                        </div> 
                        <span class="text-danger"><?php $__errorArgs = ['tradePrice'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></span> 
                    </div>
                    <div class="form-group row">
                        <label for="retailPrice" class="col-4 col-form-label">Retail Price</label>
                        <div class="col-8">
                        <input id="retailPrice" name="retailPrice" type="number" step="0.01" required="required" min="20" max="100"
                            value="<?php echo e(old('retailPrice')); ?>" placeholder="0.00" class="form-control">   
                            <div id="sliderBox">
                                <input type="range" id="retailPriceSlider" step="0.01" min="20" max="100" class="form-control">
                            </div>
                        </div>
                        <span class="text-danger"><?php $__errorArgs = ['retailPrice'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></span>
                    </div>   
                    <div class="form-group row">
                        <label for="qty" class="col-4 col-form-label">Quantity</label>
                        <div class="col-8">
                        <input id="qty" name="qty" placeholder="Quantity" type="number" 
                            class="form-control" value="<?php echo e(old('qty')); ?>" disabled>
                            <span class="text-danger"><?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></span>
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
                        <img style="visibility:hidden" id="preview" src="" width=30% height=30%/>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-block btn-primary" type="submit">Edit Stock</button>
                    </div>
                    <br>
                </form> 
            </div>
            <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        type="text/javascript">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
    </script>
    <script>
  
    // onkeyup event will occur when the user 
    // release the key and calls the function
    // assigned to this event
    function getExistingStock(str) {
        if (str.length == 0) {
            return;
        }
        else {
            // Creates a new XMLHttpRequest object
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                // Defines a function to be called when
                // the readyState property changes
                if (this.readyState == 4 && this.status == 200) {
                    
                        // parse the returned JSON
                        if (this.responseText == null){
                            return;
                        }else{
                            var stock = JSON.parse(this.responseText);
                        }
                        //fill in form data
                        document.getElementById("bookName").value = stock.bookName;
                        document.getElementById("bookDesc").value = stock.bookDescription;
                        document.getElementById("bookAuthor").value = stock.bookAuthor;
                        document.getElementById("publicationDate").value = stock.publicationDate;
                        document.getElementById("tradePrice").value = stock.tradePrice;
                        document.getElementById("retailPrice").value = stock.retailPrice;
                        document.getElementById("qty").value = stock.qty;
                }
            };
            // open xml http request
            xmlhttp.open("POST", "editStocks/get-stock", true);
            var data = '_token=<?php echo e(csrf_token()); ?>&ISBN13=' + str;
            xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            // xhttp.open("GET", "filename", true);
            
            // Sends the request to the server
            xmlhttp.send(data);
        }
    }
    </script>
    <script>
        coverImg.onchange = evt => {
        const [file] = coverImg.files
        if (file) {
        preview.style.visibility = 'visible';

        preview.src = URL.createObjectURL(file)
        }
    }
    </script>

<script>
        var sliderLeft=document.getElementById("tradePrice");
        var sliderRight=document.getElementById("retailPrice");
        var inputMin=document.getElementById("tradePriceSlider");
        var inputMax=document.getElementById("retailPriceSlider");

    ///value updation from input to slider
    //function input update to slider
    function sliderLeftInput(){//input update slider left
        sliderLeft.value=inputMin.value;
    }

    function sliderRightInput(){//input update slider right
        sliderRight.value=(inputMax.value);//chnage in input max updated in slider right
    }

    //calling function on change of inputs to update in slider
    inputMin.addEventListener("change",sliderLeftInput);
    inputMax.addEventListener("change",sliderRightInput);

    ///value updation from slider to input
    //functions to update from slider to inputs 
    function inputMinSliderLeft(){//slider update inputs
        inputMin.value=sliderLeft.value;
    }

    function inputMaxSliderRight(){//slider update inputs
        inputMax.value=sliderRight.value;
    }

    sliderLeft.addEventListener("change",inputMinSliderLeft);
    sliderRight.addEventListener("change",inputMaxSliderRight);
    </script>

</body>
</html>

<?php /**PATH C:\HongKai\Software\xampp\htdocs\Book_Shop\resources\views/editStocks.blade.php ENDPATH**/ ?>