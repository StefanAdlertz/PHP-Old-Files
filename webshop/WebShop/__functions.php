<?php

session_start();

#################################### AdminSida #################################

function VisaMeny() {
	if (empty($_SESSION['inloggad'])) {
		if (empty($_POST['namn']) || empty($_POST['losen'])) {
			// Inte inloggad så visa inloggningsformuläret
			echo "<center>\n";
			echo "<form action=\"admin.php\" method=\"post\">\n";
			echo "<table>\n";
			echo "<tr>\n";
			echo "<td>Användarnamn:</td><td><input type=\"text\" name=\"namn\"></td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Lösenord:</td><td><input type=\"text\" name=\"losen\"></td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>&nbsp;</td><td><input type=\"submit\" value=\"Logga in\"></td>\n";
			echo "</tr>\n";
			echo "</table>\n";
			echo "</form>\n";
			echo "</center>\n";
		} else {
			// Logga in om lösenordet är rätt
			if ($_POST['namn']==ANVANDARE && $_POST['losen']==LOSEN) {
				// Rätt lösen så sätt sessionsvaribeln och ladda om sidan
				$_SESSION['inloggad'] = '1';
				header("Location: admin.php");
			} else {
				// Fel lösen så ladda sidan igen
				header("Location: admin.php");
			}
		}
	} else {

	}
}

function NyKategori() {
	global $dbh;
	// Är personen inloggad?
	if ($_SESSION['inloggad']!='1') {
		// Nej, så vi skickar tillbaka till startsidan
		header("Location: admin.php");
	}
	// Ska vi visa formuläret eller spara den nya kategorin i databasen?
	$kategori = $_POST['kategori'];
	if (empty($kategori)) {
		// Visa formuläret
        echo "<table align='center' border=\"0\">\n";
		echo "<tr>\n";
        echo "<td colspan='2'><h5>Administrationsmeny - Ny kategori</h5></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<form action=\"admin.php\" method=\"post\">\n";
		echo "<tr>\n";
        echo "<td align='left'><input type=\"hidden\" name=\"op\" value=\"kat_ny\"></td>\n";
        echo "</tr>\n";
        echo "<td align='left'>Kategori: <input type=\"text\" name=\"kategori\"><input type=\"submit\" class=\"button\" value=\"Spara\">\n";
        echo "</form>\n";
		echo "</tr>\n";
		echo "</table>\n";
	} else {
		// Spara kategorin

		$query = "INSERT INTO kategorier(kategori) VALUES('$kategori')";
		mysql_query($query, $dbh);
		header("Location: admin.php");
	}
}

function RedigeraKategori() {
	global $dbh;
	// Är personen inloggad?
	if ($_SESSION['inloggad']!='1') {
		// Nej, så vi skickar tillbaka till startsidan
		header("Location: admin.php");
	}
	$kategoriID = $_POST['kategoriID'];
	$vad = $_POST['vad'];
	$kategori = $_POST['kategori'];
	// Ska vi lista alla kategorier?
	if (empty($kategoriID)) {
		// Ja, visa alla kategorier
		$result = mysql_query("SELECT * FROM kategorier", $dbh);
		echo "<center>\n";
		echo "<h5>Administrationsmeny - Redigera kategori</h5>\n";
		while($rad = mysql_fetch_array($result)) {
			echo "<form action=\"admin.php\" method=\"post\">\n";
			echo "<input type=\"hidden\" name=\"op\" value=\"kat_redigera\">\n";
			echo "<input type=\"hidden\" name=\"kategoriID\" value=\"".$rad['kategoriID']."\">\n";
			echo "<input type=\"text\" name=\"kategori\" value=\"".$rad['kategori']."\">\n";
			echo "<input type=\"submit\" class=\"button\" name=\"vad\" value=\"Ändra\">&nbsp;<input type=\"submit\" class=\"button\" name=\"vad\" value=\"Ta bort\">\n";
			echo "</form>\n";
		}
		echo "</center>\n";
	} else {
		// Nej, vi ska ta bort eller redigera. Viket?
		if ($vad=="Ändra") {
			// Spara det nya namnet på kategorin
			mysql_query("UPDATE kategorier SET kategori='$kategori' WHERE kategoriID=$kategoriID", $dbh);
			header("Location: admin.php?op=kat_redigera");
		} elseif($vad=="Ta bort") {
			// Ta bort kategorin
			mysql_query("DELETE FROM kategorier WHERE kategoriID=$kategoriID", $dbh);
			header("Location: admin.php?op=kat_redigera");
		}
	}
}

function NyProdukt() {
	global $dbh;
	// Är personen inloggad?
	if ($_SESSION['inloggad']!='1') {
		// Nej, så vi skickar tillbaka till startsidan
		header("Location: admin.php");
	}
	$kategoriID = $_POST['kategoriID'];
	$prodID = $_POST['prodID'];
	$spara = $_POST['spara'];
	// Ska vi lista upp kategorierna?
	if (empty($spara)) {
		// Ja, visa alla kategorier
		echo "<center>\n";
		echo "<h5>Administrationsmeny - Ny produkt</h5>\n";
		echo "<form action=\"admin.php\" method=\"post\" enctype=\"multipart/form-data\">\n";
		echo "<input type=\"hidden\" name=\"op\" value=\"prod_ny\">\n";
		echo "<table border=\"0\">\n";
        echo "<td>Rubrik:</td><td><input type=\"text\" name=\"rubrik\"></td>\n";
		echo "<tr>\n";
		echo "<td colspan=\"2\">Beskrivning:</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td colspan=\"2\"><textarea name=\"beskrivning\" cols=\"40\" rows=\"5\"></textarea></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>Pris:</td><td><input type=\"text\" name=\"pris\"></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>Bild:</td><td><input type=\"file\" name=\"bild\"></td>\n";
		echo "</tr>\n";
        echo "<tr>\n";
		echo "<td>Bild_tmb:</td><td><input type=\"file\" name=\"bild_tmb\"></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td>Kategori:</td>\n";
		echo "<td><select name=\"kategoriID\">\n";
		// Hämta alla kategorier och visa dem i en listruta
		$result = mysql_query("SELECT * FROM kategorier", $dbh);
		while($rad = mysql_fetch_array($result)) {
			echo "<option value=\"".$rad['kategoriID']."\">".$rad['kategori']."</option>\n";
		}
		echo "</select></td>\n";
		echo "</tr>\n";
		echo "<td colspan=\"2\" align=\"center\"><input type=\"submit\" class=\"button\" name=\"spara\" value=\"Spara\"></td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "</form>\n";
		echo "</center>\n";
	} elseif ($spara=="Spara") {
//		 Vi ska spara den nya produkten
//		 Vi börjar med att hantera den uppladdade bilden
		if (is_uploaded_file($_FILES['bild']['tmp_name'])) {
			//lägg filen i en variabel
			$tempname = $_FILES['bild']['tmp_name'];
			$filnamn = $_FILES['bild']['name'];
			$filtyp = $_FILES['bild']['type'];
			$filstorlek = $_FILES['bild']['size'];
			$originalbild = addslashes(fread(fopen($tempname, "rb"), filesize($tempname)));
			unlink($tempname.".img");
		}

        if (is_uploaded_file($_FILES['bild_tmb']['tmp_name'])) {
            //lägg filen i en variabel
			$tempname = $_FILES['bild_tmb']['tmp_name'];
			$filnamn = $_FILES['bild_tmb']['name'];
			$filtyp_tmb = $_FILES['bild_tmb']['type'];
			$filstorlek = $_FILES['bild_tmb']['size'];
			$miniatyrbild = addslashes(fread(fopen($tempname, "rb"), filesize($tempname)));
			unlink($tempname.".img");
        }

        $kategoriID = $_POST['kategoriID'];
        $rubrik = $_POST['rubrik'];
		$beskrivning = $_POST['beskrivning'];
		$pris = $_POST['pris'];
		mysql_query("INSERT INTO produkter(rubrik, beskrivning, bild, bildtyp, bild_tmb, bildtyp_tmb, pris, kategoriID) VALUES('$rubrik','$beskrivning','$originalbild','$filtyp','$miniatyrbild','$filtyp_tmb','$pris','$kategoriID')", $dbh);
		header("Location: admin.php");
	}
}

