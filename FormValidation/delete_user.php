<?php
session_start();

if (isset($_GET['index']) && isset($_SESSION['users'][$_GET['index']])) {
    unset($_SESSION['users'][$_GET['index']]);
    $_SESSION['users'] = array_values($_SESSION['users']); 
}

header("Location: admin.php"); 
exit();
?>
