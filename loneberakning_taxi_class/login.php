<?php
session_start();
include "_config.php";
include "_connect_database.php";

// om submitknappen använts i loginformuläret används informationen i formulärfälten och kontrolleras mot MySQL-tabellen
if(isset($_POST['login'])) {

	// hämtar meddelanden från extern fil
	include "_variables.php";
	// variablerna lagrar information från formuläret som används i MySQL-frågan
	$username = mysql_real_escape_string(trim($_POST['username']));
	$password = mysql_real_escape_string(trim(sha1($_POST['password'])));

	// kontrollerar om användaruppgifterna finns i MySQL-tabellen
	$query = mysql_query("SELECT * FROM members WHERE username = '$username' AND password = '$password' LIMIT 1") or die(mysql_error());
	$row = mysql_fetch_array($query);

	// kontrollerar om användarkontot finns
	if(mysql_num_rows($query) > 0) {

		// kontrollerar om kontot är aktiverat
		if($row['activated'] > 0) {
		// startar sessioner
		$_SESSION['member_login'] = 'true';
		$_SESSION['member_username'] = $username;
		$_SESSION['member_fnamn'] = $row['fnamn'];
		$_SESSION['member_enamn'] = $row['enamn'];
		$_SESSION['member_email'] = $row['email'];
        $_SESSION['member_provision'] = $row['provision'];
        $_SESSION['member_skatt'] = $row['skatt'];
		// visar den skyddade medlemssidan
		header("Location: index.php");
		}
		// visar meddelande om kontot inte är aktiverat
		else {
		echo $login_message1;
		}
	}
	// visar meddelande om användarkontot inte finns eller om användaruppgifterna är felaktiga
	else {
	echo $validate5;
	echo '<script>history.back(1);</script>';
	}
}

else {
// formuläret som används vid inloggning
 echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Logga in</title>
<link href="__mall.css" rel="stylesheet" type="text/css">
</head>
<body>
<table align="center">
<td>
<form action="" method="post">
<table border="0" cellpadding="5" cellspacing="0" bgcolor="#ccff66">
<tr><td align="right">F&ouml;rar ID</td><td><input  maxlength="6" name="username" type="text" class="skugga"></td></tr>
<tr><td align="right">L&ouml;senord</td><td><input name="password" type="password" class="skugga"></td></tr>
<tr><td>&nbsp;</td><td><input name="login" type="submit" class="button" id="login" value="Logga in"></td></tr>
</table>
</form>
<p>&Auml;r du inte medlem? <a href="register.php">Registrera dig h&auml;r!</a></p>
<p>Gl&ouml;mt ditt l&ouml;senord? <br> <a href="new_password.php">Klicka h&auml;r</a> s&aring; f&aring;r du ett tillf&auml;lligt l&ouml;senord. </p>
<p>(&Auml;r du redan medlem  men har inte <br>f&aring;tt en bekr&auml;ftelse p&aring; din registrering <br>kan du <a href="resend.php">klicka h&auml;r</a> s&aring; skickar vi den p&aring; nytt).</p>
</td>
</table>
</body>
</html>
';
}

// stänger databasen
mysql_close($opendb);
?>