function RedigeraProdukt() {
	global $dbh;
	// Är personen inloggad?
	if ($_SESSION['inloggad']!='1') {
		// Nej, så vi skickar tillbaka till startsidan
		header("Location: admin.php");
	}
	// Ska vi visa alla kategorier?
	$kategoriID = $_POST['kategoriID'];
	$prodID = $_POST['prodID'];
	$vad = $_POST['vad'];
	if (empty($kategoriID) && empty($prodID)) {
		// Ja, visa ett formulär
		echo "<center>\n";
		echo "<h5>Administrationsmeny - Redigera produkt</h5>\n";
		echo "<h5>Välj en produktkategori</h5>\n";
		echo "<form action=\"admin.php\" method=\"post\">\n";
		echo "<input type=\"hidden\" name=\"op\" value=\"prod_redigera\">\n";
		echo "<select name=\"kategoriID\">\n";
		// Hämta alla kategorier och visa dem i en listruta
		$result = mysql_query("SELECT * FROM kategorier", $dbh);
		while($rad = mysql_fetch_array($result)) {
			echo "<option value=\"".$rad['kategoriID']."\">".$rad['kategori']."</option>\n";
		}
		echo "</select>\n";
		echo "<input type=\"submit\" class=\"button\" value=\"Visa produkter\">\n";
		echo "</form>\n";
		echo "</center>\n";
	} elseif (!empty($kategoriID) && empty($prodID)) {
		// Visa alla produkter i vald kategori
		echo "<center>\n";
		echo "<h5>Administrationsmeny - Redigera produkt</h5>\n";
		echo "<h5>Välj en produkt att redigera</h5>\n";
		echo "<table cellpadding='2' cellspacing='0' border=\"0\" width=\"100%\">\n";
		$result = mysql_query("SELECT prodID, rubrik, pris FROM produkter WHERE kategoriID=$kategoriID", $dbh);
		while($rad = mysql_fetch_array($result)) {
			echo "<form action=\"admin.php\" method=\"post\">\n";
			echo "<input type=\"hidden\" name=\"op\" value=\"prod_redigera\">\n";
			echo "<input type=\"hidden\" name=\"prodID\" value=\"".$rad['prodID']."\">\n";
			echo "<tr>\n";
			echo "<td class='vara' width=\"150\"><img src=\"prod_bild_tmb.php?prodID=".$rad['prodID']."\"></td>\n";
			echo "<td class='vara' width=\"300\" align=\"left\" valign=\"bottom\">".$rad['rubrik']."</td>\n";
			echo "<td class='vara' align=\"left\" valign=\"bottom\">".$rad['pris']."</td>\n";
			echo "<td class='vara' valign=\"bottom\"><input type=\"submit\" class=\"button\" name=\"vad\" value=\"Ta bort\">&nbsp;<input type=\"submit\" class=\"button\" name=\"vad\" value=\"Redigera\"></td>\n";
			echo "</tr>\n";
			echo "</form>\n";
		}
		echo "</table>\n";
		echo "</center>\n";
	} elseif ($vad=="Ta bort") {
		// Ta bort produkten
		mysql_query("DELETE FROM produkter WHERE prodID=$prodID", $dbh);
		header("Location: admin.php");
	} elseif ($vad=="Redigera") {
		// Ska vi visa redigeringsformuläret eller spara ändringarna
		$spara = $_POST['spara'];
		if (empty($spara)) {
			// Visa redigeringsformuläret
			echo "<center>\n";
			echo "<h5>Administrationsmeny - Redigera produkt</h5>\n";
			echo "<form action=\"admin.php\" method=\"post\" enctype=\"multipart/form-data\">\n";
			echo "<input type=\"hidden\" name=\"op\" value=\"prod_redigera\">\n";
			echo "<input type=\"hidden\" name=\"vad\" value=\"Redigera\">\n";
			echo "<input type=\"hidden\" name=\"prodID\" value=\"".$prodID."\">\n";
			echo "<table border=\"0\">\n";
			$result = mysql_query("SELECT rubrik, beskrivning, kategoriID, pris FROM produkter WHERE prodID=$prodID", $dbh);
			$kategoriID = mysql_result($result, 0, 'kategoriID');
			echo "<tr>\n";
			echo "<td align=\"center\"><img src=\"prod_bild.php?prodID=".$prodID."\"></td>\n";
			echo "</tr>\n";
            echo "<tr>\n";
			echo "<td align=\"center\"><img src=\"prod_bild_tmb.php?prodID=".$prodID."\"></td>\n";
			echo "</tr>\n";
            echo "<tr>\n";
			echo "<td>Rubrik:</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td><input type=\"text\" name=\"rubrik\" value=\"".mysql_result($result, 0, 'rubrik')."\"></td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Beskrivning:</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td><textarea name=\"beskrivning\" cols=\"40\" rows=\"5\">".mysql_result($result, 0, 'beskrivning')."</textarea></td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Pris:</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td><input type=\"text\" name=\"pris\" value=\"".mysql_result($result, 0, 'pris')."\"></td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Kategori:</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td><select name=\"kategoriID\">\n";
			// Hämta alla kategorier och visa dem i en listruta
			$result = mysql_query("SELECT * FROM kategorier", $dbh);
			while($rad = mysql_fetch_array($result)) {
				if ($kategoriID == $rad['kategoriID']) {
					echo "<option value=\"".$rad['kategoriID']."\" selected>".$rad['kategori']."</option>\n";
				} else {
					echo "<option value=\"".$rad['kategoriID']."\">".$rad['kategori']."</option>\n";
				}
			}
			echo "</select></td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Byt bild:</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td><input type=\"file\" name=\"bild\"></td>\n";
			echo "</tr>\n";
            echo "<tr>\n";
			echo "<td>Byt bild_tmb:</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td><input type=\"file\" name=\"bild_tmb\"></td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td align=\"center\"><input type=\"submit\" class=\"button\" name=\"spara\" value=\"Spara\"></td>\n";
			echo "</tr>\n";
			echo "</table>\n";
			echo "</form>\n";
			echo "</center>\n";
		} else {
			// Okey, spara alla ändringar
			$pris = $_POST['pris'];
		if (is_uploaded_file($_FILES['bild']['tmp_name'])) {
                $rubrik = $_POST['rubrik'];
				$beskrivning = $_POST['beskrivning'];
				$pris = $_POST['pris'];
                //lägg filen i en variabel
                $tempname = $_FILES['bild']['tmp_name'];
                $filnamn = $_FILES['bild']['name'];
                $filtyp = $_FILES['bild']['type'];
                $filstorlek = $_FILES['bild']['size'];
                $originalbild = addslashes(fread(fopen($tempname, "rb"), filesize($tempname)));
                unlink($tempname.".img");

                mysql_query("UPDATE produkter SET rubrik='$rubrik', beskrivning='$beskrivning', pris='$pris', kategoriID='$kategoriID', bild='$originalbild', bildtyp='$filtyp' WHERE prodID=$prodID", $dbh);
                header("Location: admin.php");
		}

        if (is_uploaded_file($_FILES['bild_tmb']['tmp_name'])) {
                $rubrik = $_POST['rubrik'];
				$beskrivning = $_POST['beskrivning'];
				$pris = $_POST['pris'];
                //lägg filen i en variabel
                $tempname = $_FILES['bild_tmb']['tmp_name'];
                $filnamn = $_FILES['bild_tmb']['name'];
                $filtyp_tmb = $_FILES['bild_tmb']['type'];
                $filstorlek = $_FILES['bild_tmb']['size'];
                $miniatyrbild = addslashes(fread(fopen($tempname, "rb"), filesize($tempname)));
                unlink($tempname.".img");

                mysql_query("UPDATE produkter SET rubrik='$rubrik', beskrivning='$beskrivning', pris='$pris', kategoriID='$kategoriID', bild_tmb='$miniatyrbild', bildtyp_tmb='$filtyp_tmb' WHERE prodID=$prodID", $dbh);
                header("Location: admin.php");
        }
	    else {
				// Ingen ny bild, uppdatera bara info
                $rubrik = $_POST['rubrik'];
				$beskrivning = $_POST['beskrivning'];
				$pris = $_POST['pris'];

				mysql_query("UPDATE produkter SET rubrik='$rubrik', beskrivning='$beskrivning', pris='$pris', kategoriID='$kategoriID' WHERE prodID=$prodID", $dbh);
				header("Location: admin.php");
			}
		}
	}
}

