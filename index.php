<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
    <style>
    </style>
</head>
<body>
<div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-card">
            <img class="icon" src="assets/avatar.png" alt="Logo" class="logo mb-4">
            <h2 class="text-center mb-4"></h2>
            <form action="../config/proses-login.php" method="POST">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control mb-3" placeholder="Masukkan Username" required>
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Masukkan Password" required>
                <button type="submit" class="btn btn-success w-100">Login</button>
            </form>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>