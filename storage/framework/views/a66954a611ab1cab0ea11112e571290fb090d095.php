<meta charset=utf-8>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/main.css')); ?>">
</head>

<body>
    <div id='container'>
    <div id='mainpic'>
    </div>

    <div id='menu'>
        <?php
            //User logged in
            if (Session::has('userPrivilige')) {
                $value = Session::get('userPrivilige');
                // User Log In
                if($value==1){ 
        ?>
                <p1></p1>
                <a href="<?php echo url('home') ?>">Home</a>
                <p1></p1>
                <p1></p1>
                <p1></p1>
                <p1></p1>
                <p1></p1>
                <?php
                $price = Session::get('priceItem');
                $itemCount = Session::get('numItem');
                ?>
                <a href="<?php echo url('shoppingCart') ?>"  style="text-align:right; padding-top: 8px;">
                <img src="<?php echo e(asset('images/cartIcon.png')); ?>" width="40px" height="40px"></a>
                <p2 id = "cartQty"><?php echo $itemCount?></p2> <!--Item Num!-->
                <a id = "cartPrice" href="<?php echo url('shoppingCart') ?>">RM<?php echo $price?></a> <!--Price!-->
                
                <a href ="logout" style="color:yellow">Log Out</a>
        <?php
                }
                // Admin Log In
                elseif($value==2){ 
        ?>
                    <p1></p1>
                    <a href="<?php echo url('home') ?>">Home</a>
                    <a href="<?php echo url('stocks') ?>">Stock Level</a>
                    <p1></p1>
                    <p1></p1>
                    <p1></p1>
                    <p1></p1>
                    <p1></p1>
                    <p1></p1>
                    <a href ="logout" style="color:yellow">Log Out</a>
        <?php
                }
            }
            
            //User not logged in
            else{
        ?>  
                <p1></p1>
                <a href="<?php echo url('home') ?>">Home</a>
                <p1></p1>
                <p1></p1>
                <p1></p1>
                <p1></p1>
                <p1></p1>
                <p1></p1>
                <p1></p1>          
                <a href ="login" style="color:#66FF00">Log In</a>
        <?php    
            }
        ?>
        
    </div>
</body><?php /**PATH C:\HongKai\Software\xampp\htdocs\Book_Shop\resources\views/header.blade.php ENDPATH**/ ?>