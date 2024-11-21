<?php
// startar sessionen
session_start();

// avslutar alla sessioner när användaren loggar ut
$_SESSION["member_login"] = '';
$_SESSION["member_username"] = '';
$_SESSION["member_fnamn"] = '';
$_SESSION["member_enamn"] = '';
$_SESSION["member_email"] = '';
session_destroy();

// när utloggningen är klar visas loginsidan igen
header("Location: login.php");
?>