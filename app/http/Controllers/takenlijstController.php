<?php 
require_once __DIR__.'../../../../backend/config.php';
 
    require_once  __DIR__.'../../../../backend/conn.php';
    $query = "SELECT * FROM users";
    $statement = $conn->prepare($query);
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    $user = $_POST['user'];
    $password = $_POST['pass'];
    if($user = $users['username'] AND $password = $users['password']){
        header('Location:../../../index.php');
    }
    
?>