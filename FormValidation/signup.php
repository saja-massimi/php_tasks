<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
    main {
        margin: 100px 200px;
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

    <h1>Sign Up</h1>
    <p>Create an Account, it's free</p>

    <?php
    session_start();
    $errors = [];
    function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validateMobile($mobile)
    {
        return preg_match("/^\d{14}$/", $mobile);
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

    function validateDOB($dob)
    {
        $dobDate = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($dobDate)->y;
        return $age >= 16;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'] ?? '';
        $mobile = $_POST['phoneNum'] ?? '';
        $fullName = $_POST['fullName'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';
        $dob = $_POST['dob'] ?? '';

        if (!$email || !validateEmail($email)) {
            $errors['email'] = "Please enter a valid email address.";
        }

        if (!$mobile || !validateMobile($mobile)) {
            $errors['phoneNum'] = "Please enter a valid 14-digit mobile number.";
        }

        if (!$fullName || !preg_match("/^[a-zA-Z\s]+$/", $fullName)) {
            $errors['fullName'] = "Please enter a valid full name.";
        }

        if (!$password || !validatePassword($password)) {
            $errors['password'] = "Password must be at least 8 characters, include uppercase, lowercase, numbers, and special characters.";
        }

        if (!confirmPassword($password, $confirmPassword)) {
            $errors['confirmPassword'] = "Passwords do not match.";
        }

        if (!$dob || !validateDOB($dob)) {
            $errors['dob'] = "You must be 16 years or older to register.";
        }

        if (empty($errors)) {
            $newUser = [
                "email" => $email,
                "phoneNum" => $mobile,
                "fullName" => $fullName,
                "password" => $password,
                "dob" => $dob,
            ];

            $_SESSION['users'][] = $newUser;

            echo "<p class='text-success text-center'>Registration successful!</p>";
            header("Location: login.php");
            exit();
        }
    }
    ?>

    <main>
        <form method="post">

            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>

                <input type="email" name="email"
                    class="form-control "
                    id="exampleInputEmail1" placeholder="Enter email" value="<?php echo $_POST['email'] ?? ''; ?>">

                <div class="invalid-feedback">
                    <?php echo $errors['email'] ?? ''; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="phoneNum">Phone Number</label>
                <input type="number" name="phoneNum"
                    class="form-control" id="phoneNum"
                    placeholder="Phone Number" value="<?php echo $_POST['phoneNum'] ?? ''; ?>">
                <div class="invalid-feedback">
                    <?php echo $errors['phoneNum'] ?? ''; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" name="fullName"
                    class="form-control" id="fullName"
                    placeholder="Full Name" value="<?php echo $_POST['fullName'] ?? ''; ?>">
                <div class="invalid-feedback">
                    <?php echo $errors['fullName'] ?? ''; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password"
                    class="form-control"
                    id="exampleInputPassword1" placeholder="Password">
                <div class="invalid-feedback">
                    <?php echo $errors['password'] ?? ''; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" name="confirmPassword"
                    class="form-control <?php echo isset($errors['confirmPassword']) ? 'is-invalid' : ''; ?>"
                    id="confirmPassword" placeholder="Confirm Password">
                <div class="invalid-feedback">
                    <?php echo $errors['confirmPassword'] ?? ''; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" name="dob"
                    class="form-control <?php echo isset($errors['dob']) ? 'is-invalid' : ''; ?>" id="dob"
                    value="<?php echo $_POST['dob'] ?? ''; ?>">
                <div class="invalid-feedback">
                    <?php echo $errors['dob'] ?? ''; ?>
                </div>
            </div>

            <br>
            <button type="submit" class="btn btn-danger">Submit</button>
            <p>Already have an account? <strong><a href="login.php">Login</a></strong></p>
        </form>

    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>