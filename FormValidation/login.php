<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        main {
            margin: 50px;
            padding: 30px;
            background-color: #f3f3f3;
            border-radius: 10px;
        }

        h1,
        p {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    
    ?>
    <main>
        <h1>Login</h1>
        <p>Welcome Back</p>

        <?php
        session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $loginEmail = $_POST['email'];
            $loginPassword = $_POST['pass'];
            
            if (isset($_SESSION['users']) && count($_SESSION['users']) > 0) {
                
              
                foreach ($_SESSION['users'] as $user) {
                    
                    if ($loginEmail == $user['email'] && $loginPassword == $user['password']) {

                        $_SESSION['current_user'] = $user;
                        if($user['email'] == 'admin@gmail.com') {
                            header("Location: admin.php");
                            exit();
                        }
                        header("Location: welcome.php");
                        exit();
                    }
                }
                
                $loginError = "Login Failed. Invalid email or password.";
            } else {
                $loginError = "No users found. Please sign up first.";
            }
        }
        ?>

        <?php if (isset($loginError)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $loginError; ?>
        </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Enter email" required>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
            <p>Don't have an account? <strong><a href="signup.php">Sign up</a></strong></p>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
