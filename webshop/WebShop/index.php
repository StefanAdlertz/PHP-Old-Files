<?php
// Slå på output buffering så vi kan göra redirect även efter header har skickats
ob_start();
// Aktivera sessioner
session_start();
// Skapa anslutning mot databasen
$dbh = mysql_connect("host","user","pass")
	or die("Kunde inte ansluta!");
mysql_select_db("db_name");

// Kolla om varukorgen ska tömmas
if ($_GET['op']=="tabortorder") {
	TabortOrder();
	Header("Location: index.php");
}
?>
<html>
<head>
<title>Webshopen</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="__mall.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function FormularData(op,prodID,antal) {
	varukorg.op.value = op;
	varukorg.prodID.value = prodID;
	varukorg.antal.value = antal;
	varukorg.submit();
}

function TomVarukorg() {
	if (confirm("Vill du verkligen tömma varukorgen?")) {
		varukorg_hantering.op.value = 'tabortorder';
		varukorg_hantering.submit();
	}
}

function SkickaVarukorg() {
	if (confirm("Vill du skicka din order?")) {
		varukorg_hantering.op.value = 'skickaorder';
		varukorg_hantering.submit();
	}
}
</script>
</head>

<body>
<table class="maintable" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="t_border" colspan="2" align="right" valign="bottom"><?php DoTop();?></td>
  </tr>
  <tr>
    <td class="td_left" align="left" valign="top"><?php DoLeft();?></td>
    <td width="650" align="left" valign="top"><?php DoMain();?></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="middle"><?php DoBottom();?></td>
  </tr>
</table>
</body>
</html>

<?php
mysql_close($dbh);

function DoTop() {

	if (!empty($_SESSION['orderID'])) {
		if (AntalKorgen()!=0) {
//            ".AntalKorgen()."
			echo "Du har varor i varukorgen | Gå till varukorgen &raquo\n";
			echo "<a href=\"index.php?op=visa_korg\"><img src='images/goto_cart.png' width='15' height='15' border='0' alt='Gå till varukorgen'></</a>\n";
            echo "&nbsp;";
		} else {
			echo "Inga varor i varukorgen &nbsp;";
		}
	} else {
		echo "Inga varor i varukorgen &nbsp;";
	}
}

function DoLeft() {
	global $dbh;
	// Lista upp alla kategorier
	$query = "SELECT * FROM kategorier ORDER BY kategori";
	$result = mysql_query($query, $dbh);
	while ($rad=mysql_fetch_array($result)) {
		echo "<b><a href=\"index.php?kat=".$rad['kategoriID']."\">".$rad['kategori']."</a></b><br>\n";
	}
}

function DoMain() {
	include "__functions.php";
        $op = $_GET['op'];
	switch($op) {
		case "lagg_till":
			LaggTillVara();
			break;
		case "visa_korg":
			VisaKorgen();
			break;
		case "andra":
			AndraAntal();
			break;
		case "tabort":
			TabortProdukt();
			break;
		case "skickaorder":
			VisaOrderuppgifter();
			break;
		case "skickaorder2":
			SkickaOrder();
			break;
		case "tack":
			VisaTack();
			break;
		default:
			VisaProdukter();
	}
}

function DoBottom() {
        echo "<tr>";
        echo "<td colspan='3'>";
        echo "<table class='b_border' border='0' cellpadding='0' cellspacing='0'>";
        echo "<tr>";
        echo "<td class='b_border'></td>";
        echo "</tr>";
        echo "</table>";
        echo "</tr>";
}

function AntalKorgen() {
	global $dbh;
	// Returnerar antal varor i varukorgen
	$query = "SELECT COUNT(*) FROM orderrad WHERE orderID=".$_SESSION['orderID'];
	$result = mysql_query($query, $dbh);
	return mysql_result($result, 0, 0);
}
?>
