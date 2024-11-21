<?php

// validering och kontroll av angiven information i formulärfält
$validate1 = utf8_decode('<script>alert("Ditt lösenord är inte lika i lösenords- och bekräftelsefält. \n Ange samma lösenord i båda fälten!");</script>');
$validate2 = utf8_decode('<script>alert("Ett eller flera fält är inte ifyllda. \n Ange information i alla fält innan du skickar formuläret igen!");</script>');
$validate3 = utf8_decode('<script>alert("Du har angivit en felaktig epostadress! \nAnge epostadressen igen.");</script>');
$validate4 = utf8_decode('<script>alert("Ditt användarnamn är upptaget! Välj ett annan användarnamn. \n\n(Om du är medlem sedan tidigare kan du begära ett nytt lösenord om du glömt detta).");</script>');
$validate5 = utf8_decode('<script>alert("Du har angivit fel användarnamn eller lösenord! \nAnge dina kontouppgifter på nytt. \n\n(Om du glömt ditt lösenord kan du begära ett nytt).");</script>');
$validate6 = utf8_decode('<script>alert("Du har angivit fel lösenord!");</script>');
$validate7 = utf8_decode('<script>alert("Din epostadress är inte lika i epost- och bekräftelsefält. \n Ange samma epostadress i båda fälten!");</script>');
$validate8 = utf8_decode('<script>alert("Den epostadress du angivit finns inte i vårt medlemsregister!\n\nKontrollera om du angivit rätt epostadress.");</script>');

// REGISTER.PHP - meddelande till registeringssidan
$register_message1 = utf8_decode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Din webplats - du &auml;r nu registrerad!</title>
		<link href="__mall.css" rel="stylesheet" type="text/css">
		</head>
		<body>
		<table width="500" border="0" cellpadding="5" cellspacing="0" class="td">
		<tr><td bgcolor="#ccff66"><h2>V&auml;lkommen ' .$fnamn.'! </h2></td></tr>
		<tr><td><p>Du &auml;r registrerad som ny medlem p&aring; Din webplats och har nu tillg&aring;ng till v&aring;ra medlemssidor. </p>
		<p>OBS! Innan du kan logga in med dina anv&auml;ndaruppgifter m&aring;ste du <strong>aktivera</strong> ditt anv&auml;ndarkonto enligt de instruktioner du f&aring;tt i den bekr&auml;ftelse som nu skickats till din epostadress.</p>
		<p>(Om du redan aktiverat ditt konto kan du <a href="login.php">klicka h&auml;r</a> f&ouml;r att logga in)</p></td></tr>
		</table>
		</body>
		</html>');

$register_message2 = utf8_decode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Din webplats - du &auml;r nu registrerad!</title>
		<link href="__mall.css" rel="stylesheet" type="text/css">
		</head>
		<body>
		<table width="500" border="0" cellpadding="5" cellspacing="0" class="td">
		<tr><td bgcolor="#ccff66"><h2>Fel vid registreringen!</h2></td></tr>
		<tr><td><p>Registreringen av ditt medlemskonto har inte genomf&ouml;rts som planerat. Det beror f&ouml;rmodligen p&aring; ett tillf&auml;lligt fel och vi beklagar detta... Informationen du angav har sparats och du kan prova att <a href="login.php">logga in</a> om n&aring;gra minuter.</p>
		<p>Dina anv&auml;ndaruppgifter &auml;r sparade:<br>
	    Anv&auml;ndarnamn: <strong>'.$username.'</strong><br>
	    Epostadress: <strong>'.$email.'</strong><br></p>
		</td></tr>
		</table>
		</body>
		</html>');

$register_mailmessage1 = utf8_decode("Du är nu medlem hos Din webplats!");
$register_mailmessage2 = utf8_decode("Tack för att du registrerat dig som medlem hos Din webplats.\n\nDina uppgifter för inloggning har du angivit enligt nedan.\n\nNamn: ".$fnamn." ".$enamn."\nEpostadress: ".$email."\nAnvändarnamn: ".$username."\nLösenord: ".$pass."\n\nVIKTIGT! Innan du kan logga in måste du aktivera ditt medlemskonto genom att klicka på länken nedan:\nhttp://www.adlertz.se/loneberakning_taxi_class/activate.php?id=".$act." \n(Om länken inte fungerar kan du kopiera och klistra in länken i din webläsares adressfält) \n\nOBS! Du kan inte svara på detta meddelande då det är ett automatiskt utskick. \n\nMedlemsregistret \nwww.adlertz.se/loneberakning_taxi_class");
$register_mailmessage3 = utf8_decode("FROM: register@adlertz.se/loneberakning_taxi_class");

