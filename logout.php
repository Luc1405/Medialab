<?php
//Starts session
session_start();
//Ends session
session_unset();
session_destroy();
//Sends back to Index
header("Location: index.php");
exit;
?>