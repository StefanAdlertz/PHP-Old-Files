<?php
// Inloggninsinformationen, enkelt men inte allt för säkert sätt...
define("ANVANDARE", "webshop");
define("LOSEN", "webshop");

ob_start();
session_start();
$dbh = mysql_connect("host","user","pass")
	or die("Kunde inte ansluta!");
mysql_select_db("db_name");

?>
<html>
<head>
<title>Administrationssida</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="__mall.css" rel="stylesheet" type="text/css">
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

function DoMain() {
    include "__functions.php";
    if ($_SERVER['REQUEST_METHOD']=="GET") {
        $op = $_GET['op'];
    } else {
        $op = $_POST['op'];
    }
    switch($op) {
        case "kat_ny":
            NyKategori();
            break;
        case "kat_redigera":
            RedigeraKategori();
            break;
        case "prod_ny":
            NyProdukt();
            break;
        case "prod_redigera":
            RedigeraProdukt();
            break;
        case "order_visa":
            VisaOrderNya();
            break;
        case "order_visa_skickad":
            VisaOrderSkickad();
            break;
        case "order_visa_betald":
            VisaOrderBetald();
            break;
        case "order_visa_makulerad":
            VisaOrderMakulerad();
            break;
        default:
            VisaMeny();
}
}

function DoTop() {

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

function DoLeft() {
        if ($_SESSION['inloggad']=='1') {

		echo "<b><a href=\"admin.php?op=kat_ny\">Kategori - Ny</a></b>\n";
        echo "<br>\n";
		echo "<b><a href=\"admin.php?op=kat_redigera\">Kategori - Redigera</a></b>\n";
		echo "<br>\n";
		echo "<b><a href=\"admin.php?op=prod_ny\">Produkt - Ny</a></b>\n";
        echo "<br>\n";
		echo "<b><a href=\"admin.php?op=prod_redigera\">Produkt - Redigera</a></b>\n";
		echo "<br>\n";
		echo "<b><a href=\"admin.php?op=order_visa\">Ordrar - Nya</a></b>\n";
        echo "<br>\n";
		echo "<b><a href=\"admin.php?op=order_visa_skickad\">Ordrar - Skickade</a></b>\n";
        echo "<br>\n";
        echo "<b><a href=\"admin.php?op=order_visa_betald\">Ordrar - Betalda</a></b>\n";
        echo "<br>\n";
		echo "<b><a href=\"admin.php?op=order_visa_makulerad\">Ordrar - Makulerade</a></b>\n";
        }

}

?>

