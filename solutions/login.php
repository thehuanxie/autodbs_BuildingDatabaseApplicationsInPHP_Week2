<?php
// if user click 'cancel'
$host = $_SERVER['HTTP_HOST'];
$ruta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$url = "http://$host$ruta";
if (isset($_POST["cancel"])) {
    header("Location: $url/index.php");
    die();
}
//login control
$message = false;
$salt = 'XyZzy12*_';
//hash stored php123 salted
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
// md5 generated with user input pass

if (isset($_POST["who"]) && isset($_POST["pass"])) {
    $message = false;
    $md5 = hash("md5", $salt . $_POST["pass"]);
    if (strlen($_POST["who"]) < 1 || strlen($_POST["pass"]) < 1) {
        $message = "User name and password are required";
    } else {
        if (!strpos($_POST["who"], "@")){
        $message = "Email must have an at-sign (@)";
        } else {
            if ($md5 != $stored_hash) {
                error_log("Login fail ".$_POST['who']." $md5");
                $message = "Incorrect password";
            } else {
                error_log("Login success ".$_POST['who']);
                header("Location: $url/autos.php?name=".urlencode($_POST['who']));
                die();
            }
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <title>e9e974e2 Login Page</title>
</head>

<body>
    <div class="container">
        <h1>Please Log In</h1>
        <p style="color:red"> <?= $message ?> </p>
        <form method="POST">
            <label for="nam">User Name</label>
            <input type="text" name="who" id="nam"><br>
            <label for="id_1723">Password</label>
            <input type="password" name="pass" id="id_1723"><br>
            <input type="submit" value="Log In">
            <input type="submit" name="cancel" value="Cancel">
        </form>
        <p>
            For a password hint, view source and find a password hint
            in the HTML comments.
            <!-- Hint: The password is the three character name of the 
programming language used in this class (all lower case) 
followed by 123. -->
        </p>
    </div>

</body>

</html>