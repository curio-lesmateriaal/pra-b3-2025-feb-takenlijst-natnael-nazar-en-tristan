<?php
session_start(); // Start de sessie
session_destroy(); // Vernietig de sessie
header('Location: ../../login.php'); // Doorsturen naar inlogpagina
exit;
?>