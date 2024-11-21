<?php
ob_start();
session_start();
include "__config.php";
include "__connect_database.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="__mall.css" rel="stylesheet" type="text/css"></link>
<title>crm.adlertz.se</title>


<script LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT">

var kontaktnoll='0000-00-00';

function show_popup(text)
{
var textHTML=text;
var p=window.createPopup();
var pbody=p.document.body;
pbody.style.backgroundColor="white";
pbody.style.font="8pt Verdana";
pbody.style.color="#585757";
pbody.style.border="solid #7C7B7B 1px";
pbody.innerHTML=textHTML;
p.show(909,220,200,200,document.body);
}

function hide_popup()
{
var p=window.createPopup();
var pbody=p.document.body;
pbody.style.backgroundColor="transparent";
pbody.style.border="transparent";
pbody.innerHTML='';
p.show(0,0,0,0,document.body);
}

</script>

<script language="javascript" type="text/javascript" src="datetimepicker_css.js"></script>

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
            <td colspan="3" class="toptd"><?php DoMenuTd();?></td>
          </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td>
          <table cellspacing="0" cellpadding="0" border="0"><tr>
            <td class="menu_left" valign="top"><?php DoMenuLeft();?></td>
            <td valign="top" class="middletable"><?php DoMain();?></td>
          </tr></table>
          </td>
        </tr>
        <tr>
          <td class="bottomtd"><div align="center">Welcome to CRM</div></td>
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
if (!empty($_SESSION['inloggad'])) {
    
    if (!empty($_SESSION['arbetsgrupps_ID'])) {
        $sql=mysql_query("SELECT arbetsgrupp FROM crm_arbetsgrupp WHERE arbetsgrupps_ID={$_SESSION['arbetsgrupps_ID']}");
        $arbetsgrupp=mysql_result($sql, 0, 'arbetsgrupp');
        echo "<td class=menutext>Vald Arbetsgrupp:&nbsp;$arbetsgrupp</td>";
    }
    echo "<td class=menutext>&nbsp;|&nbsp;Inloggad som:&nbsp;{$_SESSION['fnamn']}&nbsp;{$_SESSION['enamn']}</td>";
    echo "<td class=menutext>&nbsp;|&nbsp;<a href=index.php?op=logga_ut>Logga ut</a><br><td>";
}


}

function DoMenuLeft() {
   
if (empty($_SESSION['inloggad'])) {

}

if (!empty($_SESSION['inloggad'])) {
    
    if (!empty($_SESSION['arbetsgrupps_ID'])) {
        echo "<a href=index.php?op=foretag_lista_aterkontakt>Lista Företag Återkontakt</a><br>";
        echo "<a href=index.php?op=foretag_lista>Lista Företag</a><br>";
        echo "<a href=index.php?op=foretag_sok>Sök Företag</a><br>";
        echo "<a href=index.php?op=foretag_nytt>Nytt Företag</a><br>";
        echo "<a href=index.php?op=kontakt_kategori_ny>Ny Kontaktkategori</a><br>";
    }

    echo "<a href=index.php?op=kontakt_saljare_uppdatera>Uppdatera Säljare</a><br>";
    echo "<a href=index.php?op=arbetsgrupp_ny>Ny Arbetsgrupp</a><br>";
    echo "<a href=index.php?op=valj_arbetsgrupp>Välj Arbetsgrupp</a><br>";

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
include "__class.php";

    $op = $_GET['op'];
	switch($op) {
        case "foretag_sok":
			ForetagSok();
			break;
        case "foretag_lista":
			ForetagLista();
			break;
        case "foretag_lista_aterkontakt":
			ForetagListaAterkontakt();
			break;
        case "foretag_visa":
			ForetagVisa();
			break;
        case "foretag_nytt":
			ForetagNytt();
			break;
        case "foretag_uppdatera":
            ForetagUppdatera();
			break;
        case "foretag_radera":
            ForetagRadera();
			break;
//        case "kontaktperson_ny":
//            KontaktpersonNy();
//			break;
//        case "kontaktperson_uppdatera":
//            KontaktpersonUppdatera();
//			break;
        case "valj_arbetsgrupp":
            ValjArbetsgrupp();
			break;
        case "kontaktperson_radera":
            KontaktpersonRadera();
			break;
//        case "kontakt_ny":
//            KontaktNy();
//			break;
//        case "kontakt_uppdatera":
//            KontaktUppdatera();
//			break;
        case "kontakt_kategori_ny":
            KontaktKategoriNy();
			break;
        case "kontakt_saljare_ny":
            KontaktSaljareNy();
			break;
        case "saljare_spara":
            SaljareSpara();
			break;
        case "kontakt_saljare_uppdatera":
            KontaktSaljareUppdatera();
			break;
        case "arbetsgrupp_ny":
            ArbetsgruppNy();
			break;
        case "logga_ut":
			LoggaUt();
			break;
        case "logga_in":
			LoggaIn();
			break;
		default:
			CrmSida();
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
