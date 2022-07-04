<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
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
        <?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class = "container">
            <div id='content'>
                <h1><font face='Impact'>Stock Levels</font></h1>
                <div id = 'stock_buttons'>
                    <a href="<?php echo route('addStocks') ?>" class="btn btn-info">Add Stocks</a>
                    <a href="<?php echo route('editStocks') ?>" class="btn btn-info">Edit Stocks</a>
                </div><br>

                <form method="post" action="<?php echo e(route('stock-filtering')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
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
                <?php if(Session::has('success')): ?>
                <div class="alert alert-success"><?php echo e(Session::get('success')); ?></div>
                <?php endif; ?>
                <?php if(Session::has('fail')): ?>
                <div class="alert alert-danger"><?php echo e(Session::get('fail')); ?></div>
                <?php endif; ?>
                <?php echo csrf_field(); ?>
                <?php $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div id="cardStock" class="cardStock">
                    <div class="row">
                        <div class="innerLeft">
                            <img class="card-img-left" src="<?php echo e(asset('book_covers')); ?>/<?php echo e($stock->coverImg); ?>" height="200" width="150"/>
                        </div>
                         <div class="innerRight">
                            <div class="horizontal-card-footer"><br>
                                <a href = "<?php echo e(route('stockDetails', [ 'ISBN13'=> $stock->ISBN13 ])); ?>">
                                    <span class="card-text-stock">Book Title: <?php echo e($stock->bookName); ?></span></a><br><br>
                                <span class="card-text-stock">ISBN-13 Number: <?php echo e($stock->ISBN13); ?></span><br><br>
                                <?php if($stock->qty > 0): ?>
                                <span class="card-text-stock">Quantity: <?php echo e($stock->qty); ?></span><br><br>
                                <?php else: ?>
                                <span class="card-text-stock">Quantity:</span>
                                <span class="card-text-nostock"><?php echo e($stock->qty); ?></span><br><br>
                                <?php endif; ?>
                                <span class="card-text-stock">Price: RM<?php echo e($stock->retailPrice); ?></span>
                            </div>
                         </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>

    
    
<?php /**PATH C:\HongKai\Software\xampp\htdocs\Book_Shop\resources\views/stocks.blade.php ENDPATH**/ ?>