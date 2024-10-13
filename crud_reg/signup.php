<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    require_once 'db_connection.php';
    session_start();

    $errors = [];

    function validateName($name)
    {
        return preg_match('/^[a-zA-Z\s]*$/', $name);
    }

    function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validatePassword($password)
    {
        return strlen($password) >= 8 &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[a-z]/', $password) &&
            preg_match('/\d/', $password) &&
            preg_match('/[\W]/', $password) &&
            !preg_match('/\s/', $password);
    }

    function confirmPassword($password, $confirmPassword)
    {
        return $password === $confirmPassword;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $pass = $_POST['pass'] ?? '';
        $re_pass = $_POST['re_pass'] ?? '';

        if (!$email || !validateEmail($email)) {
            $errors['email'] = "Please enter a valid email address.";
        }

        if (!$name || !validateName($name)) {
            $errors['name'] = "Please enter a valid name.";
        }

        if (!$pass || !validatePassword($pass)) {
            $errors['pass'] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        }

        if (!confirmPassword($pass, $re_pass)) {
            $errors['re_pass'] = "Passwords do not match.";
        }

        if (empty($errors)) {
            try {
                $pass = password_hash($pass, PASSWORD_DEFAULT);
                $dbConn = getDBConnection();

                $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
                $stmt = $dbConn->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':password' => $pass,
                ]);

                echo "New record created successfully";
                header('Location: login.php');
                exit;
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
    }
    ?>

    <div class="main">
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" class="register-form" id="register-form">

                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name" value="<?php echo $_POST['name'] ?? ''; ?>" />
                                <div class="invalid-feedback">
                                    <?php echo $errors['name'] ?? ''; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" />
                                <div class="invalid-feedback">
                                    <?php echo $errors['email'] ?? ''; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password" />
                                <div class="invalid-feedback">
                                    <?php echo $errors['pass'] ?? ''; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="re_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password" />
                                <div class="invalid-feedback">
                                    <?php echo $errors['re_pass'] ?? ''; ?>
                                </div>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Sign up" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sign up image"></figure>
                        <a href="login.php" class="signup-image-link">I already have an account</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>