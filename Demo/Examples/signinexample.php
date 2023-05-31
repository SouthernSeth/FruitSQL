<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="signinexample.css" rel="stylesheet">
</head>

<?php

include '../../Library/FruitSQL_Init.php';
$fruitsql = new FruitSQL();
$auth = new Authentication($fruitsql, 'users', 12);
$statusMessage = '';

$loginForm = <<<END
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <form action="" method="post" class="form-signin bg-dark rounded p-4">
                    <!-- Logo Placeholder -->
                    <div class="mb-4 text-center">
                        <img class="mb-4" src="../Images/lock.svg" alt="" width="72" height="72">
                        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
                        <h1 class="h6 mb-3 fw-normal text-danger">%s</h1>
                    </div>

                    <!-- Username Field -->
                    <div class="form-floating">
                        <input name="Email" type="text" class="form-control" id="floatingInput" placeholder="Email" required autofocus>
                        <label for="floatingInput">Email</label>
                    </div>

                    <!-- Password Field -->
                    <div class="form-floating">
                        <input name="Password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="checkbox mb-3 text-center">
                        <input name="RememberMe" type="checkbox" value="remember-me" id="rememberMe">
                        <label for="rememberMe">Remember me</label>
                    </div>

                    <!-- Sign In Button -->
                    <button name="SubmitButton" class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
END;

if (isset($_POST["SubmitButton"])) {
    $email = $_POST["Email"];
    $rawPassword = $_POST["Password"];
    $rememberMe = $_POST["RememberMe"];

    $isAuthed = $auth->VerifyLogin($email, $rawPassword);
    
    if ($isAuthed) {
        echo '<div style="width: 100%; text-align: center; margin-top: 1em;">Verified credentials successfully<br>Remember me = ' . ($rememberMe ? 'true' : 'false') . '</div>';
    } else {
        echo sprintf($loginForm, 'Wrong username or password');
    }
} else {
    echo sprintf($loginForm, '');
}

?>

</html>