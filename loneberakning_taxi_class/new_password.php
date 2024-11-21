<?php
include "_config.php";
include "_connect_database.php";

// om submitknappen använts i formuläret används informationen i formulärfälten och kontrolleras mot MySQL-tabellen
if(isset($_POST['new_password'])) {

	// variabeln lagrar information från formuläret som används i MySQL-frågan
	$email = mysql_real_escape_string(trim($_POST['email']));
	// hämtar meddelanden från extern fil
	include "_variables.php";
	// kontrollerar om användaruppgifterna finns i MySQL-tabellen
	$query = mysql_query("SELECT * FROM members WHERE email = '$email' LIMIT 1") or die(mysql_error());

	// visar meddelande om epostadressen inte finns i MySQL-tabellen
	if(mysql_num_rows($query) < 1) {
	echo $validate8;
	echo '<script>history.back(1);</script>';
	exit;
	}

	while($row = mysql_fetch_array($query)) {
		if(mysql_num_rows($query) > 0){
		// funktion som genererar ett lösenord mellan 6 och 10 tecken VERSALT/gement.
		function keygen() {
			$tempstring = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  			for($length = 0; $length < mt_rand(6, 10); $length++) {
			$temp = str_shuffle($tempstring);
			$char = mt_rand(0, strlen($temp));
			$pass .= $temp[$char];
			}
			return $pass;
		}
		$new_password = keygen();
		$password = sha1($new_password);

		// MySQL-frågan som ändrar medlemsuppgifterna
		$update = mysql_query("UPDATE members SET password = '$password' WHERE email = '$email' LIMIT 1") or die(mysql_error());
		// hämtar användaruppgifterna från MySQL-tabellen
		// hämtar meddelanden från extern fil
		include "_variables.php";
		// Mailfunktionen som skickar nytt lösenord
		$send = mail($email , $newpass_mailmessage1 , $newpass_mailmessage2 , $register_mailmessage3);

			// kontrollerar om mail har skickats
			if((($update)&&($send))) {
			// visar meddelande om mail har skickats
			echo $newpass_message1;
			}
				// visar meddelande om mail inte har skickats
				else {
				echo $newpass_message2;
				}
		}
	}
}

else {
// formuläret för nytt lösenord
echo
'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Din webplats - skicka nytt l&ouml;senord</title>
<link href="__mall.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2></h2>
<table align="center">
<td>
<p>Ange den epostadress du anv&auml;nde n&auml;r du registrerade <br>
dig som medlem s&aring; skickas ett nytt tillf&auml;lligt l&ouml;senord <br>
som du anv&auml;nder f&ouml;r att logga in p&aring; ditt konto.</p>
<form action="" method="post">
<table border="0" cellpadding="5" cellspacing="0" bgcolor="#ccff66" >
<tr><td align="right">Epostadress</td><td><input name="email" type="text" size="30" class="skugga"></td></tr>
<tr><td>&nbsp;</td><td><input name="new_password" type="submit" value="Skicka"></td></tr>
</table>
</form>
OBS! Logga in med det nya tillf&auml;lliga l&ouml;senordet och byt <br>
mot ett eget l&ouml;senord f&ouml;r st&ouml;rre s&auml;kerhet.
</td>
</table>
</body>
</html>';
}

// stänger databasen
mysql_close($opendb);
?>