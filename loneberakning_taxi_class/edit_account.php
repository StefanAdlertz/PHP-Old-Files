<?php
        session_start();
        if($_SESSION['member_login'] == 'true'){}
        else {header("Location: login.php");}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="__mall.css" rel="stylesheet" type="text/css">
<title>Editera Konto</title>
</head>
<body>

    <?php
        include "_config.php";
        include "_connect_database.php";
        include "_class.php";
        include "_functions.php";
        include "_variables.php";

        begin_main_table();
        top_border();
        menu_border();
        middle_border();

################################################################################

echo "<tr>";
echo "<td height='400' valign='top'>";
echo '<div class="box">
<p>Det h&auml;r &auml;r dina registrerade kontouppgifter.<br>
Anv&auml;nd menyn nedan om du vill &auml;ndra n&aring;gon uppgift.</p>
<p>F&ouml;rar ID: '.$_SESSION['member_username'].'<br />
Namn: '.$_SESSION['member_fnamn'].' '.$_SESSION['member_enamn'].'<br />
Epostadress: '.$_SESSION['member_email'].'<br />
Provision: '.$_SESSION['member_provision'].'%<br />
Skatt: '.$_SESSION['member_skatt'].'%</p>
<p><a href="?change=password">&Auml;ndra l&ouml;senord</a> | <a href="?change=email">&Auml;ndra epostadress</a> | <a href="?change=name">&Auml;ndra namn</a> | <a href="?change=provision">&Auml;ndra provision</a> | <a href="?change=skatt">&Auml;ndra skatt</a> | <a href="?change=account">Avsluta kontot</a></a></p>
';

// villkor som visar formuläret enligt vald meny
switch($_GET['change']){

################################ PASSWORD ######################################

case 'password':
echo '
<form action="" method="post">
<table border="0" cellpadding="5" cellspacing="0" bgcolor="#ccff66">
<tr><td align="right">Nuvarande l&ouml;senord</td><td><input name="current" type="password" class="skugga"></td></tr>
<tr><td align="right">Nytt l&ouml;senord </td><td><input name="new" type="password" class="skugga"></td></tr>
<tr><td align="right">Bekr&auml;fta nytt l&ouml;senord </td><td><input name="confirm" type="password" class="skugga"></td></tr>
<tr><td align="right">&nbsp;</td><td><input type="submit" value="Byt l&ouml;senord" name="change_password" class="button"></td></tr>
</table>
</form>
';
break;

################################ EMAIL #########################################

case 'email':
echo '
<form action="" method="post">
<table border="0" cellpadding="5" cellspacing="0" bgcolor="#ccff66">
<tr><td align="right">Nuvarande epostadress </td><td><input name="current" type="text" class="skugga"></td></tr>
<tr><td align="right">Ny epostadress </td><td><input name="new" type="text" class="skugga"></td></tr>
<tr><td align="right">Bekr&auml;fta ny epostadress </td><td><input name="confirm" type="text" class="skugga"></td></tr>
<tr><td align="right">&nbsp;</td><td><input type="submit" value="Byt epostadress" name="change_email" class="button"></td></tr>
</table>
</form>
';
break;

################################ NAME ##########################################

case 'name':
echo '
<p>OBS! Ange b&aring;de f&ouml;rnamn och efternamn <br>(&auml;ven om bara ett av namnen ska &auml;ndras).</p>
<form action="" method="post">
<table border="0" cellpadding="5" cellspacing="0" bgcolor="#ccff66">
<tr><td align="right">F&ouml;rnamn</td><td><input name="fnamn" type="text" class="skugga"></td></tr>
<tr><td align="right">Efternamn </td><td><input name="enamn" type="text" class="skugga"></td></tr>
<tr><td align="right">&nbsp;</td><td><input name="change_name" type="submit" value="&Auml;ndra namn" class="button"></td></tr>
</table>
</form>
';
break;

################################ ACCOUNT #######################################

case 'account':
echo '
<form action="" method="post">
<table width="500" border="0" cellpadding="5" cellspacing="0" bgcolor="#ccff66">
<tr><td>Klicka p&aring; knappen f&ouml;r att avsluta ditt konto och medlemskap<br>(alla dina registerade uppgifter raderas ur v&aring;r databas).</td></tr>
<tr><td><input type="submit" value="Avsluta mitt konto" name="close_account" class="button"></td></tr>
<tr><td>Vi tackar f&ouml;r den tid du varit medlem hos oss '.$_SESSION['member_fnamn'].'!</td></tr>
</table>
</form>
';
break;

################################ PROVISION #####################################

case 'provision':
echo '
<form action="" method="post">
<table border="0" cellpadding="5" cellspacing="0" bgcolor="#ccff66">
<p>OBS! Du kommer att loggas ut f&ouml;r att &auml;ndringarna skall f&aring; effekt.</p>
<tr><td align="right">Provision:(%) </td><td><input name="provision" type="text" size="3" maxlength="3" class="skugga"></td></tr>
<tr><td align="right">&nbsp;</td><td><input name="change_provision" type="submit" value="&Auml;ndra" class="button"></td></tr>
</table>
</form>
';
break;

################################ SKATT #########################################

case 'skatt':
echo '
<form action="" method="post">
<table border="0" cellpadding="5" cellspacing="0" bgcolor="#ccff66">
<p>OBS! Du kommer att loggas ut f&ouml;r att &auml;ndringarna skall f&aring; effekt.</p>
<tr><td align="right">Skatt:(%) </td><td><input name="skatt" type="text" size="3" maxlength="3"class="skugga"></td></tr>
<tr><td align="right">&nbsp;</td><td><input name="change_skatt" type="submit" value="&Auml;ndra" class="button"></td></tr>
</div>
</table>
</form>
';
break;
}

