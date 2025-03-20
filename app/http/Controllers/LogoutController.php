<?php
session_start();

// Verwijder alle sessie variabelen
$_SESSION = array();

// Vernietig de sessie cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Vernietig de sessie
session_destroy();

// Redirect naar de login pagina

session_start(); 
session_destroy(); 

header('Location: ../../../login.php');
exit;
?>