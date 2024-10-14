<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php
    require 'db_connection.php';
    session_start();

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = trim($_POST['pass'] ?? '');


        if (!$email || !$password) {
            $error = "Please enter both email and password.";
        } else {
            try {
                $dbConn = getDBConnection();

                $stmt = $dbConn->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$user) {
                    $error = "Invalid email or password.";
                } else {


                    if (password_verify($password, $user['password'])) {

                        $_SESSION['user'] = $user['name'];
                        $_SESSION['user_email'] = $user['email'];

                        header('location: profile.php');
                        exit;
                    } else {
                        echo "Not verified";
                        $error = "Invalid email or password.";
                    }
                }
            } catch (PDOException $e) {
                $error = "Error: " . $e->getMessage();
            }
        }
    }
    ?>

    <div class="main">
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sign up image"></figure>
                        <a href="signup.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Log In</h2>

                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="email" id="email" placeholder="Your Email" required />
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password" required />
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                            </div>
                            <?php if ($error): ?>
                                <div class="error-message"><?php echo $error; ?></div>
                            <?php endif; ?>
                        </form>
                        <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>