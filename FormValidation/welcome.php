<?php
session_start();  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
</head>
<body>
    <?php
    
    if (isset($_SESSION['current_user'])) {
        echo "<h1>Welcome</h1>";
        echo "<p>Welcome back, " . $_SESSION['current_user']['email'] . "!</p>";
    } else {
        echo "<h1>Sign Up</h1>";
        echo "<p>No users found. Please sign up first.</p>";
    }
    ?>
</body>
</html>