function VisaOrderNya() {
	global $dbh;
	// Är personen inloggad?
	if ($_SESSION['inloggad']!='1') {
		// Nej, så vi skickar tillbaka till startsidan
		header("Location: admin.php");
	}
	// Visar alla ordrar som är bekräfade av kunden
	// Ska vi visa en lista över alla ordrar eller visa
	// en specifik order?
	$orderID = $_POST['orderID'];
	if (empty($orderID)) {
		// Ja, visa alla ordrar i en lista
		echo "<center>\n";
		echo "<h5>Administrationsmeny - Visa nya ordrar</h5>\n";
		echo "<h5>Välj en order att visa</h5>\n";

		$result = mysql_query("SELECT * FROM orderhuvud WHERE status='V' AND bekraftad=1 ORDER BY orderID DESC", $dbh);
		echo "<table border=\"0\" width='100%' cellpadding='2' cellspacing='0'>\n";
		echo "<tr>\n";
		echo "<td class='vara'>OrderNr</td><td align='left' class='vara'>Beställare</td><td align='right' class='vara'>Antal produkter</td><td align='right' class='vara'>Summa</td>\n";
		echo "<td class='vara' align='right'>&nbsp;</td>\n";
		echo "</tr>\n";
		while($rad = mysql_fetch_array($result)) {
			echo "<form action=\"admin.php\" method=\"post\">\n";
			echo "<input type=\"hidden\" name=\"op\" value=\"order_visa\">\n";
			echo "<input type=\"hidden\" name=\"orderID\" value=\"".$rad['orderID']."\">\n";
			echo "<tr>\n";
			echo "<td class='vara'>".$rad['orderID']."</td>\n";
			echo "<td class='vara' align='right'>".$rad['full_namn']."</td>\n";
			echo "<td class='vara' align='right'>".RaknaProdukter($rad['orderID'])."</td>\n";
			echo "<td class='vara' align='right'>".RaknaSumma($rad['orderID'])."</td>\n";
//            <input type=\"submit\" class=\"button\" name=\"order\" value=\"Ta bort\">&nbsp;
			echo "<td class='vara' align='right'><input type=\"submit\" class=\"button\" name=\"order\" value=\"Visa\">\n";
			echo "</tr>\n";
			echo "</form>\n";
		}
		echo "</table>\n";
		echo "</center>\n";
	} else {
		$order = $_POST['order'];
		if ($order=="Visa") {
			// Visa ordern
			$result = mysql_query("SELECT * FROM orderhuvud WHERE orderID=$orderID ORDER BY orderID DESC", $dbh);
			echo "<table cellpadding='2' cellspacing='0' align='center' border=\"0\">\n";
            echo "<center><h5>Administrationsmeny - Visa nya ordrar</h5></center>\n";
            echo "<tr><td colspan='4'><h5>Kundinformation</h5></td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'full_namn')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'adress1')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'adress2')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'postnr')."  ".mysql_result($result, 0, 'postadress')."<br>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'telefon')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'mobiltelefon')."</td></tr>\n";
            echo "<tr><td colspan='4'><a href='mailto:".mysql_result($result, 0, 'epost')."?subject=Ordernummer: $orderID'>".mysql_result($result, 0, 'epost')."</a></td></tr>\n";
            echo "<tr><td colspan='4'>&nbsp;</td></tr>\n";

            echo "<tr><td colspan='4'><h5>Orderinformation</h5></td></tr>\n";
            echo "<tr><td>Ordernr: </td>\n";
            echo "<td>".$orderID."</td></tr>\n";
            echo "<tr><td>Mottagen: </td>\n";
            echo "<td>".mysql_result($result, 0, 'skapad')."</td></tr>\n";
            echo "<tr><td>Bekräftad: </td>";
            echo "<td>".mysql_result($result, 0, 'senast_aktiv')."</tr>\n";
            echo "<tr><td>&nbsp;</td></tr>\n";
            echo "<tr>";
			echo "<td>Produkt ID</td><td>Produktbeskrivning</td><td>a'pris</td><td>Antal</td><td>Summa</td>\n";
			echo "</tr>\n";
			$result = mysql_query("SELECT produkter.prodID, produkter.beskrivning, produkter.pris, orderrad.antal FROM produkter, orderrad WHERE orderrad.orderID=$orderID AND produkter.prodID=orderrad.prodID", $dbh);
			$totalsumma = 0;
			while($rad = mysql_fetch_array($result)) {
				echo "<tr>\n";
				echo "<td>".$rad['prodID']."</td>\n";
				echo "<td>".$rad['beskrivning']."</td>\n";
				echo "<td align='right'>".$rad['pris']."</td>\n";
				echo "<td align='right'>".$rad['antal']."</td>\n";
				$summa = ($rad['pris']*$rad['antal']);
				echo "<td align='right'>$summa</td>\n";
				echo "</tr>\n";
				$totalsumma = $totalsumma + $summa;
			}
			echo "<td align='right' colspan=\"4\"><b>Summa totalt:</b></td>\n";
			echo "<td align='right'><b>$totalsumma</b></td>\n";

            echo "<tr><td><form action=\"admin.php\" method=\"post\"></td></tr>\n";
			echo "<tr><td><input type=\"hidden\" name=\"op\" value=\"order_visa\"></td></tr>\n";
			echo "<tr><td><input type=\"hidden\" name=\"orderID\" value=\"".$orderID."\"></td></tr>\n";
			echo "<tr><td colspan='4'><input type=\"submit\" class=\"button\" name=\"order\" value=\"Makulera\">\n";
			echo "&nbsp;<input type=\"submit\" class=\"button\" name=\"order\" value=\"Skickad\"></td></tr>\n";
			echo "</form>\n";
			echo "</table>\n";

		} elseif ($order=="Skickad") {
			// Flagga ordern som klar och meddela kunden om detta via mail
            $datum=date("Y-m-d H:i:s");
			mysql_query("UPDATE orderhuvud SET status='K', skickad='$datum' WHERE orderID=$orderID");
			// Skapa ett epostmeddelande och skicka det till användaren
			$result = mysql_query("SELECT epost FROM orderhuvud WHERE orderID=$orderID");
			$epost = mysql_result($result, 0, 0);
            $datum_skickat=date("Y-m-d");
			$body = "Tack för din order!\n\rDin beställning har skickats mot postförskott till dig: $datum_skickat.\n\r";
			$body .= "\n\rHoppas du blir nöjd med din beställning!";

            $to      =   $epost;
            $from    =   "stefan@adlertz.se";
            $subject =   utf8_decode("Din order (nr:$orderID) har blivit behandlad!");
            $name    =   $namn;
            $message =   utf8_decode($body);
            if (mail($to, $subject, $message ,"From: $name <$from>")){
                header("Location: admin.php?op=order_visa");
            }
		} elseif ($order=="Makulera") {
			// Ta bort ordern
            mysql_query("UPDATE orderhuvud SET status='M' WHERE orderID=$orderID");
//			mysql_query("DELETE FROM orderrad WHERE orderID=$orderID", $dbh);
//			mysql_query("DELETE FROM orderhuvud WHERE orderID=$orderID", $dbh);
			header("Location: admin.php?op=order_visa");
		}
	}
}