################################################################################

// IF-satserna nedan utför de val som gjort i formulären som visats med SWITCH-CASE enligt ovan.
// Varje CASE utförs av en egen IF-sats som kontrollerar vilken submit-knapp som använts.
// Använd samma namn som "name" på varje submit-knapp som namn i IF-satsen nedan.

################################ PASSWORD ######################################

if(isset($_POST['change_password'])){
	// variablerna lagrar information från formuläret som används i MySQL-frågan
	$username = $_SESSION['member_username'];
	$current = mysql_real_escape_string(trim($_POST['current']));
	$new = mysql_real_escape_string(trim($_POST['new']));
	$confirm = mysql_real_escape_string(trim($_POST['confirm']));
	// hashing av lösenordet
	$password = sha1($current);
	// kontrollerar om lösenordet finns i MySQL-tabellen
	$query = mysql_query("SELECT * FROM members WHERE password = '$password' LIMIT 1") or die(mysql_error());
	// om lösenordet finns i MySQL-tabellen
	if(mysql_num_rows($query) > 0) {
		while($row = mysql_fetch_array($query)) {
			// kontrollerar om lösenord och bekräftelse av lösenord är lika
			if ( $_POST['new'] == $_POST['confirm'] ){}
				else{
				echo $validate1;
				echo '<script>history.back(1);</script>';
				exit;
				}
			// hashing av lösenordet
			$password_new = sha1($new);
			// MySQL-frågan som ändrar medlemsuppgifterna
			$update = mysql_query("UPDATE members SET password = '$password_new' WHERE username = '$username' LIMIT 1") or die(mysql_error());
			// Mailfunktionen som skickar bekräftelsen
			$send = mail($row['email'] , $edit_mailmessage1 , $edit_mailmessage2 , $register_mailmessage3);
			// visar meddelande om ändringen fungerat och mail skickats
			if((($update)&&($send))) {
			echo $edit_message1;
			echo '<script>location.replace("logout.php");</script>';
			exit;
			}
				else {
				echo $edit_message2;
				echo '<script>location.replace("logout.php");</script>';
				exit;
				}
		}

	}
		else {
		echo $validate6;
		echo '<script>history.back(1);</script>';
		exit;
		}
}

################################ EMAIL #########################################

