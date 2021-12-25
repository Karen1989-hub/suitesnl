<?php 

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$users = $_SESSION['users'][0] ?? [];


if(empty($users)){  

    header("location:../adminlogin/index.php");  

}
// include realpath(__DIR__ . '/..').'/server.php';
// $server    = new Server();

if(!isset($db)){
    include '../include/db.php';
    $db = getdb();
}

function getProperty(){
    global $db;
        
    $sql = "SELECT id, naam, url FROM `property` " ;

    $stmt = $db->prepare($sql); 
    $stmt->execute([]);
        
    $dataDable = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return $dataDable;
}

$data = getProperty();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">

    <title>Document</title>
</head>
<body>
    <h1><?php print_r($users['name'])  ?></h1>
    <h1><?php print_r($users['surname'])  ?></h1>
    <h1><?php print_r($users['email'])  ?></h1>   

    <form action="/request.php" method="post">
        <input type="hidden" name="method" value="logout">
        <button>Log Out</button>
    </form>

    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Url</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $key) :?>
            <tr>
                <td><?php print_r($key['naam'])?></td>
                <td><?php print_r($key['url'])?></td>
                <td><a href='admin-list.php?id=<?php print_r($key['id'])?>'>Edit</a></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready( function () {
        $('#table_id').DataTable( {
            "pageLength": 100
        }); 
    });
</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

</html>