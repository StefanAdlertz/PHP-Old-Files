<?php
session_start();
include "__config.php";
include "__connect_database.php";

#################################### CRM Sida ##################################
function LoggaIn() {

	if (empty($_SESSION['inloggad'])) {
		if (empty($_POST['namn']) || empty($_POST['losen'])) {
			echo "<center>\n";
			echo "<form action=\"index.php?op=logga_in\" method=\"post\">\n";
			echo "<table>\n";
			echo "<tr>\n";
			echo "<td>Användarnamn:</td><td><input class='skugga' type=\"text\" name=\"namn\"></td>\n";
			echo "</tr>\n";
            echo"<input type=hidden name=location value='{$_GET['location']}'>";
			echo "<tr>\n";
			echo "<td>Lösenord:</td><td><input class='skugga' type=\"password\" name=\"losen\"></td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>&nbsp;</td><td><input type=\"submit\" value=\"Logga in\"></td>\n";
			echo "</tr>\n";
			echo "</table>\n";
			echo "</form>\n";
			echo "</center>\n";
		} else {
            if ($_POST['namn']=='shop' && $_POST['losen']=='shop') {
				$_SESSION['inloggad'] = '1';
                $_SESSION['fnamn'] = 'Stefan';
                $_SESSION['enamn'] = 'Adlertz';
                $_SESSION['adress'] = 'Midsommarvägen 80';
                $_SESSION['postnr'] = '126 35';
                $_SESSION['postadress'] = 'HÄGERSTEN';
                $_SESSION['telefon'] = '0706 450 350';
                $_SESSION['mail'] = 'stefan@adlertz.se';

                $location = $_POST['location'];
                switch($location) {
                    case "kassa":
                    header("Location: index.php?op=kassa");
                    break;
                    case "":
                    header("Location: index.php");
                    break;
                }
            }
            else
            header("Location: index.php?op=logga_in");
		}
	}
}

function LoggaUt() {
    $_SESSION['inloggad'] = '0';
    $_SESSION['fnamn'] = '';
    $_SESSION['enamn'] = '';
    $_SESSION['adress'] = '';
    $_SESSION['postnr'] = '';
    $_SESSION['postadress'] = '';
    $_SESSION['telefon'] = '';
    $_SESSION['mail'] = '';
    foreach ($_SESSION['kundvagn'] as $key => $value) {
        $_SESSION['kundvagn'][$key]='';
    }

	header("Location: index.php");
}

function ProduktList() {
    echo"<table cellpadding=0 cellspacing=0 border=0 height=100%><tr><td class=shop_left width=200 valign=top>";
    if (!empty($_SESSION['kundvagn'])) {
        $count=array_sum($_SESSION['kundvagn']);
        if (!empty($count)) {
            echo"<a href='index.php?op=kundvagn_list'><img src='images/add_button.png' class='add_button' alt='Kundvagn'>&nbsp;</a>Kundvagn<br><br>";
        }
    }

    $kat = $_GET['kat'];
	$sql = mysql_query("SELECT * FROM kategorier ORDER BY kategori");
	while ($rad=mysql_fetch_array($sql)) {
		echo "<b><a href=\"index.php?op=produkt_list&kat=".$rad['kategoriID']."\"><img src='images/add_button.png' class='add_button' alt=''>&nbsp;</a>{$rad['kategori']}</b><br>\n";
        $sql2 = mysql_query("SELECT * FROM produkter WHERE kategoriID=$kat");
        if (!empty($sql2)) {
            if ($rad['kategoriID']==$kat) {
                while ($rad2=mysql_fetch_array($sql2)) {
                    echo "&nbsp;<a href=\"index.php?op=produkt_list&kat=".$rad2['kategoriID']."&prodID=".$rad2['prodID']."\"><img src='images/add_button.png' class='add_button' alt=''>&nbsp;</a>{$rad2['rubrik']}<br>\n";
                }
            }
        }
	}
    echo"</td>";
    echo"<td valign=top>";
    echo"<table cellpadding=0 cellspacing=0 border=0>";

    $prodID = $_GET['prodID'];
    $sql = mysql_query("SELECT * FROM produkter WHERE prodID=$prodID");
    if (!empty($sql)) {
        while ($rad=mysql_fetch_array($sql)) {
            $prodID=mysql_result($sql, 0, 'prodID');
            echo "<tr><td class=shop_images valign=top><img src=images/prod_images/$prodID.png></td>";
            echo "<td  class=shop_prodtd><table cellpadding=0 cellspacing=0 border=0>";
            echo "<tr><td class=shop_rubrik width=540 valign=top><b>".mysql_result($sql, 0, 'rubrik')."</b></td></tr>";
            echo "<tr><td width=540 height=400 valign=top>".mysql_result($sql, 0, 'beskrivning')."</td></tr>";
            echo "<tr><td class=shop_pris align=right colspan=2><b>pris:&nbsp;".mysql_result($sql, 0, 'pris')."&nbsp</b>";
            echo "<b><a href='index.php?op=produkt_add&key=$prodID&val={$_SESSION['kundvagn']['$prodID)']}'><img src='images/add_button.png' class='add_button' alt='Köp'>&nbsp;</a>Lägg i Kundvagn</b></td></tr>";
            echo "</tr></table></td>";
        }
    }

    echo"</table>";
    echo"</td></tr></table>";
}

