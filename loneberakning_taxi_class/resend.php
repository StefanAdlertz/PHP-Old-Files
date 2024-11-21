<?php
include "_config.php";
include "_connect_database.php";

// om submitknappen använts i formuläret används informationen i formulärfälten och kontrolleras mot MySQL-tabellen
if(isset($_POST['resend'])) {

	// variabeln lagrar information från formuläret som används i MySQL-frågan
	$email = mysql_real_escape_string(trim($_POST['email']));
	// hämtar meddelanden från extern fil
	include "_variables.php";
	// kontrollerar om användaruppgifterna finns i MySQL-tabellen
	$query = mysql_query("SELECT actkey FROM members WHERE email = '$email' LIMIT 1") or die(mysql_error());

	// visar meddelande om epostadressen inte finns i MySQL-tabellen
	if(mysql_num_rows($query) < 1) {
	echo $validate8;
	echo '<script>history.back(1);</script>';
	exit;
	}

	while($row = mysql_fetch_array($query)) {

		if(mysql_num_rows($query) > 0){
		// variabel som lagrar värdet för aktiveringsnyckeln
		$actkey = $row['actkey'];
		// hämtar meddelanden från extern fil
		include "variables.php";
		// Mailfunktionen som skickar aktiveringslänken
		$send = mail($email , $resend_mailmessage1 , $resend_mailmessage2 , $register_mailmessage3);

			// kontrollerar om mail har skickats
			if($send) {
			// visar meddelande om mail har skickats
			echo $resend_message1;
			}
				// visar meddelande om mail inte har skickats
				else {
				echo $resend_message2;
				}
		}
	}
}

else {
// formuläret för ny aktiveringslänk
echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Din webplats - skicka ny aktiveringsl&auml;nk</title>
<link href="__mall.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2></h2>
<table>
<td>
<p>Ange den epostadress du anv&auml;nde n&auml;r du registrerade <br>
dig som medlem s&aring; skickas en ny aktiveringsl&auml;nk som du <br>
anv&auml;nder f&ouml;r att aktivera ditt konto. </p>
<form action="" method="post">
<table border="0" cellpadding="5" cellspacing="0" bgcolor="#ccff66" >
<tr><td align="right">Epostadress</td><td><input name="email" type="text" size="30" class="skugga"></td></tr>
<tr><td>&nbsp;</td><td><input name="resend" type="submit" class="button" id="resend" value="Skicka"></td></tr>
</table>
</form>
</td>
</table>
</body>
</html>';
}

// stänger databasen
mysql_close($opendb);
?>