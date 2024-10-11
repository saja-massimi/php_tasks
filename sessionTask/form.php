<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <style>
    table {
        border: 1px solid black;
        display: none;
        align-items: center;
    }
    </style>
</head>

<body>
    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_SESSION["users"])) {
            $_SESSION['users'] = [];
        }
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $newUser = [
            "name" => $name,
            "email" => $email,
            "password" => $password,
        ];
        $_SESSION["users"][] = $newUser;


    }

    ?>


    <form method="POST">
        Name: <input type="text" name="name" required><br>
        E-mail: <input type="email" name="email" required><br>
        password: <input type="password" name="password" required><br>
        <input type="submit" value="Submit">
    </form>
    </br>
    <button id="showTable">Show Table</button>
    </br><br>

    <table border="1">

        <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
        </thead>


        <?php
        foreach ($_SESSION['users'] as $user) {
            echo '<tr>';
            echo "<td>" . $user["name"] . "</td>";
            echo "<td>" . $user["email"] . "</td>";
            echo "<td>" . $user["password"] . "</td>";
            echo '</tr>';
        }
        ?>

    </table>

    <script>
    let flag = false;

    document.getElementById('showTable').addEventListener('click', function() {
        const table = document.querySelector('table');
        if (flag) {
            table.style.display = 'none';

        } else {
            table.style.display = 'block';

        }
        flag = !flag;
    });
    </script>
</body>

</html>