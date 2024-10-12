<?php
session_start();


if (isset($_GET['index']) && isset($_SESSION['users'][$_GET['index']])) {
    $index = $_GET['index'];
    $user = $_SESSION['users'][$index];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
        $_SESSION['users'][$index]['email'] = $_POST['email'];
        $_SESSION['users'][$index]['fullName'] = $_POST['fullName'];
        header("Location: admin.php"); 
        exit();
    }
} else {
    echo "User not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        <form method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="fullName" class="form-control" value="<?= $user['fullName'] ?>" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="view_users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
