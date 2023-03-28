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
</html>