<?php
include "includes/config.php";
$conn = openCon();
session_start();

$email = '';
$name = '';
$password = '';

if (isset($_POST['submit'])) {
    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $name = $_POST['name'];

    $errors = [];
    if ($email == '') {
        $errors['email'] = 'The email cannot be empty';
    }
    if ($password == '') {
        $errors['password'] = 'The password cannot be empty';
    }
    if ($name == '') {
        $errors['name'] = 'The name cannot be empty';
    }

    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `users` (email, name, password) VALUES('$email', '$name', '$password')";
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
<!-- <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="src/css/style.css">
    <title>Document</title>
</head>
<body>
<h2>Nieuwe gebruiker registeren</h2>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="data-field">
        <label for="email">E-mail</label>
        <input id="email" name="email" value="<?= $email ?>"/>
        <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="name">Name</label>
        <input name="name" id="name"/>
        <span class="errors"><?= isset($errors['name']) ? $errors['name'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="password">Password</label>
        <input name="password" id="password"/>
        <span class="errors"><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
    </div>
    <div class="data-submit">
        <input name="submit" type="submit" value="Save"/>
    </div>
</form>
</body>
</html> -->

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link href="src/css/reset.css" rel="stylesheet" />
        <link href="src/css/styles.css" rel="stylesheet" />
        <link href="src/css/footer.css" rel="stylesheet" />

          <!-- font awesome icons -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js"
        integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe"
        crossorigin="anonymous"></script>

        <title>Medialab - planner</title>
    </head>
    <body>
        <nav class="nav">
            <img class="logo" src="src/images/logo.png" />
            <div class="btn-div">
                <a class="button" href="/"> Logout </a>
            </div>
        </nav>
        <div class="big-container">
            <div class="line">
            </div>
            <div class="main">
                <div class="content">
                    <div class="titel">
                        Maak een account aan
                    </div>
                    <div class="border">

                    </div>
                    <form class="form" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="email-content">
                            <label class="label" for="email">E-mail:</label>
                            <input class="input" type="text" id="email" name="email">
                            <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
                        </div>
                        <div class="password-content">
                            <label class="label" for="password">Password:</label>
                            <input class="input" type="password" id="password" name="password">
                            <span class="errors"><?= isset($errors['password']) ? $errors['password'] : '' ?></span>
                        </div>
                        <div class="name-content">
                            <label class="label" for="name">Naam:</label>
                            <input class="input" type="text" id="name" name="name">
                            <span class="errors"><?= isset($errors['name']) ? $errors['name'] : '' ?></span>
                        </div>
                        <input class="button" type="submit" value="Aanmaken"> 
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <div class="rounded-social-buttons">
                <a class="social-button facebook" href="https://www.facebook.com/" target="_blank"><i
                        class="fab fa-facebook-f"></i></a>
                <a class="social-button twitter" href="https://www.twitter.com/" target="_blank"><i
                        class="fab fa-twitter"></i></a>
                <a class="social-button linkedin" href="https://www.linkedin.com/" target="_blank"><i
                        class="fab fa-linkedin"></i></a>
                <a class="social-button youtube" href="https://www.youtube.com/" target="_blank"><i
                        class="fab fa-youtube"></i></a>
                <a class="social-button instagram" href="https://www.instagram.com/" target="_blank"><i
                        class="fab fa-instagram"></i></a>
            </div>
        </footer>
    </body>
</html>