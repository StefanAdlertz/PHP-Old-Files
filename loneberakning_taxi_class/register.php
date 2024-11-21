<?php
include "_config.php";
include "_connect_database.php";

// om submitknappen använts i registreringsformuläret bearbetas informationen i formulärfälten och registreras i MySQL-tabellen
if(isset($_POST['submit'])){

	// variablerna lagrar information från formuläret som används i MySQL-frågan, meddelanden och validering av fältinnehåll
	$fnamn = mysql_real_escape_string(trim($_POST["fnamn"]));
	$enamn = mysql_real_escape_string(trim($_POST["enamn"]));
	$username = mysql_real_escape_string(trim($_POST["username"]));
	$email = mysql_real_escape_string(trim($_POST["email"]));
	$pass = mysql_real_escape_string(trim($_POST["password"]));
	$confirm = mysql_real_escape_string(trim($_POST["confirm"]));
	$ip = $_SERVER["REMOTE_ADDR"];
	$date = date("Y-m-d");

	// funktion som genererar ett ord mellan 10 och 20 tecken VERSALT/gement.
	function keygen() {
		$tempstring = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  		for($length = 0; $length < mt_rand(10, 20); $length++) {
		$temp = str_shuffle($tempstring);
		$char = mt_rand(0, strlen($temp));
		$pass .= $temp[$char];
	}
	return $pass;
	}
	// aktiveringsnyckel skapas med hashing av det genererade ordet
	$actkey = keygen();
	$act = sha1($actkey);

	// hämtar meddelanden från extern fil
	include "_variables.php";

	// kontrollerar om lösenord och bekräftelse av lösenord är lika
	if ( $_POST['password'] == $_POST['confirm'] ){}
	else{
	echo $validate1;
	echo '<script>history.back(1);</script>';
	exit;
	}

	// hashing av lösenordet
	$password = mysql_real_escape_string(sha1($pass));

	// kontrollerar om alla formulärfält är ifyllda
	if ((((( empty($fnamn) ) || ( empty($enamn) ) || ( empty($username) ) || ( empty($email) ) || ( empty($pass) ))))) {
	echo $validate2;
	echo '<script>history.back(1);</script>';
	exit;
	}

	// kontrollerar om epostadressen är korrekt angiven
	if((!strstr($email , "@")) || (!strstr($email , "."))) {
	echo $validate3;
	echo '<script>history.back(1);</script>';
	exit;
	}

	// kontrollerar om användarnamnet redan finns i MySQL-tabellen
	$memberquery = mysql_query("SELECT * FROM members WHERE Username = '$username'") or die(mysql_error());
	if(mysql_num_rows($memberquery) > 0) {
	echo $validate4;
	echo '<script>history.back(1);</script>';
	exit;
	}

	// MySQL-frågan som lagrar medlemsuppgifterna
	$query = mysql_query("INSERT INTO members (username, password, fnamn, enamn, email, date, ip, actkey) VALUES ('$username','$password','$fnamn','$enamn','$email','$date','$ip','$act')") or die(mysql_error());
	// Mailfunktionen som skickar bekräftelsen
	$send = mail($email , $register_mailmessage1 , $register_mailmessage2 , $register_mailmessage3);

	// visar meddelande om medlemsregistreringen fungerat och mail skickats
	if(($query)&&($send)){
	echo $register_message1;
	}
		// visar meddelande om medlemsregistreringen eller mailfunktionen inte fungerat
		else {
		echo $register_message2;
		}
}

else {
// formuläret som används vid registrering av ny medlem
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Din webplats - Registrera dig som medlem</title>
<link href="__mall.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2></h2>
<table align="center">
<td class="tbl_lrtb">
<p><br>Registrera dig som medlem genom att fylla i formul&auml;ret.<br>
Du kommer att erh&aring;lla en bekr&auml;ftelse p&aring; registreringen <br>
till din angivna epostadress med uppgifter f&ouml;r inloggning <br>
och aktivering av ditt konto.</p>
<form action="" method="post">
<table border="0" cellpadding="5" cellspacing="0" bgcolor="#ccff66">
<tr><td align="right">F&ouml;rnamn</td><td><input name="fnamn" type="text" class = "skugga" size="30"></td></tr>
<tr><td align="right">Efternamn</td><td><input name="enamn" type="text" class="skugga" size="30"></td></tr>
<tr><td align="right">Epostadress</td><td><input name="email" type="text" class="skugga" size="30"></td></tr>
<tr><td align="right">F&ouml;rar-ID (Riksf&ouml;rarleg)</td><td><input maxlength="6" name="username" type="text" class="skugga" size="6"></td></tr>
<tr><td align="right">L&ouml;senord</td><td><input name="password" type="password" class="skugga" size="15"></td></tr>
<tr><td align="right">Bekr&auml;fta l&ouml;senordet </td><td><input name="confirm" type="password" class="skugga" size="15"></td></tr>
<tr><td align="right">&nbsp;</td><td><input name="submit" type="submit" class="button" value="Skicka uppgifterna"></td></tr>
</table>
</form>
</td>
</table>
</body>
</html>
';
}

// stänger databasen
mysql_close($opendb);
?>