function ProduktAdd() {
    $value = $_GET['val'];
    if (empty($_GET['val'])) {
        $value = 0;
    }

    $count=count ($_SESSION['kundvagn']);
    if (empty($count)) {
        $_SESSION['kundvagn'] = array();
    }

    $key = $_GET['key'];
    $value = $value+1;

    $_SESSION['kundvagn'][$key] = $value;
    header("Location: index.php?op=produkt_list");
}

function KundvagnList() {
    echo"<table border=0 cellpadding=0 cellspacing=0>";
    foreach ($_SESSION['kundvagn'] as $key => $value) {
        if (!empty($_SESSION['kundvagn'][$key])) {
            echo"<tr>";
            echo "<form name=form action='index.php?op=kundvagn_add' method=post>";
            echo"<input type=hidden name=key value='$key'>";
            echo "<td><input type=text name=val value={$_SESSION['kundvagn'][$key]} size=1 />".":st&nbsp;</td>";

            $sql=mysql_query("SELECT * FROM produkter where prodID='$key'");
            echo "<td>".mysql_result($sql, 0, 'rubrik')."&nbsp;</td>";
            echo "<td>a'pris:&nbsp;".mysql_result($sql, 0, 'pris')."&nbsp;</td>";
            $sumtot=mysql_result($sql, 0, 'pris')*$value+$sumtot;
            echo "<td>summa:&nbsp;".mysql_result($sql, 0, 'pris')*$value."&nbsp;</td>";

            echo "<td><input type=submit value='Ändra' name=ok /></td>";
            echo "</form>";

            echo "<form name=form action='index.php?op=kundvagn_delete' method=post>";
            echo"<input type=hidden name=key value='$key'>";
            echo "<td><input type=submit value='Ta bort' name=ok /></td>";

            echo "</form>";
            echo"</tr>";
       }
    }

    $count=array_sum($_SESSION['kundvagn']);
    if (!empty($count)) {
        echo"<tr><td colspan=4 align=right><b>Totalt: ".$sumtot."</b></tr></td>";
    }
        echo"<form name=form action='index.php?op=kassa' method=post>";
        echo"<tr><td><input type=submit value='Till Kassan' name=ok /></td></tr>";
    echo"</table>";

    if (empty($count)) {
        header("Location: index.php?");
    }
}

function KundvagnAdd() {
    $value = $_POST['val'];
    if (empty($_POST['val'])) {
        $value=0;
    }
    $key = $_POST['key'];

    $_SESSION['kundvagn'][$key] = $value;
    header("Location: index.php?op=kundvagn_list");
}

function KundvagnDelete() {
    $key = $_POST['key'];

    $_SESSION['kundvagn'][$key]='';
    header("Location: index.php?op=kundvagn_list");
}

