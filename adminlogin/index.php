<?php
    session_start();

?>

<?php $config = include "include/config.php"?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Suites.nl admin</title>
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
        form{
            margin:auto;
            max-width:450px;
            width:100%;
            display:flex;
            flex-direction:column;
            align-items:center
        }
        form>input,form>button{
            margin-top:10px;
            padding:5px;
        }
        .error{
            text-align:center;
            color:red
        }
    </style>
</head>
<body>
<!-- <h3>
<center> <a href="hotellist.php">Hotellijst Suites.nl</a><br /><br /> -->
<form action="/request.php" method="post">
    <h2>Login</h2>
    <p class="error"> <?php print_r($_SESSION['error']) ?></p>
    <input type="hidden" name="method" value="login">
    <input type="text" name="username" placeholder="username">
    <input type="password" name="password" placeholder="password">
    <button>Login</button>
</form>

</body>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
</html>
<?php 
unset($_SESSION['error']);
?>