// ACTIVATE.PHP - meddelande till aktiveringssidan
$activate_message1 = utf8_decode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Din webplats - ditt konto &auml;r aktiverat!</title>
		<link href="__mall.css" rel="stylesheet" type="text/css">
		</head>
		<body>
		<table width="500" border="0" cellpadding="5" cellspacing="0" class="td">
		<tr><td bgcolor="#ccff66"><h2>Ditt konto &auml;r nu aktiverat! </h2></td></tr>
		<tr><td><p>Du kan nu logga in p&aring; ditt konto genom att  <a href="login.php">klicka h&auml;r</a></p>
		<p>(En bekr&auml;ftelse p&aring; aktiveringen har &auml;ven skickats till din  epostadress)</p></td></tr>
		</table>
		</body>
		</html>');

$activate_message2 = utf8_decode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Din webplats - fel vid aktiveringen av ditt konto...</title>
			<link href="__mall.css" rel="stylesheet" type="text/css">
			</head>
			<body>
			<table width="500" border="0" cellpadding="5" cellspacing="0" class="td">
			<tr><td bgcolor="#ccff66"><h2>Fel vid aktiveringen!</h2></td></tr>
			<tr><td><p>Aktiveringen av ditt medlemskonto har misslyckats. Det beror f&ouml;rmodligen p&aring; ett tillf&auml;lligt fel och vi beklagar detta...</p>
			<p>G&ouml;r ett nytt f&ouml;rs&ouml;k att aktivera ditt konto om n&aring;gra minuter. </p></td></tr>
			</table>
			</body>
			</html>');

$activate_message3 = utf8_decode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Din webplats - fel vid aktiveringen av ditt konto...</title>
			<link href="__mall.css" rel="stylesheet" type="text/css">
			</head>
			<body>
			<table width="500" border="0" cellpadding="5" cellspacing="0" class="td">
			<tr><td bgcolor="#ccff66"><h2>Fel vid aktiveringen!</h2></td></tr>
			<tr><td><p>Aktiveringen av ditt medlemskonto har misslyckats. Den aktiveringskod du anv&auml;nt &auml;r felaktig.</p></td></tr>
			</table>
			</body>
			</html>');

$activate_mailmessage1 = utf8_decode("Ditt medlemskonto är aktiverat!");
$activate_mailmessage2 = utf8_decode("Ditt medlemskonto med användarnamnet: ".$row['username']." är nu aktiverat och klart att användas.\n\nLogga in genom att klicka på länken nedan:\nhttp://www.adlertz.se/loneberakning_taxi_class/login.php \n(Om länken inte fungerar kan du kopiera och klistra in länken i din webläsares adressfält) \n\nOBS! Du kan inte svara på detta meddelande då det är ett automatiskt utskick. \n\nMedlemsregistret \nwww.adlertz.se/loneberakning_taxi_class");


// LOGIN.PHP - meddelande till inloggningssidan
$login_message1 = utf8_decode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Din webplats - aktivera ditt konto innan inloggning</title>
			<link href="__mall.css" rel="stylesheet" type="text/css">
			</head>
			<body>
			<table width="500" border="0" cellpadding="5" cellspacing="0" class="td">
			<tr><td bgcolor="#ccff66"><h2>Ditt konto &auml;r inte aktiverat!</h2></td></tr>
			<tr><td><p>Innan du kan logga in m&aring;ste du <strong>aktivera</strong> ditt anv&auml;ndarkonto enligt de instruktioner du f&aring;tt i den bekr&auml;ftelse som nu skickats till din  epostadress.</p>
			<p>(Om du inte f&aring;tt n&aring;gon bekr&auml;ftelse kan du <a href="resend.php">klicka h&auml;r</a> f&ouml;r att skicka bekr&auml;ftelsen p&aring; nytt)</p></td></tr>
			</table>
			</body>
			</html>');

// RESEND.PHP - meddelande till sidan som skickar den nya aktiveringslänken
$resend_mailmessage1 = utf8_decode("Aktiveringsuppgifter för ditt konto på Din webplats");
$resend_mailmessage2 = utf8_decode("Här är den nya aktiveringslänken för att aktivera ditt medlemskonto. Klicka på länken nedan:\nhttp://www.adlertz.se/loneberakning_taxi_class/activate.php?id=".$actkey."\n\nOBS! Du kan inte svara på detta meddelande då det är ett automatiskt utskick. \n\nMvh\n\n//Medlemsregistret \nwww.adlertz.se/loneberakning_taxi_class");