function Kassa() {
    if ($_SESSION['inloggad'] == '1') {

        echo"<table>";
        echo"<tr><td colspan=2>Din beställning innehåller följande artiklar:</td></tr>";
        foreach ($_SESSION['kundvagn'] as $key => $value) {
            if (!empty($_SESSION['kundvagn'][$key])) {
                $sql=mysql_query("SELECT * FROM produkter where prodID='$key'");
                echo "<tr><td>".$_SESSION['kundvagn'][$key]."&nbsp;st&nbsp;".mysql_result($sql, 0, 'rubrik')."&nbsp;</td>";
                echo "<td>Summa:&nbsp;".mysql_result($sql, 0, 'pris')*$value."&nbsp;</td></tr>";
                $sumtot=$sumtot+mysql_result($sql, 0, 'pris')*$value;
            }
        }
        echo"<tr><td colspan=2><b>Totalt:&nbsp;$sumtot</b></td></tr>";
        echo"<tr><td colspan=2>&nbsp;</td></tr>";
        echo"<tr><td colspan=2>Beställningen skickas till:</td></tr>";
        echo"<tr><td colspan=2>{$_SESSION['fnamn']}&nbsp{$_SESSION['enamn']}</td></tr>";
        echo"<tr><td colspan=2>{$_SESSION['adress']}</td></tr>";
        echo"<tr><td colspan=2>{$_SESSION['postnr']}&nbsp;{$_SESSION['postadress']}</td></tr>";
        echo"<tr><td colspan=2>&nbsp;</td></tr>";
        echo"<tr><td colspan=2>Verifikation och SMS-avisering skickas till:</td></tr>";
        echo"<tr><td colspan=2>{$_SESSION['telefon']}</td></tr>";
        echo"<tr><td colspan=2>{$_SESSION['mail']}</td></tr>";
        echo"<tr><td colspan=2>&nbsp;</td></tr>";
        echo"<form name=form action='index.php?op=bestall' method=post>";
        echo"<tr><td><input type=submit value='Skicka Beställning' name=bestall /></td></tr>";

        echo"</table>";
    }
    else header("Location: index.php?op=logga_in&location=kassa");
}

function SparaBestallning() {
	$datum = date("Y-m-d H:i:s");
    $fnamn = $_SESSION['fnamn'];
    $enamn = $_SESSION['enamn'];
    $adress = $_SESSION['adress'];
    $postnr = $_SESSION['postnr'];
    $postadress = $_SESSION['postadress'];
    $mobiltelefon = $_SESSION['telefon'];
    $epost = $_SESSION['mail'];

	$sql = mysql_query("INSERT INTO shop_bestallning(skapad, fnamn, enamn, adress, postnr, postadress, mobiltelefon, epost)
    VALUES('$datum','$fnamn','$enamn','$adress','$postnr','$postadress','$mobiltelefon','$epost')");

	$orderID = mysql_insert_id();

    foreach ($_SESSION['kundvagn'] as $key => $value) {
        if (!empty($_SESSION['kundvagn'][$key])) {
            $sql=mysql_query("SELECT * FROM produkter where prodID='$key'");
            $prodID = mysql_result($sql, 0, 'prodID');
            $beskrivning = mysql_result($sql, 0, 'beskrivning');
            $antal = $_SESSION['kundvagn'][$key];
            $pris = mysql_result($sql, 0, 'pris');

            $sql = mysql_query("INSERT INTO shop_bestallning_produkter(orderID, prodID, rubrik, antal, pris)
            VALUES('$orderID','$prodID','$beskrivning','$antal','$pris')");
        }
    }
    

    $body .= "\n\rHoppas du blir nöjd med din beställning!";

    $to      =   $epost;
    $from    =   "shop.adlertz.se";
    $subject =   utf8_decode("Bekräftelse av ordernr: $orderID");
    $name    =   $namn;
    $message =   utf8_decode($body);

    if (mail($to, $subject, $message ,"From: $name <$from>"))

	foreach ($_SESSION['kundvagn'] as $key => $value) {
        $_SESSION['kundvagn'][$key]='';
    }
	Header("Location: index.php?op=tack");
}

################################################################################
?>
