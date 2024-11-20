<?php 
session_start();
include "function.php";

$errors = [];
if(isset($_POST["login"])) {
    checkLogin($_POST, $errors);
}

?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<title>Login Page</title>
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card shadow-lg" style="width: 100%; max-width: 400px;">
    <div class="card-body">
        <h2 class="text-center mb-4">Login</h2>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">

            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
            </div>

            <button name="login" type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger mt-3">
                <?php foreach($errors as $error) : ?>
                    <?= $error ?><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
