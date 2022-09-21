// error logout

<?php
try{
    $stmt = $pdo -> prepare("SELECT * FROM users where user_id = :who");
    $stmt->execute(array(":who"=>$_POST["who"]));
} catch (Exception $ex) {
    echo("Internal error, please contact support.");
    error_log("error.php, SQL error =".$ex->getMessage());
    return;
}
$row = $stmt -> fetch(PDO::FETCH_ASSOC);

?>