$resend_message1 = utf8_decode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Din webplats - ny aktiveringsl&auml;nk &auml;r nu skickad!</title>
			<link href="__mall.css" rel="stylesheet" type="text/css">
			</head>
			<body>
			<table width="500" border="0" cellpadding="5" cellspacing="0" class="td">
			<tr><td bgcolor="#ccff66"><h2>Ny aktiveringsl&auml;nk &auml;r skickad! </h2></td></tr>
			<tr><td><p>Ett epostmeddelande med den nya aktiveringsl&auml;nken &auml;r skickad. </p>
  			<p>N&auml;r du aktiverat ditt konto genom att klicka p&aring; aktiveringslänken i epostmeddelandet kan du logga in p&aring; ditt konto genom att  <a href="login.php">klicka h&auml;r</a></p>
  			</td></tr>
			</table>
			</body>
			</html>');

$resend_message2 = utf8_decode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<title>Din webplats - tillf&auml;lligt fel</title>
				<link href="__mall.css" rel="stylesheet" type="text/css">
				</head>
				<body>
				<table width="500" border="0" cellpadding="5" cellspacing="0" class="td">
				<tr><td bgcolor="#ccff66"><h2>Tillf&auml;lligt fel!</h2></td></tr>
				<tr><td><p>Vi kunde inte skicka aktiveringsl&auml;nken till ditt medlemskonto. Det beror f&ouml;rmodligen p&aring; ett tillf&auml;lligt fel och vi beklagar detta...</p>
				 <p>G&ouml;r ett nytt f&ouml;rs&ouml;k igen  om n&aring;gra minuter.</p></td></tr>
				</table>
				</body>
				</html>');

// NEW_PASSWORD.PHP -  meddelande till sidan som skickar det nya lösenordet
$newpass_mailmessage1 = utf8_decode("Nytt lösenord för ditt konto på Din webplats");
$newpass_mailmessage2 = utf8_decode("Här är det nya lösenordet till ditt medlemskonto. \n\nAnvändarnamn: ".$row['username']."\nLösenord: ".$new_password." \n\nOBS! Du bör byta det tillfälliga lösenordet till ett eget för större säkerhet. Logga in på ditt medlemskonto och välj menyn \"Redigera dina kontouppgifter\" för att ange ett eget nytt lösenord. \n\nLogga in genom att klicka på länken nedan:\nhttp://www.adlertz.se/loneberakning_taxi_class/login.php \n(Om länken inte fungerar kan du kopiera och klistra in länken i din webläsares adressfält) \n\nOBS! Du kan inte svara på detta meddelande då det är ett automatiskt utskick. \n\nMedlemsregistret \nwww.adlertz.se/loneberakning_taxi_class");

$newpass_message1 = utf8_decode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Din webplats - nytt l&ouml;senord &auml;r nu skickat!</title>
			<link href="__mall.css" rel="stylesheet" type="text/css">
			</head>
			<body>
			<table width="500" border="0" cellpadding="5" cellspacing="0" class="td">
			<tr><td bgcolor="#ccff66"><h2>Nytt l&ouml;senord &auml;r nu skickat! </h2></td></tr>
			<tr><td><p>Ett epostmeddelande med det nya l&ouml;senordet &auml;r skickat. </p>
			<p>OBS! Du b&ouml;r byta det tillf&auml;lliga l&ouml;senordet mot ett eget l&ouml;senord f&ouml;r st&ouml;rre s&auml;kerhet. Logga in p&aring; ditt medlemskonto med det nya l&ouml;senordet och v&auml;lj menyn &quot;Redigera dina kontouppgifter&quot; f&ouml;r att byta till nytt eget l&ouml;senord.</p>
  			<p>Logga in p&aring; ditt konto med ditt nya l&ouml;senord genom att <a href="login.php">klicka h&auml;r</a></p>
  			</td></tr>
			</table>
			</body>
			</html>');

$newpass_message2 = utf8_decode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<title>Din webplats - tillf&auml;lligt fel</title>
				<link href="__mall.css" rel="stylesheet" type="text/css">
				</head>
				<body>
				<table width="500" border="0" cellpadding="5" cellspacing="0" class="td">
				<tr><td bgcolor="#ccff66"><h2>Tillf&auml;lligt fel!</h2></td></tr>
				<tr><td><p>Vi kunde inte skicka l&ouml;senordet till din epostadress. Det beror f&ouml;rmodligen p&aring; ett tillf&auml;lligt fel och vi beklagar detta...</p>
				 <p>G&ouml;r ett nytt f&ouml;rs&ouml;k igen om n&aring;gra minuter.</p></td></tr>
				</table>
				</body>
				</html>');