function VisaOrderSkickad() {
	global $dbh;
	// Är personen inloggad?
	if ($_SESSION['inloggad']!='1') {
		// Nej, så vi skickar tillbaka till startsidan
		header("Location: admin.php");
	}
	// Visar alla ordrar som är bekräfade av kunden
	// Ska vi visa en lista över alla ordrar eller visa
	// en specifik order?
	$orderID = $_POST['orderID'];
	if (empty($orderID)) {
		// Ja, visa alla ordrar i en lista
		echo "<center>\n";
		echo "<h5>Administrationsmeny - Visa skickade ordrar</h5>\n";
		echo "<h5>Välj en order att visa</h5>\n";

		$result = mysql_query("SELECT * FROM orderhuvud WHERE status='K' AND bekraftad=1 ORDER BY orderID DESC", $dbh);
		echo "<table border=\"0\" width='100%' cellpadding='2' cellspacing='0'>\n";
		echo "<tr>\n";
		echo "<td class='vara'>OrderNr</td><td align='left' class='vara'>Beställare</td><td align='right' class='vara'>Antal produkter</td><td align='right' class='vara'>Summa</td>\n";
		echo "<td class='vara' align='right'>&nbsp;</td>\n";
		echo "</tr>\n";
		while($rad = mysql_fetch_array($result)) {
			echo "<form action=\"admin.php\" method=\"post\">\n";
			echo "<input type=\"hidden\" name=\"op\" value=\"order_visa_skickad\">\n";
			echo "<input type=\"hidden\" name=\"orderID\" value=\"".$rad['orderID']."\">\n";
			echo "<tr>\n";
			echo "<td class='vara'>".$rad['orderID']."</td>\n";
			echo "<td class='vara' align='right'>".$rad['full_namn']."</td>\n";
			echo "<td class='vara' align='right'>".RaknaProdukter($rad['orderID'])."</td>\n";
			echo "<td class='vara' align='right'>".RaknaSumma($rad['orderID'])."</td>\n";
//            <input type=\"submit\" class=\"button\" name=\"order\" value=\"Ta bort\">&nbsp;
			echo "<td class='vara' align='right'><input type=\"submit\" class=\"button\" name=\"order\" value=\"Visa\">\n";
			echo "</tr>\n";
			echo "</form>\n";
		}
		echo "</table>\n";
		echo "</center>\n";
	} else {
		$order = $_POST['order'];
		if ($order=="Visa") {
			// Visa ordern
			$result = mysql_query("SELECT * FROM orderhuvud WHERE orderID=$orderID ORDER BY orderID DESC", $dbh);
			echo "<table cellpadding='2' cellspacing='0' align='center' border=\"0\">\n";
            echo "<center><h5>Administrationsmeny - Visa skickade ordrar</h5></center>\n";
            echo "<tr><td colspan='4'><h5>Kundinformation</h5></td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'full_namn')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'adress1')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'adress2')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'postnr')."  ".mysql_result($result, 0, 'postadress')."<br>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'telefon')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'mobiltelefon')."</td></tr>\n";
            echo "<tr><td colspan='4'><a href='mailto:".mysql_result($result, 0, 'epost')."?subject=Ordernummer: $orderID'>".mysql_result($result, 0, 'epost')."</a></td></tr>\n";
            echo "<tr><td>&nbsp;</td></tr>";
            echo "<tr><td colspan='4'><h5>Orderinformation</h5></td></tr>\n";
            echo "<tr><td>Ordernr: </td>\n";
            echo "<td>".$orderID."</td></tr>\n";
            echo "<tr><td>Mottagen: </td>\n";
            echo "<td>".mysql_result($result, 0, 'skapad')."</td></tr>\n";
            echo "<tr><td>Skickad: </td>";
            echo "<td>".mysql_result($result, 0, 'skickad')."</tr>\n";
            echo "<tr><td>&nbsp;</td></tr>\n";

			echo "<tr><td>Produkt ID</td><td>Produktbeskrivning</td><td>a'pris</td><td>Antal</td><td>Summa</td></tr>\n";
			$result = mysql_query("SELECT produkter.prodID, produkter.beskrivning, produkter.pris, orderrad.antal FROM produkter, orderrad WHERE orderrad.orderID=$orderID AND produkter.prodID=orderrad.prodID", $dbh);
			$totalsumma = 0;
			while($rad = mysql_fetch_array($result)) {
				echo "<tr>\n";
				echo "<td>".$rad['prodID']."</td>\n";
				echo "<td>".$rad['beskrivning']."</td>\n";
				echo "<td align='right'>".$rad['pris']."</td>\n";
				echo "<td align='right'>".$rad['antal']."</td>\n";
				$summa = ($rad['pris']*$rad['antal']);
				echo "<td align='right'>$summa</td>\n";
				echo "</tr>\n";
				$totalsumma = $totalsumma + $summa;
			}
			echo "<tr><td align='right' colspan=\"4\"><b>Summa totalt:</b></td>\n";
			echo "<td align='right'><b>$totalsumma</b></td></tr>\n";
            echo "<tr><td><form action=\"admin.php\" method=\"post\"></td></tr>\n";
			echo "<tr><td><input type=\"hidden\" name=\"op\" value=\"order_visa_skickad\"></td></tr>\n";
			echo "<tr><td><input type=\"hidden\" name=\"orderID\" value=\"".$orderID."\"></td></tr>\n";
			echo "<tr><td colspan='4'><input type=\"submit\" class=\"button\" name=\"order\" value=\"Betald\"></td></tr>\n";
			echo "</table>\n";
//			echo "&nbsp;<input type=\"submit\" class=\"button\" name=\"order\" value=\"Klar\">\n";
			echo "</form>\n";
		} elseif ($order=="Klar") {

		} elseif ($order=="Betald") {
            $datum=date("Y-m-d H:i:s");
			mysql_query("UPDATE orderhuvud SET status='B', senast_aktiv='$datum' WHERE orderID=$orderID");
            // Ta bort ordern
//			mysql_query("DELETE FROM orderrad WHERE orderID=$orderID", $dbh);
//			mysql_query("DELETE FROM orderhuvud WHERE orderID=$orderID", $dbh);
			header("Location: admin.php?op=order_visa_skickad");
		}
	}
}

