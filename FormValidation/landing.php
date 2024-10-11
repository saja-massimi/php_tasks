<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
    html,
    body {
        height: 100%;
        margin: 0;
        background-color: #f3f3f3;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    main {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 20px;
    }

    img {
        width: 100px;
        height: 100px;
    }

    .buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
        padding: 20px;
    }
    </style>
</head>

<body>

    <main>
        <h1>Hello There!</h1>
        <p>Automatic identity verification which enables you to verify your identity</p>
        <img src="logo.jpg" alt="">
        <div class="buttons">
            <button type="button" class="btn btn-primary">Login</button>
            <button type="button" class="btn btn-danger">Sign up</button>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    const loginBtn = document.querySelector('.btn-primary');
    const signupBtn = document.querySelector('.btn-danger');

    loginBtn.addEventListener('click', () => {
        window.location.href = 'login.php';
    });

    signupBtn.addEventListener('click', () => {
        window.location.href = 'signup.php';
    });
    </script>
</body>

</html>