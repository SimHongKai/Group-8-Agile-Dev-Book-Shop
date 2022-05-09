<meta charset=utf-8>
<head>
<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>
    <div id='container'>
    <div id='mainpic'>
    </div>

    <div id='menu'>
        <?php
            //User logged in
            if (!empty($data)) {
                $value = $data->userPrivilige;
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
                <a href="<?php echo url('home') ?>"  style="text-align:right; padding-top: 8px;"><img src="images/cartIcon.PNG" width="40px" height="40px"></a>
                <p2>100</p2>
                <a href="<?php echo url('home') ?>">RM 15.50</a1>
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
</body>