function VisaOrderBetald() {
	global $dbh;
	// Är personen inloggad?
	if ($_SESSION['inloggad']!='1') {
		// Nej, så vi skickar tillbaka till startsidan
		header("Location: admin.php");
	}
	// Visar alla ordrar som är bekräfade av kunden
	// Ska vi visa en lista över alla ordrar eller visa
	// en specifik order?
	$orderID = $_POST['orderID'];
	if (empty($orderID)) {
		// Ja, visa alla ordrar i en lista
		echo "<center>\n";
		echo "<h5>Administrationsmeny - Visa betalda ordrar</h5>\n";
		echo "<h5>Välj en order att visa</h5>\n";

		$result = mysql_query("SELECT * FROM orderhuvud WHERE status='B' AND bekraftad=1 ORDER BY orderID DESC", $dbh);
		echo "<table border=\"0\" width='100%' cellpadding='2' cellspacing='0'>\n";
		echo "<tr>\n";
		echo "<td class='vara'>OrderNr</td><td align='left' class='vara'>Beställare</td><td align='right' class='vara'>Antal produkter</td><td align='right' class='vara'>Summa</td>\n";
		echo "<td class='vara' align='right'>&nbsp;</td>\n";
		echo "</tr>\n";
		while($rad = mysql_fetch_array($result)) {
			echo "<form action=\"admin.php\" method=\"post\">\n";
			echo "<input type=\"hidden\" name=\"op\" value=\"order_visa_betald\">\n";
			echo "<input type=\"hidden\" name=\"orderID\" value=\"".$rad['orderID']."\">\n";
			echo "<tr>\n";
			echo "<td class='vara'>".$rad['orderID']."</td>\n";
			echo "<td class='vara' align='right'>".$rad['full_namn']."</td>\n";
			echo "<td class='vara' align='right'>".RaknaProdukter($rad['orderID'])."</td>\n";
			echo "<td class='vara' align='right'>".RaknaSumma($rad['orderID'])."</td>\n";
//            <input type=\"submit\" class=\"button\" name=\"order\" value=\"Ta bort\">&nbsp;
			echo "<td class='vara' align='right'><input type=\"submit\" class=\"button\" name=\"order\" value=\"Visa\">\n";
			echo "</tr>\n";
			echo "</form>\n";
		}
		echo "</table>\n";
		echo "</center>\n";
	} else {
		$order = $_POST['order'];
		if ($order=="Visa") {
			// Visa ordern
			$result = mysql_query("SELECT * FROM orderhuvud WHERE orderID=$orderID ORDER BY orderID DESC", $dbh);
			echo "<table cellpadding='2' cellspacing='0' align='center' border=\"0\">\n";
            echo "<center><h5>Administrationsmeny - Visa betalda ordrar</h5></center>\n";
            echo "<tr><td colspan='4'><h5>Kundinformation</h5></td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'full_namn')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'adress1')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'adress2')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'postnr')."  ".mysql_result($result, 0, 'postadress')."<br>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'telefon')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'mobiltelefon')."</td></tr>\n";
            echo "<tr><td colspan='4'><a href='mailto:".mysql_result($result, 0, 'epost')."?subject=Ordernummer: $orderID'>".mysql_result($result, 0, 'epost')."</a></td></tr>\n";
            echo "<tr><td>&nbsp;</td></tr>\n";

            echo "<tr><td colspan='4'><h5>Orderinformation</h5></tr></td>\n";
            echo "<tr><td>Ordernr: </td>\n";
            echo "<td>".$orderID."</td></tr>\n";
            echo "<tr><td>Mottagen: </td>\n";
            echo "<td>".mysql_result($result, 0, 'skapad')."</td></tr>\n";
            echo "<tr><td>Skickad: </td>";
            echo "<td>".mysql_result($result, 0, 'skickad')."</tr>\n";
            echo "<tr><td>Betald: </td>";
            echo "<td>".mysql_result($result, 0, 'senast_aktiv')."</tr>\n";
            echo "<tr><td>&nbsp;</td></tr>\n";
            echo "<tr>";
			echo "<td>Produkt ID</td><td>Produktbeskrivning</td><td>a'pris</td><td>Antal</td><td>Summa</td>\n";
			echo "</tr>\n";
			$result = mysql_query("SELECT produkter.prodID, produkter.beskrivning, produkter.pris, orderrad.antal FROM produkter, orderrad WHERE orderrad.orderID=$orderID AND produkter.prodID=orderrad.prodID", $dbh);
			$totalsumma = 0;
			while($rad = mysql_fetch_array($result)) {
				echo "<tr>\n";
				echo "<td>".$rad['prodID']."</td>\n";
				echo "<td>".$rad['beskrivning']."</td>\n";
				echo "<td align='right'>".$rad['pris']."</td>\n";
				echo "<td align='right'>".$rad['antal']."</td>\n";
				$summa = ($rad['pris']*$rad['antal']);
				echo "<td align='right'>$summa</td>\n";
				echo "</tr>\n";
				$totalsumma = $totalsumma + $summa;
			}
			echo "<tr><td align='right' colspan=\"4\"><b>Summa totalt:</b></td>\n";
			echo "<td align='right'><b>$totalsumma</b></td></tr>\n";
            echo "<tr><td><input type=\"hidden\" name=\"op\" value=\"order_visa_betald\"></td></tr>\n";
			echo "<tr><td><input type=\"hidden\" name=\"orderID\" value=\"".$orderID."\"></td></tr>\n";
            echo "<form action=\"admin.php\" method=\"post\">\n";
//			echo "<input type=\"submit\" class=\"button\" name=\"order\" value=\"Ta bort\">\n";
//			echo "&nbsp;<input type=\"submit\" class=\"button\" name=\"order\" value=\"Klar\">\n";
			echo "</form>\n";
			echo "</table>\n";

		} elseif ($order=="Klar") {
			// Flagga ordern som klar och meddela kunden om detta via mail
			mysql_query("UPDATE orderhuvud SET status='K' WHERE orderID=$orderID");
			// Skapa ett epostmeddelande och skicka det till användaren
			$result = mysql_query("SELECT epost FROM orderhuvud WHERE orderID=$orderID");
			$epost = mysql_result($result, 0, 0);
            $datum_skickat=date("Y-m-d");
			$body = "Tack för din order!\n\rDin beställning har skickats mot postförskott till dig: $datum_skickat.\n\r";
			$body .= "\n\rHoppas du blir nöjd med din beställning!";

            $to      =   $epost;
            $from    =   "stefan@adlertz.se";
            $subject =   utf8_decode("Din order (nr:$orderID) har blivit behandlad!");
            $name    =   $namn;
            $message =   utf8_decode($body);
            if (mail($to, $subject, $message ,"From: $name <$from>")){
                header("Location: admin.php?op=order_visa");
            }
		} elseif ($order=="Ta bort") {
			// Ta bort ordern
//			mysql_query("DELETE FROM orderrad WHERE orderID=$orderID", $dbh);
//			mysql_query("DELETE FROM orderhuvud WHERE orderID=$orderID", $dbh);
			header("Location: admin.php?op=order_visa_betald");
		}
	}
}

