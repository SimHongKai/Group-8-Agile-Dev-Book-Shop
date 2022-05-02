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
            if (!empty($data)) {
                echo"<p1>{{$data->username}}</p1>";
                echo"<p1>{{$data->userPrivilige}}</p1>";
                echo"<p1><a href ='logout'>Log Out</a></p1>";
            }
            else{
                echo"<p1>nodata</p1>";
            }
        ?>
    </div>