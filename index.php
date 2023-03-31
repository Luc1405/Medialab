<?php
session_start();
include "includes/config.php";
$conn = openCon();

//Check if user is logged in, else move to secure page
if (isset($_SESSION['loggedInUser'])) {
    header("Location: test.php");
    exit;
}

//If form is posted, lets validate!
if (isset($_POST['submit'])) {
    //Retrieve values (email safe for query)
    $email = mysqli_escape_string($conn, $_POST['email']);
    $name = mysqli_escape_string($conn, $_POST['name']);
    $password = mysqli_escape_string($conn, $_POST['password']);

    //Get password & name from DB
    $sql = "SELECT *
              FROM users
              WHERE email = '$email'";
    $result = mysqli_query($conn, $sql) or die('Error: ' . $sql);
    $user = mysqli_fetch_assoc($result);

    //Check if email exists in database
    $errors = [];
    if ($user) {
        //Validate password
        if (password_verify($password, $user['password'])) {
            //Set email for later use in Session
            $_SESSION['loggedInUser'] = [
                'email' => $user['email'],
                'id' => $user['id']
            ];

            //Redirect to secure.php & exit script
            header("Location: test.php");
            exit;
        } else {
            $errors[] = 'Incorrect login data';
        }
    } else {
        $errors[] = 'Incorrect login data';
    }
}
?>
<!-- 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="src/css/styles.css" rel="stylesheet" />
    <title>Medialab</title>
</head>
<body>
<h1>Login</h1>
<form id="login" method="post" action="<?= $_SERVER['REQUEST_URI']; ?>">
    <div>
        <label for="email">E-mail</label>
        <input id="email" name="email" value="<?= (isset($email) ? $email : ''); ?>"/>
    </div>
    <div>
        <label for="password">Wachtwoord</label>
        <input name="password" id="password"/>
    </div>
    <div class="data-submit">
        <input name="submit" type="submit"value="Save"/>
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
                        Login
                    </div>
                    <div class="border">

                    </div>
                    <form class="form" id="login" method="post" action="<?= $_SERVER['REQUEST_URI']; ?>">
                        <div class="email-content">
                            <label class="label" for="email">E-mail:</label>
                            <input class="input" type="text" id="email" name="email">
                        </div>
                        <div class="password-content">
                            <label class="label" for="password">Password:</label>
                            <input class="input" type="password" id="password" name="password">
                        </div>
                        <input class="button" type="submit" value="submit">
                        <a class="link" href="./register.php">Nog geen account? klik dan hier!</a> 
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