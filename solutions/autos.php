<?php

if (!isset($_GET["name"]) || strlen($_GET["name"]) < 1) {
    die("Name parameter missing");
}
// if user click 'logout'
$host = $_SERVER['HTTP_HOST'];
$ruta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$url = "http://$host$ruta";
if (isset($_POST["logout"])) {
    header("Location: $url/index.php");
    die();
}


//control make is required, mileage and year should be numeric

$message = false;
$ok = false;
$rows=false;
$row=false;
if (isset($_POST["make"]) && isset($_POST["year"]) && isset($_POST["mileage"])) {
   
    $year = htmlentities($_POST['year']);
    $make = htmlentities($_POST['make']);
    $mile = htmlentities($_POST['mileage']);
    if ((strlen($make)) < 1) {
        $message = "Make is required.";
    } else {
        if (!is_numeric($year) or !is_numeric(($mile))) {
            $message = "Mileage and year must be numeric.";
        } else {
            $ok = "Record inserted.";
            //insert database when press add button
            require_once __DIR__ . '/pdo.php';
            $add = $pdo->prepare('INSERT INTO autos
                (make, year, mileage) VALUES ( :mk, :yr, :mi)');
            $arr = array(
                ':mk' => $make,
                ':yr' => $year,
                ':mi' => $mile
            );
            $add->execute($arr);
            
        }
    }
}

?>

<html>

<head>
    <title>e9e974e2 Automobile Tracker</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <h1>Tracking Autos for <? htmlentities($_GET["name"]) ?></h1>
        <form method="post">
            <p style="color:red"><?= $message ?></p>
            <p style="color:green"><?= $ok ?></p>

            <p>Make:
                <input type="text" name="make" size="60">
            </p>
            <p>Year:
                <input type="text" name="year">
            </p>
            <p>Mileage:
                <input type="text" name="mileage">
            </p>
            <input type="submit" value="Add">
            <input type="submit" name="logout" value="Logout">
        </form>

        <h2>Automobiles</h2>
        <ul>
            <?php
            $autos = $pdo -> prepare("SELECT * from autos");
            $autos->execute();
            $rows = $autos ->fetchAll();
            foreach($rows as $row){
                echo '<li>'.$row['year'].' '.$row['make'].'/'.$row['mileage'].'</li>';
             }
                
         ?>
        </ul>
    </div>


</body>

</html>