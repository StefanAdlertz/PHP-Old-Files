<?php
// Skapa anslutning mot databasen
$dbh = mysql_connect("host","user","pass")
	or die("Kunde inte ansluta!");
mysql_select_db("db_name");
$orderID = $_GET['orderID'];
$sid = $_GET['confirm'];
$datum = date("Y-m-d H:i:s");

$query = "UPDATE orderhuvud SET bekraftad=1, senast_aktiv='$datum' WHERE orderID=$orderID AND bekraftID='$sid'";
mysql_query($query, $dbh);
mysql_close($dbh);
?>
<html>
<head>
<title>Bekräfta order</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="__mall.css" rel="stylesheet" type="text/css">
</head>

<body>
<h3>Tack! Din order är nu bekräftad!</h3>

</body>
</html>
