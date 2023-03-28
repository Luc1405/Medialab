<?php
function openCon()
{
    $dbHost = "localhost"; //host of server
    $dbUser = "root"; //user
    $dbPass = ""; //password of user
    $db = "data"; //name of database

//Connecting to the database
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $db) or die("Connect Failed; %s\n" .
        $conn->error);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo "Connected Failed" . "<br>";

    }
    return $conn;
}

// closing connection to database
function closeCon($conn)
{
    $conn->close();
}
?>