function VisaOrderMakulerad() {
	global $dbh;
	// Är personen inloggad?
	if ($_SESSION['inloggad']!='1') {
		// Nej, så vi skickar tillbaka till startsidan
		header("Location: admin.php");
	}
	// Visar alla ordrar som är bekräfade av kunden
	// Ska vi visa en lista över alla ordrar eller visa
	// en specifik order?
	$orderID = $_POST['orderID'];
	if (empty($orderID)) {
		// Ja, visa alla ordrar i en lista
		echo "<center>\n";
		echo "<h5>Administrationsmeny - Visa makulerade ordrar</h5>\n";
		echo "<h5>Välj en order att visa</h5>\n";

		$result = mysql_query("SELECT * FROM orderhuvud WHERE status='M' AND bekraftad=1 ORDER BY orderID DESC", $dbh);
		echo "<table border=\"0\" width='100%' cellpadding='2' cellspacing='0'>\n";
		echo "<tr>\n";
		echo "<td class='vara'>OrderNr</td><td align='left' class='vara'>Beställare</td><td align='right' class='vara'>Antal produkter</td><td align='right' class='vara'>Summa</td>\n";
		echo "<td class='vara' align='right'>&nbsp;</td>\n";
		echo "</tr>\n";
		while($rad = mysql_fetch_array($result)) {
			echo "<form action=\"admin.php\" method=\"post\">\n";
			echo "<input type=\"hidden\" name=\"op\" value=\"order_visa_makulerad\">\n";
			echo "<input type=\"hidden\" name=\"orderID\" value=\"".$rad['orderID']."\">\n";
			echo "<tr>\n";
			echo "<td class='vara'>".$rad['orderID']."</td>\n";
			echo "<td class='vara' align='right'>".$rad['full_namn']."</td>\n";
			echo "<td class='vara' align='right'>".RaknaProdukter($rad['orderID'])."</td>\n";
			echo "<td class='vara' align='right'>".RaknaSumma($rad['orderID'])."</td>\n";
//            <input type=\"submit\" class=\"button\" name=\"order\" value=\"Ta bort\">&nbsp;
			echo "<td class='vara' align='right'><input type=\"submit\" class=\"button\" name=\"order\" value=\"Visa\">\n";
			echo "</tr>\n";
			echo "</form>\n";
		}
		echo "</table>\n";
		echo "</center>\n";
	} else {
		$order = $_POST['order'];
		if ($order=="Visa") {
			// Visa ordern
			$result = mysql_query("SELECT * FROM orderhuvud WHERE orderID=$orderID ORDER BY orderID DESC", $dbh);
			echo "<table cellpadding='2' cellspacing='0' align='center' border=\"0\">\n";
            echo "<center><h5>Administrationsmeny - Visa makulerade ordrar</h5></center>\n";
            echo "<tr><td colspan='4'><h5>Kundinformation</h5></td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'full_namn')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'adress1')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'adress2')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'postnr')."  ".mysql_result($result, 0, 'postadress')."<br>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'telefon')."</td></tr>\n";
			echo "<tr><td colspan='4'>".mysql_result($result, 0, 'mobiltelefon')."</td></tr>\n";
            echo "<tr><td colspan='4'><a href='mailto:".mysql_result($result, 0, 'epost')."?subject=Ordernummer: $orderID'>".mysql_result($result, 0, 'epost')."</a></td></tr>\n";
            echo "<tr><td>&nbsp;</td></tr>";

            echo "<tr><td colspan='4'><h5>Orderinformation</h5></td></tr>\n";
            echo "<tr><td>Ordernr: </td>\n";
            echo "<td>".$orderID."</td></tr>\n";
            echo "<tr><td>Mottagen: </td>\n";
            echo "<td>".mysql_result($result, 0, 'skapad')."</td></tr>\n";
            echo "<tr><td>Bekräftad: </td>";
            echo "<td>".mysql_result($result, 0, 'senast_aktiv')."</tr>\n";
            echo "<tr><td>&nbsp;</td></tr>\n";
            echo "<tr>";
			echo "<td>Produkt ID</td><td>Produktbeskrivning</td><td>a'pris</td><td>Antal</td><td>Summa</td>\n";
			echo "</tr>\n";
			$result = mysql_query("SELECT produkter.prodID, produkter.beskrivning, produkter.pris, orderrad.antal FROM produkter, orderrad WHERE orderrad.orderID=$orderID AND produkter.prodID=orderrad.prodID", $dbh);
			$totalsumma = 0;
			while($rad = mysql_fetch_array($result)) {
				echo "<tr>\n";
				echo "<td>".$rad['prodID']."</td>\n";
				echo "<td>".$rad['beskrivning']."</td>\n";
				echo "<td align='right'>".$rad['pris']."</td>\n";
				echo "<td align='right'>".$rad['antal']."</td>\n";
				$summa = ($rad['pris']*$rad['antal']);
				echo "<td align='right'>$summa</td>\n";
				echo "</tr>\n";
				$totalsumma = $totalsumma + $summa;
			}
			echo "<tr><td align='right' colspan=\"4\"><b>Summa totalt:</b></td>\n";
			echo "<td align='right'><b>$totalsumma</b></td></tr>\n";
            echo "<tr><td><form action=\"admin.php\" method=\"post\"></td></tr>\n";
			echo "<tr><td><input type=\"hidden\" name=\"op\" value=\"order_visa_makulerad\"></td></tr>\n";
			echo "<tr><td><input type=\"hidden\" name=\"orderID\" value=\"".$orderID."\"></td></tr>\n";
			echo "<tr><td colspan='4'><input type=\"submit\" class=\"button\" name=\"order\" value=\"Nya ordrar\"></td></tr>\n";
//			echo "&nbsp;<input type=\"submit\" class=\"button\" name=\"order\" value=\"Klar\">\n";
			echo "</form>\n";
			echo "</table>\n";

		} elseif ($order=="Klar") {

		} elseif ($order=="Nya ordrar") {
			// Ta bort ordern
            mysql_query("UPDATE orderhuvud SET status='V' WHERE orderID=$orderID");
//			mysql_query("DELETE FROM orderrad WHERE orderID=$orderID", $dbh);
//			mysql_query("DELETE FROM orderhuvud WHERE orderID=$orderID", $dbh);
			header("Location: admin.php?op=order_visa_makulerad");
		}
	}
}

#################################### WebShop ###################################

function LaggTillVara() {
	global $dbh;
	// Har vi en order att fylla på?
	if (empty($_SESSION['orderID'])) {
		// Nej, så skapa en ny order först
		$_SESSION['orderID'] = SkapaNyOrder();
	}
	$orderID = $_SESSION['orderID'];
	$prodID = $_GET['prodID'];
	$antal = $_GET['antal'];
	$kat = $_GET['kat'];
	// Kontrollera först om produkten redan finns i ordern
	// i så fall ökar vi bara antalet
	$query = "SELECT COUNT(*) FROM orderrad WHERE orderID=$orderID AND prodID=$prodID";
	$result = mysql_query($query, $dbh);
	if (mysql_result($result, 0, 0) != 0) {
		// Ja, produkten fanns, så öka bara antalet
		$query = "UPDATE orderrad SET antal=antal+$antal WHERE orderID=$orderID AND prodID=$prodID";
		$result = mysql_query($query, $dbh);
	} else {
		// Nej, fanns inte så lägg till produkten i ordern
		$query = "INSERT INTO orderrad(orderID, prodID, antal) VALUES($orderID, $prodID, $antal)";
		$result = mysql_query($query, $dbh);
	}
	Header("Location: index.php?kat=$kat");
}

function RaknaProdukter($orderID) {
	global $dbh;
	// Räknar hur många unika produkter det finns i en order
	$result = mysql_query("SELECT COUNT(*) FROM orderrad WHERE orderID=$orderID", $dbh);
	return mysql_result($result, 0, 0);
}

function RaknaSumma($orderID) {
	global $dbh;
	// Räknar ut totalsumman i en order
	$summa = 0;
	$result = mysql_query("SELECT produkter.pris, orderrad.antal FROM produkter, orderrad WHERE orderrad.orderID=$orderID AND orderrad.prodID=produkter.prodID", $dbh);
	while($rad = mysql_fetch_array($result)) {
		$summa = $summa + ($rad['pris']*$rad['antal']);
	}
	return $summa;
}

