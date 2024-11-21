<?php
// Starta sessionen
session_start();
// Skapa anslutning mot databasen
$dbh = mysql_connect("host","user","pass")
	or die("Kunde inte ansluta!");
mysql_select_db("db_name");
$orderID = $_GET['orderID'];
$sid = $_GET['confirm'];
$datum = date("Y-m-d H:i:s");
$query = "UPDATE orderhuvud SET status='A', senast_aktiv='#$datum#', bekraftad=0 WHERE orderID=$orderID AND bekraftID='$sid'";
mysql_query($query, $dbh);
mysql_close($dbh);
$_SESSION['orderID'] = $orderID;
header("Location: index.php");
?>
