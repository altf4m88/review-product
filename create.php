<?php

include "config/connection.php";
include "library/app.php";

$app = new App();
$table = 'users';

if(@$_POST['username'] )

$field = array(
    'username' => @$_POST['username'],
    'password' => base64_encode(@$_POST['password'])
);

$redirect = 'index.php';

if (isset($_POST['create'])) {
    $app->create($connect, $table, $field, $redirect);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/lux/bootstrap.min.css" integrity="sha384-9+PGKSqjRdkeAU7Eu4nkJU8RFaH8ace8HGXnkiKMP9I9Te0GJ4/km3L1Z8tXigpG" crossorigin="anonymous">
</head>
<body>
    <div class="container w-100 d-flex justify-content-center align-items-center my-5">
        <div class="card card-lg text-center" style="width: 26rem;">
            <div class="card-body">
                <h5 class="card-title">Create Account</h5>
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" name="create" class="btn btn-success">Create</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