function VisaProdukter() {
	global $dbh;

	// Visar alla produkter i en viss kategori
	$kat=$_GET['kat'];
	if (!empty($kat)) {
		echo "<table width='100%' cellpadding='2' cellspacing='0' border=\"0\">\n";
		echo "<tr>\n";
		echo "<td class='vara' width=\"50\">&nbsp;</td>\n";
		echo "<td class='vara' align=\"left\"width=\"400\">Vara (klicka på rubrik för produktinformation)</td>\n";
		echo "<td class='vara' align=\"right\">Pris SEK</td>\n";
		echo "<td class='vara'>&nbsp;</td>\n";
		echo "</tr>\n";

		$query = "SELECT * FROM produkter WHERE kategoriID=$kat";
		$result = mysql_query($query, $dbh);
		while($rad=mysql_fetch_array($result)) {
			echo "<form method=\"get\" action=\"index.php\">\n";
			echo "<tr>\n";
			echo "<td class='vara'><img src=\"prod_bild_tmb.php?prodID=".$rad['prodID']."\"></td>\n";
            echo "<td class='vara' align=\"left\" valign=\"bottom\"<b><a href=\"index.php?prod=prod&prodID={$rad['prodID']}\">".'<b>'.$rad['rubrik'].'</b>'."</a></b></td>\n";
			echo "<td class='vara' align=\"right\" valign=\"bottom\">".$rad['pris']."</td>\n";
			echo "<td class='vara' align=\"right\" valign=\"bottom\"><input type=\"text\" size=\"5\" name=\"antal\" value=\"1\"><input type=\"submit\" class='add_cart' value=\"\"></td>\n";
			echo "<tr>\n";
			echo "<input type=\"hidden\" name=\"prodID\" value=\"".$rad['prodID']."\">\n";
			echo "<input type=\"hidden\" name=\"op\" value=\"lagg_till\">\n";
			echo "<input type=\"hidden\" name=\"kat\" value=\"$kat\">\n";
			echo "</form>\n";
            echo "</tr>\n";
		}
        echo "</table>\n";

    }
    $prod=($_GET['prod']);
    $prodID=($_GET['prodID']);
    if ($prod=='prod'){
        $query = "SELECT * FROM produkter WHERE prodID=$prodID";
        $result = mysql_query($query, $dbh);
        while($rad = mysql_fetch_array($result)) {
            echo "<table  width='650' cellpadding='2' cellspacing='0' border=\"0\">\n";
            echo "<tr>\n";
            echo "<td class='vara' align=\"left\" valign=\"bottom\">".'<b>'.$rad['rubrik'].'</b>'."</td>\n";
            echo "<td class='vara' align=\"left\" valign=\"bottom\">&nbsp;</td>\n";
            echo "</tr>\n";
            echo "<tr>\n";
            echo "<td class='vara' width='50' align=\"left\" valign=\"top\"><img src=\"prod_bild.php?prodID=" .$rad['prodID']."\"></td>\n";
            echo "<td class='vara' width='100%' align=\"left\" valign=\"top\">".$rad['beskrivning']."</td>\n";
            echo "</tr>\n";
            echo "<tr>\n";
            echo "<form method=\"get\" action=\"index.php\">\n";
            echo "<td colspan='2' width='100%' align=\"right\" valign=\"bottom\">".'Pris SEK '.$rad['pris'].' '."<input type=\"text\" size=\"5\" name=\"antal\" value=\"1\"><input type=\"submit\" class='add_cart' value=\"\"></td>\n";
            echo "<input type=\"hidden\" name=\"prodID\" value=\"".$rad['prodID']."\">\n";
			echo "<input type=\"hidden\" name=\"op\" value=\"lagg_till\">\n";
			echo "<input type=\"hidden\" name=\"kat\" value=\"{$rad['kategoriID']}\">\n";
			echo "</form>\n";
            echo "</tr>\n";
            echo "</table>\n";
        }
    }

    if ($prod=='') {
		if ($kat==''){
        // Ingen kategori vald så visa huduvsidans innehåll
		echo "Inget till salu här - bara demosajt";
        }
	}
}

function SkapaNyOrder() {
	global $dbh;
	// Skapar en ny order och returnerar ordernummret
	$datum = date("Y-m-d H:i:s");
	$query = "INSERT INTO orderhuvud(skapad, senast_aktiv) VALUES('$datum','$datum')";
	$result = mysql_query($query, $dbh);
	return mysql_insert_id($dbh);
}

function VisaKorgen() {
	global $dbh;
	// Visar alla produkter i varukorgen om det finns några
	if (AntalKorgen()!=0) {

	$query = "SELECT produkter.rubrik, produkter.pris, orderrad.antal, orderrad.prodID FROM produkter, orderrad WHERE produkter.prodID=orderrad.prodID AND orderrad.orderID=".$_SESSION['orderID'];
	$result = mysql_query($query, $dbh);
	// Vi använder ett dolt formulär för att skicka data tillsammans med JavaScript
	echo "<form action=\"index.php\" method=\"get\" name=\"varukorg\">\n";
	echo "<input type=\"hidden\" name=\"op\">\n";
	echo "<input type=\"hidden\" name=\"prodID\">\n";
	echo "<input type=\"hidden\" name=\"antal\">\n";
	echo "</form>\n";
	echo "<table width='100%' cellpadding='2' cellspacing='0' border=\"0\">\n";
	echo "<tr>\n";
	echo "<td class='vara' width=\"200\">Vara</td>\n";
	echo "<td class='vara' align='left'>a' pris SEK</td>\n";
	echo "<td class='vara' align='left'>Antal</td>\n";
	echo "<td class='vara' align='right'>Summa SEK</td>\n";
	echo "<td class='vara' >&nbsp;</td>\n";
	echo "</td>\n";
    $Summa_tot;
	while ($rad=mysql_fetch_array($result)) {
        $Summa_tot=$Summa_tot+($rad['pris']*$rad['antal']);
		echo "<input type=\"hidden\" name=\"op\">\n";
		echo "<tr>\n";
		echo "<td class='vara' align=\"left\"valign=\"bottom\"><b>{$rad['rubrik']}</b></td>\n";
		echo "<td class='vara' align=\"left\"valign=\"bottom\">{$rad['pris']}</td>\n";
		echo "<td class='vara' align=\"left\"valign=\"bottom\"><input type=\"text\" size=\"5\" name=\"antal_".$rad['prodID']."\" value=\"".$rad['antal']."\"></td>\n";
		echo "<td class='vara' align=\"right\"valign=\"bottom\">".($rad['pris']*$rad['antal'])."</td>\n";
		echo "<td class='vara' align='right'>\n";
		echo "<input type=\"button\" class='add_cart' value=\"\" onClick=\"FormularData('andra','".$rad['prodID']."',antal_".$rad['prodID'].".value);\">\n";
		echo "<input type=\"button\" class='delete_cart' value=\"\" onClick=\"FormularData('tabort','".$rad['prodID']."','')\">\n";
		echo "</td>\n";
		echo "</tr>\n";
	}
    echo "<tr>\n";
    echo "<td colspan='4' align='right'>\n";
    echo "<br>";
    echo "<b>Summa totalt SEK:&nbsp;".$Summa_tot."</b>";
    echo "</td>\n";
    echo "<td>\n";
    echo "&nbsp;";
    echo "</td>\n";
    echo "</tr>\n";

	echo "</table>\n";
	echo "<center>\n";
	echo "<form action=\"index.php\" method=\"get\" name=\"varukorg_hantering\">\n";
	echo "<input type=\"hidden\" name=\"op\">\n";
	echo "<input type=\"button\" class='button' value=\"Töm varukorg\" onClick=\"TomVarukorg();\">\n";
	echo "<input type=\"button\" class='button' value=\"Skicka order\" onClick=\"SkickaVarukorg();\">\n";
	echo "</form>\n";
	echo "</center>\n";

	} else {
		Header("Location: index.php");
	}
}

