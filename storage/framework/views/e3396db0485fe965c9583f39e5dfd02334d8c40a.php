<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">

    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container">
        <div id='content'>
            <h1><font face='Impact'>HOME PAGE</font></h1>
            
        <div class="container">
            <!-- Print message that order was made -->
            <?php if(Session::has('success')): ?>
            <div class="alert alert-success"><?php echo e(Session::get('success')); ?></div>
            <?php endif; ?>
            <?php if(Session::has('fail')): ?>
            <div class="alert alert-danger"><?php echo e(Session::get('fail')); ?></div>
            <?php endif; ?>
            <div class="card2">
                <ul>
                    <?php $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <li>
                        <a href = "<?php echo e(route('bookDetails', [ 'ISBN13'=> $stock->ISBN13 ])); ?>">
                            <img class="card-img-top" src="<?php echo e(asset('book_covers')); ?>/<?php echo e($stock->coverImg); ?>"/></a><br>
                        <a href = "<?php echo e(route('bookDetails', [ 'ISBN13'=> $stock->ISBN13 ])); ?>">
                                <h5><?php echo e($stock->bookName); ?></h5></a><br>

                                <h5>Price: RM<?php echo e($stock->retailPrice); ?></h4><br>
                                <?php if(session()->get('userPrivilige') == 2): ?>
                                <?php elseif($stock->qty > 0): ?>
                                <h5>Current Stock: <?php echo e($stock->qty); ?></h5><br>
                                <div id="home-button">
                                    <button name="addButton" onclick="addItemToCart(<?php echo e($stock->ISBN13); ?>)" 
                                    class="btn btn-info">Add to Cart</button>
                                </div>
                                <?php else: ?>
                                <span class="home-text-details" style="background-color: red">OUT OF STOCK</span>
                                <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                </div>
            </div>
        </div>
    <div>
    <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
            cartPrice.innerHTML = "RM"+ response.price;
        }
        else{
            window.location.href = "<?php echo e(route('LoginUser')); ?>";
        }
    })
    .catch(function(error){
        console.log(error)
    });    
}

</script>
</html>

<?php /**PATH C:\HongKai\Software\xampp\htdocs\Book_Shop\resources\views/home.blade.php ENDPATH**/ ?>