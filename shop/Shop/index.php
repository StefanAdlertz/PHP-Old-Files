<?php
ob_start();
session_start();
include "__config.php";
include "__connect_database.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="__mall.css" rel="stylesheet" type="text/css">
<title>www.adlertz.se</title>
</head>

<body>

<table class="maintable" align="center" valign="top" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="site-shade-corner-top-left"></td>
    <td class="site-shade-top"></td>
    <td class="site-shade-corner-top-right"></td>
  </tr>
  <tr>
    <td class="site-shade-left"></td>
    <td>
      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
      <tr>
        <td class="site-border-top-left"></td>
        <td class="site-border-top"></td>
        <td class="site-border-top-right"></td>
      </tr>
      <tr>
        <td class="site-border-left"></td>
        <td><table cellspacing="0" cellpadding="0" border="0">
  		<tr>
          <td class="toptd">&nbsp;</td>
        </tr>
        <tr>
          <td>
          <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td class="menu" align="left">
            <table cellspacing="0" cellpadding="0" border="0">
            <tr><?php DoMenu();?></tr>
            </table>
            </td>
          </tr>
          <tr>
            <td colspan="3" class="toptd"><?DoMenuTd();?></td>
          </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td valign="top" class="middletable"><?php DoMain();?></td>
        </tr>
        <tr>
          <td class="bottomtd"><div align="center">Stefan Adlertz | stefan@adlertz.se | mobil: +46 (0) 706 450 350</div></td>
        </tr>
        </table></td>

        <td class="site-border-right"></td>
        </tr>
      <tr>
        <td class="site-border-bottom-left"></td>
        <td class="site-border-bottom"></td>
        <td class="site-border-bottom-right"></td>
      </tr>
      </table>
    </td>
    <td class="site-shade-right"></td>
  </tr>
  <tr>
    <td class="site-shade-corner-bottom-left"></td>
    <td class="site-shade-bottom"></td>
    <td class="site-shade-corner-bottom-right"></td>
  </tr>
</table>

</body>
</html>

<?php

function DoTop() {

}

function DoMenu() {
    echo "<td class='button' align='center'><a href=index.php?op=produkt_list>Produkter</a></td>";
    if (empty($_SESSION['inloggad'])) {
        echo "<td class='button' align='center'><a href=index.php?op=logga_in>Logga in</a></td>";
    }
    if ($_SESSION['inloggad'] == '1') {
        echo "<td class='button' align='center'><a href=index.php?op=logga_ut>Logga ut</a></td>";
    }
}

function DoMenuTd() {

        $op = $_GET['op'];

        if ($_SESSION['inloggad'] == '1') {
            echo '&nbsp;';
        }
        else
		echo '&nbsp;';
}

function DoMain() {
include "__functions.php";

    $op = $_GET['op'];
	switch($op) {
        case "produkt_list":
			ProduktList();
			break;
        case "produkt_add":
			ProduktAdd();
			break;
        case "kundvagn_add":
			KundvagnAdd();
			break;
        case "kundvagn_list":
			KundvagnList();
			break;
        case "kundvagn_add":
			KundvagnAdd();
			break;
        case "kundvagn_delete":
			KundvagnDelete();
			break;
        case "kassa":
			Kassa();
			break;
        case "bestall":
			SparaBestallning();
			break;
        case "logga_ut":
			LoggaUt();
			break;
        case "logga_in":
			LoggaIn();
			break;
		default:
			ProduktList();
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