function AndraAntal() {
	global $dbh;
	// Ändrar antalet i varukorgen för en viss produkt
	$prodID = $_GET['prodID'];
	$antal = $_GET['antal'];
	$orderID = $_SESSION['orderID'];
	// Matade kunden in 0 som antal tar vi bort produkten ur varukorgen
	if ($antal==0) {
		$query = "DELETE FROM orderrad WHERE orderID=$orderID AND prodID=$prodID";
		mysql_query($query, $dbh);
	} else {
		// Vi sätter nytt antal
		$query = "UPDATE orderrad SET antal=$antal WHERE orderID=$orderID AND prodID=$prodID";
		mysql_query($query, $dbh);
	}
	Header("Location: index.php?op=visa_korg");
}

function TabortProdukt() {
	global $dbh;
	// Tar bort en produkt ur varukorgen
	$prodID = $_GET['prodID'];
	$orderID = $_SESSION['orderID'];
	$query = "DELETE FROM orderrad WHERE orderID=$orderID AND prodID=$prodID";
	mysql_query($query, $dbh);

    $query = "SELECT COUNT(*) FROM orderrad WHERE orderID=$orderID";
	$result = mysql_query($query, $dbh);
	if (mysql_result($result, 0, 0) == 0) {
        $query = "DELETE FROM orderhuvud WHERE orderID=$orderID";
        $_SESSION['orderID'] = '';
		$result = mysql_query($query, $dbh);
	}

	Header("Location: index.php?op=visa_korg");
}

function TabortOrder() {
	global $dbh;
	// Tar bort en hel order och nollställer sessionen (ingen order)
	$orderID = $_SESSION['orderID'];
	$query = "DELETE FROM orderhuvud WHERE orderID=$orderID";
	mysql_query($query, $dbh);
	$query = "DELETE FROM orderrad WHERE orderID=$orderID";
	mysql_query($query, $dbh);
	$_SESSION['orderID'] = '';
}

function VisaOrderuppgifter() {
	// Formuläret kunden måste fylla i
	echo "<center>\n";
	echo "<form action=\"index.php\" method=\"get\">\n";
	echo "<input type=\"hidden\" name=\"op\" value=\"skickaorder2\">\n";
	echo "<table border=\"0\">\n";
    echo "<br><h5>Var vänlig fyll i dina namn och adress uppgifter.</h5>\n";
	echo "<h5>Det är viktigt du har en fungerande
          epostadress för att kunna bekräfta ordern.</h5>\n";
	echo "<tr>\n";
	echo "<td>Fullständigt namn:</td>\n";
	echo "<td><input type=\"\" name=\"namn\"></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Adress:</td>\n";
	echo "<td><input type=\"\" name=\"adress1\"></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Adress:</td>\n";
	echo "<td><input type=\"\" name=\"adress2\"></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Postnr:</td>\n";
	echo "<td><input type=\"\" name=\"postnr\"></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Postadress:</td>\n";
	echo "<td><input type=\"\" name=\"postadress\"></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Telefon:</td>\n";
	echo "<td><input type=\"\" name=\"telefon\"></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Mobiltelefon:</td>\n";
	echo "<td><input type=\"\" name=\"mobiltelefon\"></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Epost:</td>\n";
	echo "<td><input type=\"\" name=\"epost\"></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td colspan=\"2\" align=\"center\"><input type=\"submit\" class='button' value=\"Skicka order\"></td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</form>\n";
	echo "</center>\n";
}

function SkickaOrder() {
	global $dbh;
	// Sätter ordern som väntande på bekräftelse från kunden och
	// skickar samtidigt ett meddelande om att ordern måste bekräftas
	// till kundens epostadress. Givetvis måste kunden först fyllt i
	// sina uppgifter
	$namn = $_GET['namn'];
	$adress1 = $_GET['adress1'];
	$adress2 = $_GET['adress2'];
	$postnr = $_GET['postnr'];
	$postadress = $_GET['postadress'];
	$telefon = $_GET['telefon'];
	$mobiltelefon = $_GET['mobiltelefon'];
	$epost = $_GET['epost'];
	$orderID = $_SESSION['orderID'];

	// Vi använder även sessionen ID i bekräftelsen (lite mer säkerhet bara)
	$sid = session_id();
	$datum = date("Y-m-d H:i:s");
	$query = "UPDATE orderhuvud SET status='V', bekraftID='$sid', senast_aktiv='$datum', full_namn='$namn', adress1='$adress1', adress2='$adress2', postnr='$postnr', postadress='$postadress', telefon='$telefon', mobiltelefon='$mobiltelefon', epost='$epost' WHERE orderID=$orderID";
	mysql_query($query, $dbh);

	// Skapa ett epostmeddelande och skicka det till användaren

	$body = "Tack för din order!\n\rDin beställning kommer att skickas mot postförskott till:\n\r\n\r";
	$body .= "$namn\n\r$adress1\n\r$adress2\n\r$postnr  $postadress\n\r";
	$body .= "\n\r\n\rDu måste bekräfta din order genom att klicka på länken nedan.\n\r";
	$body .= "http://www.adlertz.se/webshop/confirm.php?orderID=$orderID&confirm=$sid";
	$body .= "\n\r\n\rOm adressuppgifterna är felaktiga kan du aktivera din order på webbshopen och\n\r";
	$body .= "skicka din order igen genom att klicka på länken nedan. På så sätt får du fylla i dina adressuppgifter igen.\n\r";
	$body .= "http://www.adlertz.se/webshop/reactivate.php?orderID=$orderID&confirm=$sid\n\r";
	$body .= "\n\rDu har beställt följande produkter:\n\r\n\r";
    $result = mysql_query("SELECT produkter.prodID, produkter.beskrivning, produkter.pris, orderrad.antal FROM produkter, orderrad WHERE orderrad.orderID=$orderID AND produkter.prodID=orderrad.prodID", $dbh);
			    $totalsumma = 0;
    			while($rad = mysql_fetch_array($result)) {
                $body .="---------------------------------------------\n\r";
                $body .=$rad['antal']." st: ".$rad['prodID']." ";
				$body .=$rad['beskrivning']."\n\r";
				$body .="Pris: ".$rad['pris']."\n\r";
				$summa = ($rad['pris']*$rad['antal']);
				$body .="Summa: ".$summa."\n\r";
				$totalsumma = $totalsumma + $summa;
			}
    $body .="---------------------------------------------\n\r";
    $body .="Totalsumma: ".$totalsumma."\n\r";
    $body .="\n\r";
	$body .= "\n\rHoppas du blir nöjd med din beställning!";

    $to      =   $epost;
    $from    =   "stefan@adlertz.se";
    $subject =   utf8_decode("Bekräftelse av ordernr: $orderID");
    $name    =   $namn;
    $message =   utf8_decode($body);

    if (mail($to, $subject, $message ,"From: $name <$from>"))

	// Nollställ sessionen för orderID
	$_SESSION['orderID'] = '';
	Header("Location: index.php?op=tack");
}

function VisaTack() {
	// Visar tacksidan för beställningen
	echo "<center>\n";
	echo "<br><h5>Tack för din beställning!<br><br>Du kommer att få ett epostmeddelande som innehåller en <br>länk som du måste klicka på för att bekräfta beställningen.</h5>\n";
	echo "</center>\n";
}

################################################################################

?>
