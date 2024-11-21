<?php
include "_config.php";
include "_connect_database.php";

// hämtar meddelanden från extern fil
include "_variables.php";

// hämtar ID från webläsarens URL
$id = mysql_real_escape_string($_GET['id']);

// MySQL-frågan som kontrollerar aktiveringsnyckeln i webläsarens URL
$query = mysql_query("SELECT * FROM members WHERE actkey = '$id' LIMIT 1") or die(mysql_error());
$row = mysql_fetch_array($query);

// kontrollerar om aktiveringsnyckeln finns i MySQL-tabellen
if(mysql_num_rows($query) > 0){
	// hämtar meddelanden från extern fil
	include "_variables.php";
	// hämtar ID från array och lagra i variabel
	$user = $row['id'];
	// MySQL-frågan som anger att aktivering är utförd
	$do = mysql_query("UPDATE members SET activated = 1 WHERE id = '$user' LIMIT 1") or die(mysql_error());
	// Mailfunktionen som skickar bekräftelsen
	$send = mail($row['email']  , $activate_mailmessage1 , $activate_mailmessage2 , $register_mailmessage3);

	// visar meddelande om aktiveringen fungerat och mail skickats
	if(($do)&&($send)) {
	echo $activate_message1;
	}
		// visar meddelande om aktiveringen eller mailfunktionen inte fungerat
		else {
		echo $activate_message2;
		}
}

// visar meddelande om aktiveringskoden är felaktig
else {
echo $activate_message3;
}

// stänger databasen
mysql_close($opendb);
?>