<?php
include "includes/config.php";
$conn = openC on();
session_start();

$email = '';
$password = '';

if (isset($_POST['submit'])) {
    //Require database in this file & image helpers

    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $errors = [];
    if ($email == '') {
        $errors['email'] = 'The email cannot be empty';
    }
    if ($password == '') {
        $errors['password'] = 'The password cannot be empty';
    }

    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password) VALUES('$email', '$password')";
        $result = mysqli_query($conn, $query)
        or die('Error: ' . $query);

        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Something went wrong in your database query: ' . mysqli_error($conn);
        }

        //Close connection
        mysqli_close($conn);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="src/style.css">
    <title>Document</title>
</head>
<body>
<h2>Nieuwe gebruiker registeren</h2>
<form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
    <div class="data-field">
        <label for="email">E-mail</label>
        <input id="email" value="<?= $email ?>"/>
        <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="name">Name</label>
        <input id="name"/>
        <span class="errors"><?= isset($errors['name']) ? $errors['name'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="password">Password</label>
        <input id="password"/>
        <span class="errors"><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
    </div>
    <div class="data-submit">
        <input type="submit"value="Save"/>
    </div>
</form>
</body>
</html>