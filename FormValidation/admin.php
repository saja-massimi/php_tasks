<?php
session_start();


if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = []; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Registered Users</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($_SESSION['users'] as $index => $user): ?>
                <tr>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['fullName'] ?></td>
                    <td>
                        <a href="edit_user.php?index=<?= $index ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_user.php?index=<?= $index ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="signup.php" class="btn btn-primary">Add New User</a>
    </div>
</body>
</html>