// EDIT_ACCOUNT.PHP - meddelande till sidan för kontohantering
$edit_message1 = utf8_decode('<script>alert("Ditt lösenord är ändrat (du kommer nu att loggas ut), logga in med ditt nya lösenord!\n\nEn bekräftelse med ditt nya lösenord har även skickats till din epostadress.");</script>');
$edit_message2 = utf8_decode('<script>alert("Dina uppgifter har inte bearbetats då scriptet inte kunnat köras.\nDetta kan vara ett tillfälligt fel och ändring av ditt lösenord \nkan ha utförts även om du inte fått meddelande om detta.\n\nDu kommer nu att loggas ut. Prova att logga in igen med ditt nya eller gamla lösenord.");</script>');
$edit_message3 = utf8_decode('<script>alert("Din epostadress är ändrad och du kommer nu att loggas ut. \nLogga in på nytt!\n\nEn bekräftelse har skickats både till din nya och tidigare epostadress.");</script>');
$edit_message4 = utf8_decode('<script>alert("Dina uppgifter har inte bearbetats då scriptet inte kunnat köras.\nDetta kan vara ett tillfälligt fel och ändring av din epostadress \nkan ha utförts även om du inte fått meddelande om detta.\n\nDu kommer nu att loggas ut. Prova att logga in igen och kontrollera om dina kontouppgifter ändrats.");</script>');
$edit_message5 = utf8_decode('<script>alert("Ditt medlemskonto är nu avslutat och vi tackar för den tid du varit medlem hos oss! \n\n Du kommer nu att loggas ut för sista gången  :-)");</script>');
$edit_message6 = utf8_decode('<script>alert("Ditt medlemskonto har INTE avslutats då scriptet inte kunnat köras.\nDetta kan vara ett tillfälligt fel och du kan prova igen om några minuter...");</script>');
$edit_message7 = utf8_decode('<script>alert("Dina namnuppgifter är ändrade och du kommer nu att loggas ut. \nLogga in på nytt!\n\nEn bekräftelse har skickats till din epostadress.");</script>');

$edit_mailmessage1 = utf8_decode("Ditt lösenord är ändrat!");
$edit_mailmessage2 = utf8_decode("Du har gjort en ändring av uppgifterna i ditt medlemskonto. \n\nDetta är en bekräftelse på att du ändrat ditt lösenord till: ".trim($_POST['new'])."\n\nLogga in genom att klicka på länken nedan:\nhttp://www.adlertz.se/loneberakning_taxi_class/login.php \n(Om länken inte fungerar kan du kopiera och klistra in länken i din webläsares adressfält) \n\nOBS! Du kan inte svara på detta meddelande då det är ett automatiskt utskick. \n\nMedlemsregistret \nwww.adlertz.se/loneberakning_taxi_class");
$edit_mailmessage3 = utf8_decode("Din epostadress är ändrad!");
$edit_mailmessage4 = utf8_decode("Du har gjort en ändring av uppgifterna i ditt medlemskonto. \n\nDetta är en bekräftelse på att du ändrat din epostadress till: ".trim($_POST['new'])."\n\nLogga in genom att klicka på länken nedan:\nhttp://www.adlertz.se/loneberakning_taxi_class/login.php \n(Om länken inte fungerar kan du kopiera och klistra in länken i din webläsares adressfält) \n\nOBS! Du kan inte svara på detta meddelande då det är ett automatiskt utskick. \n\nMedlemsregistret \nwww.adlertz.se/loneberakning_taxi_class");
$edit_mailmessage5 = utf8_decode("Dina namnuppgifter är ändrade!");
$edit_mailmessage6 = utf8_decode("Du har gjort en ändring av dina namnuppgifter för ditt medlemskonto. \n\nDetta är en bekräftelse på att du ändrat ditt namn till: ".trim($_POST['fnamn'])." ".trim($_POST['enamn'])."\n\nLogga in genom att klicka på länken nedan:\nhttp://www.adlertz.se/loneberakning_taxi_class/login.php \n(Om länken inte fungerar kan du kopiera och klistra in länken i din webläsares adressfält) \n\nOBS! Du kan inte svara på detta meddelande då det är ett automatiskt utskick. \n\nMedlemsregistret \nwww.adlertz.se/loneberakning_taxi_class");


?>