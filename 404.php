<?php $config = include "include/config.php"?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 Not found</title>
    <style>
        body{
            overflow: hidden;
        }
        .wrapper{
            width: 100%;
        }
        .wrapper img{
            width: 100%;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <img src="<?=$config['APP_DIR']?>/assets/images/404.jpg" alt="ERROR IMG">
    </div>
</body>
</html>