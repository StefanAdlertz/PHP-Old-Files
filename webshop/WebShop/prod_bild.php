<?php
$id = $_GET['prodID'];
//Kontakta databasen med anv.namn o lösenord
$dbh = mysql_connect("host","user","pass")
	or die("Kunde inte ansluta!");
mysql_select_db("db_name");
//Hämta upp bilden och bildtypen från databasen
$result = mysql_query("SELECT bild, bildtyp FROM produkter WHERE prodID='$id'");
$data = mysql_result($result,0,"bild");
$type = mysql_result($result,0,"bildtyp");
header("Content-type: $type");
echo $data;
?>