if(isset($_POST['change_email'])) {
	// variablerna lagrar information från formuläret som används i MySQL-frågan
	$current = mysql_real_escape_string(trim($_POST['current']));
	$new = mysql_real_escape_string(trim($_POST['new']));
	$confirm = mysql_real_escape_string(trim($_POST['confirm']));
	// kontrollerar om epostadressen finns i MySQL-tabellen
	$username= $_SESSION['member_username'];
	$query = mysql_query("SELECT * FROM members WHERE email = '$current' AND username = '$username' LIMIT 1") or die(mysql_error());
	// om epostadressen finns i MySQL-tabellen
	if(mysql_num_rows($query) > 0) {
		while($row = mysql_fetch_array($query)) {
			// kontrollerar om epostadress och bekräftelse av epostadress är lika
			if ( $_POST['new'] == $_POST['confirm'] ) {}
				else{
				echo $validate7;
				echo '<script>history.back(1);</script>';
				exit;
				}
			// kontrollerar om epostadressen är korrekt angiven
			if((!strstr($new , "@")) || (!strstr($new , "."))) {
			echo $validate3;
			echo '<script>history.back(1);</script>';
			exit;
			}
			// MySQL-frågan som ändrar medlemsuppgifterna
			$update = mysql_query("UPDATE members SET email = '$new' WHERE email = '$current' LIMIT 1") or die(mysql_error());
			// Mailfunktionen som skickar bekräftelsen
			$send = mail($new , $edit_mailmessage3 , $edit_mailmessage4 , $register_mailmessage3);
			$send = mail($current , $edit_mailmessage3 , $edit_mailmessage4 , $register_mailmessage3);
			// visar meddelande om ändringen fungerat och mail skickats
			if((($update)&&($send))) {
			echo $edit_message3;
			echo '<script>location.replace("logout.php");</script>';
			exit;
			}
				else {
				echo $edit_message4;
				echo '<script>location.replace("logout.php");</script>';
				exit;
				}
			}
	}
		else {
		echo $validate8;
		echo '<script>history.back(1);</script>';
		exit;
		}
}

################################ NAME ##########################################

if(isset($_POST['change_name'])) {
	// variablerna lagrar information från formuläret som används i MySQL-frågan
	$username = $_SESSION['member_username'];
	$fnamn = mysql_real_escape_string(trim($_POST['fnamn']));
	$enamn = mysql_real_escape_string(trim($_POST['enamn']));
	// kontrollerar om användarnamnet finns i MySQL-tabellen
	$query = mysql_query("SELECT * FROM members WHERE username = '$username' LIMIT 1") or die(mysql_error());
	// om epostadressen finns i MySQL-tabellen
	if(mysql_num_rows($query) > 0) {
		while($row = mysql_fetch_array($query)) {
			// kontrollerar om alla formulärfält är ifyllda
			if (( empty($fnamn) ) || ( empty($enamn) )) {
			echo $validate2;
			echo '<script>history.back(1);</script>';
			exit;
			}
			// MySQL-frågan som ändrar medlemsuppgifterna
			$update = mysql_query("UPDATE members SET fnamn = '$fnamn' WHERE username = '$username' LIMIT 1") or die(mysql_error());
			$update = mysql_query("UPDATE members SET enamn = '$enamn' WHERE username = '$username' LIMIT 1") or die(mysql_error());
			// Mailfunktionen som skickar bekräftelsen
			$send = mail($row['email'] , $edit_mailmessage5 , $edit_mailmessage6 , $register_mailmessage3);
			// visar meddelande om ändringen fungerat och mail skickats
			if((($update)&&($send))) {
			echo $edit_message7;
			echo '<script>location.replace("logout.php");</script>';
			exit;
			}
				else {
				echo $edit_message4;
				echo '<script>location.replace("logout.php");</script>';
				exit;
				}
			}
	}
}

################################ ACCOUNT #######################################

if(isset($_POST['close_account'])) {
	// variablerna lagrar information från formuläret som används i MySQL-frågan
	$username = $_SESSION['member_username'];
	// MySQL-frågan som ändrar medlemsuppgifterna
	$close = mysql_query("DELETE FROM members WHERE username = '$username' LIMIT 1") or die(mysql_error());
	// visar meddelande om ändringen fungerat och mail skickats
	if($close) {
	echo $edit_message5;
	echo '<script>location.replace("logout.php");</script>';
	exit;
	}
		else {
		echo $edit_message6;
		echo '<script>history.back(1);</script>';
		exit;
		}
}

################################ PROVISION #####################################

if(isset($_POST['change_provision'])) {
        $username  = $_SESSION['member_username'];
        $provision = $_POST['provision'];
        $update    = mysql_query("update members
        set
        provision='$provision'
        where username='$username';")
        or die("Kunde inte redigera provision:<br />" . mysql_error());
        mysql_close($opendb);
        echo '<script>location.replace("logout.php");</script>';
}

################################ SKATT #########################################

if(isset($_POST['change_skatt'])) {
        $username  = $_SESSION['member_username'];
        $skatt     = $_POST['skatt'];
        $update    = mysql_query("update members
        set
        skatt='$skatt'
        where username='$username';")
        or die("Kunde inte redigera skatt:<br />" . mysql_error());
        mysql_close($opendb);
        echo '<script>location.replace("logout.php");</script>';
}

################################################################################

// HTML-sidans avslut
echo "</td>";
echo "</tr>";

################################################################################

        bottom_border();
        end_main_table();
      ?>

</body>
</html>
