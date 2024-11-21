<?php
session_start();
include "__config.php";
include "__connect_database.php";

#################################### CRM Sida ##################################

function LoggaIn() {

		if (empty($_POST['namn']) || empty($_POST['losen'])) {

            echo "<div class=\"box\">";
            echo "<form action=\"index.php?op=logga_in\" method=\"post\">";
            echo "<table border=0>";
			
			echo "<tr>";
			echo "<td>";
			
			echo "<table border=0>";
			echo "<tr>";
			echo "<td><table border=0>";
			
			echo "<tr><td>Epost:</td></tr>";
            echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"epost\" value=\"\"></td></tr>";
            echo "<tr><td>Password:</td></tr>";
            echo "<tr><td><input class=\"skugga\" type=\"password\" name=\"password\" value=\"\"></td></tr>";
            echo "<tr><td>&nbsp;</td></tr>";
            echo "<tr><td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"spara\" value=\"Logga in\"></td></tr>";
            echo "<tr><td>&nbsp;</td></tr>";
            echo "<tr><td><b><a href=\"index.php?op=kontakt_saljare_ny\">Registrera Säljare</a></b></td></tr>";
			
			
			echo "</table></td>";
			echo "<td><table border=0>";
			
			echo "<tr><td><img src=\"images/crm.png\" border=\"0\"></td></tr>";
			
			echo "</table></td>";
			echo "</tr>";
			
			
			echo "</table>";
			
			echo "</td>";
			echo "</tr>";
			
			
            	
			
			
			
			echo "<tr><td>&nbsp;</td></tr>";
            echo "<tr><td>Välkommen till <b>crm.adlertz.se</b>, sajten är gjord i Objektorienterad PHP och DB:n My SQL och är klar och funkar. </br>				  Men jag är inte klar med  hur knappar och menyer skall placeras. </br>				  Kollar även på hur det skall kunna integreras med shop.adlertz.se (senare). </br></br>
                  Logga in med <b>guest@adlertz.se :: guest</b> , ögna igenom och lämna gärna synpunkter <a href=http://www.adlertz.se/index.php?op=kontakt><b>här</b></a></td></tr>";
            echo "</table>";
			echo "</form>";
            echo "</div>";

		}
        
        if (!empty($_POST['epost']) || !empty($_POST['password'])) {

            $password=$_POST['password'];
            $epost=$_POST['epost'];

            $sql=mysql_query("SELECT * FROM crm_saljare WHERE password='$password' AND epost='$epost'");

            $password=mysql_result($sql, 0, 'password');
            if (!empty($password)) {

                $_SESSION['inloggad']='crm';
                $_SESSION['saljar_ID']=mysql_result($sql, 0, 'saljar_ID');
                $_SESSION['arbetsgrupps_ID']=mysql_result($sql, 0, 'arbetsgrupps_ID');
                $_SESSION['fnamn']=mysql_result($sql, 0, 'fnamn');
                $_SESSION['enamn']=mysql_result($sql, 0, 'enamn');
                $_SESSION['personnummer']=mysql_result($sql, 0, 'personnummer');
                $_SESSION['telefon']=mysql_result($sql, 0, 'telefon');
                $_SESSION['mobil']=mysql_result($sql, 0, 'mobil');
                $_SESSION['epost']=mysql_result($sql, 0, 'epost');
                $_SESSION['ovrigt']=mysql_result($sql, 0, 'ovrigt');
                header("Location: index.php");

            }

            if (empty($password)) {
                echo "Fel epostadress eller fel password!";
            }
        }
//        header("Location: index.php?op=logga_in");
//
}

function LoggaUt() {
    $_SESSION['inloggad']='';
    $_SESSION['saljar_ID']='';
    $_SESSION['arbetsgrupps_ID']='';
    $_SESSION['fnamn']='';
    $_SESSION['enamn']='';
    $_SESSION['personnummer']='';
    $_SESSION['telefon']='';
    $_SESSION['mobil']='';
    $_SESSION['epost']='';
    $_SESSION['ovrigt']='';
	header("Location: index.php");
}

function CrmSida() {
    if (empty($_SESSION['inloggad'])) {
        header("Location: index.php?op=logga_in");
    }

    if (!empty($_SESSION['inloggad'])) {
        if (empty($_SESSION['arbetsgrupps_ID'])) {

        }

        if (!empty($_SESSION['arbetsgrupps_ID'])) {

        }
        
    }
}

function ForetagSok() {

    echo "<div class=\"box\">";
    echo "<form action=\"index.php?op=foretag_sok\" method=\"post\">";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
    echo "<tr>";
    echo "<td><input type=\"text\" class=\"skugga\" name=\"foretagsnamn\" value=\"\"></td>";
    echo "<td>&nbsp;<input type=\"submit\" class=\"button_s\" value=\"Sök\"></td>";
    echo "</tr>";
    echo "<tr><td>&nbsp;</td></tr>";

    echo "</table>";
    echo "</form>";
    echo "</div>";


    $foretagsnamn=$_POST['foretagsnamn'];

    if(!empty($foretagsnamn)) {
    
        $foretag = array();

        $sql=mysql_query("SELECT * FROM crm_foretag WHERE foretagsnamn LIKE '$foretagsnamn%' AND arbetsgrupps_ID={$_SESSION['arbetsgrupps_ID']}");

        echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";

        while($rad = mysql_fetch_array($sql)) {

            $foretags_ID=$rad['foretags_ID'];
            $foretagsnamn=$rad['foretagsnamn'];
            $adress=$rad['adress'];
            $leveransadress=$rad['leveransadress'];
            $postnr=$rad['postnr'];
            $postadress=$rad['postadress'];
            $orgnummer=$rad['orgnummer'];
            $telefon=$rad['telefon'];
            $mail=$rad['epost'];
            $ovrigt=$rad['ovrigt'];

            $foretag[$foretags_ID]=new foretag($foretags_ID,$foretagsnamn,$adress,$leveransadress,$postnr,$postadress,$orgnummer,$telefon,$mail,$ovrigt);

            $foretags_ID=$foretag[$foretags_ID]->getforetags_ID();
            $foretagsnamn=$foretag[$foretags_ID]->getforetagsnamn();
            $adress=$foretag[$foretags_ID]->getadress();
            $leveransadress=$foretag[$foretags_ID]->getleveransadress();
            $postnr=$foretag[$foretags_ID]->getpostnr();
            $postadress=$foretag[$foretags_ID]->getpostadress();
            $orgnummer=$foretag[$foretags_ID]->getorgnummer();
            $telefon=$foretag[$foretags_ID]->gettelefon();
            $mail=$foretag[$foretags_ID]->getepost();
            $ovrigt=$foretag[$foretags_ID]->getovrigt();

            if ($bg=='') {
                $bg='td_white';
            }

            if ($bg=='td_blue') {
                $bg='td_white';
                $bg_side='td_bg_white_side';
            }

            else{
                $bg='td_blue';
                $bg_side='td_blue_side';
            }

            echo "<tr>";
            echo "<form action=\"index.php?op=foretag_visa\" method=\"post\">";
            echo "<input type=\"hidden\" name=\"foretags_ID\" value=\"$foretags_ID\">";
            echo "<td valign=\"middle\" width=\"1\" class=\"$bg_side\"></td>";
            echo "<td valign=\"middle\" width=\"200\" class=\"$bg\"><b>".$foretagsnamn."&nbsp</b></td>";
            echo "<td valign=\"middle\" width=\"200\" class=\"$bg\"><b>".$adress."&nbsp</b></td>";
            echo "<td valign=\"middle\" width=\"100\" class=\"$bg\"><b>".$postnr."&nbsp</b></td>";
            echo "<td valign=middle width=\"198\" class=\"$bg\"><b>".$postadress."&nbsp</b></td>";
            echo "<td valign=\"middle\" width=\"1\" class=\"$bg_side\"></td>";
            echo "<td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"visa\" value=\"Visa\"></td>";
            echo "</form>";
            echo "</tr>";
        }

        $_SESSION['foretag']=serialize($foretag);

        echo "</table>";
    
    }

}

function ForetagLista() {

    $foretag = array();

    $sql=mysql_query("SELECT * FROM crm_foretag WHERE foretagsnamn LIKE '$foretagsnamn%' AND arbetsgrupps_ID={$_SESSION['arbetsgrupps_ID']}");

    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";

    while($rad = mysql_fetch_array($sql)) {

	$foretags_ID=$rad['foretags_ID'];
        $foretagsnamn=$rad['foretagsnamn'];
        $adress=$rad['adress'];
        $leveransadress=$rad['leveransadress'];
        $postnr=$rad['postnr'];
        $postadress=$rad['postadress'];
        $orgnummer=$rad['orgnummer'];
        $telefon=$rad['telefon'];
        $mail=$rad['epost'];
        $ovrigt=$rad['ovrigt'];

        $foretag[$foretags_ID]=new foretag($foretags_ID,$foretagsnamn,$adress,$leveransadress,$postnr,$postadress,$orgnummer,$telefon,$mail,$ovrigt);

        $foretags_ID=$foretag[$foretags_ID]->getforetags_ID();
        $foretagsnamn=$foretag[$foretags_ID]->getforetagsnamn();
        $adress=$foretag[$foretags_ID]->getadress();
        $leveransadress=$foretag[$foretags_ID]->getleveransadress();
        $postnr=$foretag[$foretags_ID]->getpostnr();
        $postadress=$foretag[$foretags_ID]->getpostadress();
        $orgnummer=$foretag[$foretags_ID]->getorgnummer();
        $telefon=$foretag[$foretags_ID]->gettelefon();
        $mail=$foretag[$foretags_ID]->getepost();
        $ovrigt=$foretag[$foretags_ID]->getovrigt();

        if ($bg=='') {
            $bg='td_bg_white';
        }

        if ($bg=='td_blue') {
            $bg='td_white';
            $bg_side='td_white_side';
        }

        else{
            $bg='td_blue';
            $bg_side='td_blue_side';
        }

        echo "<tr>";
        echo "<form action=\"index.php?op=foretag_visa\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"foretags_ID\" value=\"$foretags_ID\">";
        echo "<td valign=\"middle\" width=\"1\" class=\"$bg_side\"></td>";
        echo "<td valign=\"middl\"e width=\"200\" class=\"$bg\"><b>".$foretagsnamn."&nbsp</b></td>";
        echo "<td valign=\"middle\" width=\"200\" class=\"$bg\"><b>".$adress."&nbsp</b></td>";
        echo "<td valign=\"middle\" width=\"100\" class=\"$bg\"><b>".$postnr."&nbsp</b></td>";
        echo "<td valign=\"middle\" width=\"198\" class=\"$bg\"><b>".$postadress."&nbsp</b></td>";
        echo "<td valign=\"middle\" width=\"1\" class=\"$bg_side\"></td>";
        echo "<td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"visa\" value=\"Visa\"></td>";
        echo "</form>";
        echo "</tr>";
    }

    $_SESSION['foretag']=serialize($foretag);

    echo "</table>";

}

function ForetagListaAterkontakt() {

    $idag = date("Y-m-d");

    $sql=mysql_query("SELECT * FROM crm_kontakt WHERE aterkontaktdatum <= '$idag' AND kontaktad='0' AND arbetsgrupps_ID={$_SESSION['arbetsgrupps_ID']}");

    while ($rad=mysql_fetch_array($sql)) {

        $sql2=mysql_query("SELECT * FROM crm_foretag WHERE foretags_ID={$rad['foretags_ID']}");

        echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";

        while ($rad2=mysql_fetch_array($sql2)) {

        $foretags_ID=$rad2['foretags_ID'];
        $foretagsnamn=mysql_result($sql2, 0, 'foretagsnamn');
        $adress=mysql_result($sql2, 0, 'adress');
        $leveransadress=mysql_result($sql2, 0, 'leveransadress');
        $postnr=mysql_result($sql2, 0, 'postnr');
        $postadress=mysql_result($sql2, 0, 'postadress');
        $orgnummer=mysql_result($sql2, 0, 'orgnummer');
        $telefon=mysql_result($sql2, 0, 'telefon');
        $mail=mysql_result($sql2, 0, 'epost');
        $ovrigt=mysql_result($sql2, 0, 'ovrigt');

        $foretag[$foretags_ID]=new foretag($foretags_ID,$foretagsnamn,$adress,$leveransadress,$postnr,$postadress,$orgnummer,$telefon,$mail,$ovrigt);

        $foretags_ID=$foretag[$foretags_ID]->getforetags_ID();
        $foretagsnamn=$foretag[$foretags_ID]->getforetagsnamn();
        $adress=$foretag[$foretags_ID]->getadress();
        $leveransadress=$foretag[$foretags_ID]->getleveransadress();
        $postnr=$foretag[$foretags_ID]->getpostnr();
        $postadress=$foretag[$foretags_ID]->getpostadress();
        $orgnummer=$foretag[$foretags_ID]->getorgnummer();
        $telefon=$foretag[$foretags_ID]->gettelefon();
        $mail=$foretag[$foretags_ID]->getepost();
        $ovrigt=$foretag[$foretags_ID]->getovrigt();

        if ($bg=='') {
            $bg='td_white';
        }

        if ($bg=='td_blue') {
            $bg='td_white';
            $bg_side='td_white_side';
        }

        else{
            $bg='td_blue';
            $bg_side='td_blue_side';
        }

        echo "<tr>";
        echo "<form action=\"index.php?op=foretag_visa\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"foretags_ID\" value=\"$foretags_ID\">";
        echo "<td valign=\"middle\" width=\"1\" class=\"$bg_side\"></td>";
        echo "<td valign=\"middle\" width=\"200\" class=\"$bg\"><b>".$foretagsnamn."&nbsp</b></td>";
        echo "<td valign=\"middle\" width=\"200\" class=\"$bg\"><b>".$adress."&nbsp</b></td>";
        echo "<td valign=\"middle\" width=\"100\" class=\"$bg\"><b>".$postnr."&nbsp</b></td>";
        echo "<td valign=\"middle\" width=\"198\" class=\"$bg\"><b>".$postadress."&nbsp</b></td>";
        echo "<td valign=\"middle\" width=\"1\" class=\"$bg_side\"></td>";
        echo "<td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"visa\" value=\"Visa\"></td>";
        echo "</form>";
        echo "</tr>";
    }

    $_SESSION['foretag']=serialize($foretag);

    echo "</table>";

    }
}

function ForetagVisa() {

if(!empty($_POST['foretags_ID'])) {
    $_SESSION['foretags_ID']=$_POST['foretags_ID'];
}

echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr>";
echo "<td class=\"fv_top\" valign=\"top\">";

    $foretag=unserialize($_SESSION['foretag']);

    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"150\"><tr>";
    echo "<td valign=\"middle\" class=\"fv_table\"><b>Företagsfakta:</b></td></tr>";
    echo "<tr><td>".$foretag[$_SESSION['foretags_ID']]->getforetagsnamn()."</td></tr>";
    echo "<tr><td>".$foretag[$_SESSION['foretags_ID']]->getadress()."</td></tr>";
    echo "<tr><td>".$foretag[$_SESSION['foretags_ID']]->getleveransadress()."</td></tr>";
    echo "<tr><td>".$foretag[$_SESSION['foretags_ID']]->getpostnr()."</td></tr>";
    echo "<tr><td>".$foretag[$_SESSION['foretags_ID']]->getpostadress()."</td></tr>";
    echo "<tr><td>".$foretag[$_SESSION['foretags_ID']]->getorgnummer()."</td></tr>";
    echo "<tr><td>".$foretag[$_SESSION['foretags_ID']]->gettelefon()."</td></tr>";
    echo "<tr><td>".$foretag[$_SESSION['foretags_ID']]->getepost()."</td>";
    echo "</tr></table>";

echo "</td>";

echo "<td class=\"fv_top\" valign=\"top\">";
echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"182\">";
echo "<tr><td valign=\"middle\" class=\"fv_table\"><b>Övrigt:</b></td></tr>";
echo "<tr><td>".$foretag[$_SESSION['foretags_ID']]->getovrigt()."</td></tr>";
echo "</table>";
echo "</td>";

echo "<td class=\"fv_top\" valign=\"top\">";

    $sql=mysql_query("SELECT * FROM crm_kontaktpersoner WHERE foretags_ID='{$_SESSION['foretags_ID']}'");

    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"168\">";
    echo "<tr><td valign=\"middle\" class=\"fv_table\"><b>Kontaktpersoner:</b></td></tr>";
    while($rad = mysql_fetch_array($sql)) {

        $kontaktperson_ID=$rad['kontaktperson_ID'];
        $fnamn=substr($rad['fnamn'], 0, 13);
        $enamn=substr($rad['enamn'], 0, 13);
        $fnamn2=$rad['fnamn'];
        $enamn2=$rad['enamn'];
        $titel=$rad['titel'];
        $telefon=$rad['telefon'];
        $mobil=$rad['mobil'];
        $epost=$rad['epost'];
        $ovrigt=$rad['ovrigt'];
        
        ?>
	<tr onMouseOver="show_popup('<?php echo $fnamn2 ."<br>". $enamn2 ."<br>". $titel ."<br>". $telefon ."<br>". $mobil ."<br>". $epost ."<br>". $ovrigt ?>')" onMouseout=hide_popup();>
        <?php
        echo "<td><a href=\"index.php?op=foretag_visa&op2=kontaktperson_visa&kontaktperson_ID=$kontaktperson_ID\">$fnamn,&nbsp;$enamn</a></td></tr>";

    }
    echo "<tr><td>&nbsp;</td></tr>";
    echo "</table>";

echo "</td>";

echo "<td class=\"fv_top_right\" valign=\"top\">";

    $sql=mysql_query("SELECT * FROM crm_kontakt WHERE foretags_ID='{$_SESSION['foretags_ID']}'");

    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"200\">";
    echo "<tr><td valign=\"middle\" class=\"fv_table\" colspan=\"3\"><b>Kontakttillfällen:</b></td></tr>";

    while($rad = mysql_fetch_array($sql)) {

        $kontakt_ID=$rad['kontakt_ID'];
        $kontaktkategori_ID=$rad['kontaktkategori_ID'];
        
        $sql2=mysql_query("SELECT kategori FROM crm_kontaktkategori WHERE kontaktkategori_ID=$kontaktkategori_ID");
        $kategori=substr(mysql_result($sql2, 0, 'kategori'), 0, 8);

        $kontaktdatum=$rad['kontaktdatum'];
        $aterkontaktdatum=$rad['aterkontaktdatum'];
        $ovrigt=$rad['ovrigt'];

        ?>
        <tr onMouseOver="show_popup('<?php echo $ovrigt ?>')" onMouseout=hide_popup();>
        <?php
        echo "<td><a href=\"index.php?op=foretag_visa&op2=kontakt_visa&kontakt_ID=$kontakt_ID\">".$kontaktdatum."</a></td>";
        echo "<td>&nbsp;<a href=\"index.php?op=foretag_visa&op2=kontakt_visa&kontakt_ID=$kontakt_ID\">".$kategori."</a></td>";
        echo "<td>&nbsp;<a href=\"index.php?op=foretag_visa&op2=kontakt_visa&kontakt_ID=$kontakt_ID\">".$aterkontaktdatum."</a></td>";
        echo "</tr>";
    }
    echo "</table>";

echo "</td>";

echo "</tr>";
echo "<tr>";
echo "</tr>";

echo "<tr>";
echo "<td colspan=\"4\" width=\"100%\" class=\"fv_table\">";
echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><b>";
echo "<td valign=\"middle\" class=\"fv_td\"><a href=\"index.php?op=foretag_visa&op2=kontakt_ny\">Ny Kontakt&nbsp;|&nbsp;</a></td>";
echo "<td valign=\"middle\" class=\"fv_td\"><a href=\"index.php?op=foretag_visa&op2=kontaktperson_ny\">Ny Kontaktperson&nbsp;|&nbsp;</a></td>";
echo "<td valign=\"middle\" class=\"fv_td\"><a href=\"index.php?op=foretag_visa&op2=foretag_uppdatera\">Uppdatera Företag&nbsp;|&nbsp;</a></td>";
echo "<td valign=\"middle\" class=\"fv_td\"><a href=\"index.php?op=foretag_radera\">Radera Företag&nbsp;</a></td>";
echo "</b></tr></table>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width=\"400\" colspan=\"4\">";
echo "<table><tr><td>";

$op2 = $_GET['op2'];
	switch($op2) {
        case "kontakt_ny":
			KontaktNy();
			break;
        case "kontaktperson_ny":
            KontaktpersonNy();
			break;
        case "kontakt_visa":
            KontaktVisa();
			break;
        case "kontaktperson_visa":
            KontaktpersonVisa();
			break;
        case "kontaktperson_uppdatera":
            KontaktpersonUppdatera();
			break;
        case "kontakt_uppdatera":
            KontaktUppdatera();
			break;
        case "foretag_uppdatera":
            ForetagUppdatera();
			break;
    }


echo "</td></tr></table>";
echo "</td>";


echo "</tr></table>";

}

function ForetagNytt() {

    if (empty($_POST['spara'])) {

        echo "<div class=\"box\">";
		echo "<form action=\"index.php?op=foretag_nytt\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"op\" value=\"\">";
        echo "<table border=\"0\">";
        echo "<tr><td>Företagsnamn:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"foretagsnamn\"></td></tr>";
        echo "<tr><td>Adress:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"adress\"></td></tr>";
        echo "<tr><td>Leveransadress:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"leveransadress\"></td></tr>";
        echo "<tr><td>Postnr:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"postnr\"></td></tr>";
        echo "<tr><td>Postadress:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"postadress\"></td></tr>";
        echo "<tr><td>Orgnummer:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"orgnummer\"></td></tr>";
        echo "<tr><td>Telefon:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"telefon\"></td></tr>";
        echo "<tr><td>Epost:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"mail\"></td></tr>";
        echo "<tr><td>Övrigt:</td></tr>";
        echo "<tr><td><textarea class=\"skugga_textarea\" name=\"ovrigt\" rows=\"5\" cols=\"40\"></textarea></td></tr>";
        echo "<tr><td>&nbsp;</td></tr>";
        echo "<tr><td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"spara\" value=\"Spara\"></td></tr>";
        echo "</table>";
        echo "</form>";
        echo "</div>";

    }

    if (!empty($_POST['spara'])) {

        $arbetsgrupps_ID=$_SESSION['arbetsgrupps_ID'];
        $foretagsnamn=$_POST['foretagsnamn'];
        $adress=$_POST['adress'];
        $leveransadress=$_POST['leveransadress'];
        $postnr=$_POST['postnr'];
        $postadress=$_POST['postadress'];
        $orgnummer=$_POST['orgnummer'];
        $telefon=$_POST['telefon'];
        $mail=$_POST['mail'];
        $ovrigt=$_POST['ovrigt'];
		
		echo $arbetsgrupps_ID;
		echo "ok";

        mysql_query("INSERT INTO crm_foretag (arbetsgrupps_ID,foretagsnamn,adress,leveransadress,postnr,postadress,orgnummer,telefon,epost,ovrigt)
                    VALUES('$arbetsgrupps_ID','$foretagsnamn','$adress','$leveransadress','$postnr','$postadress','$orgnummer','$telefon','$mail','$ovrigt')");

    }

}

function ForetagUppdatera() {

    if (empty($_POST['spara'])) {

        $sql=mysql_query("SELECT * FROM crm_foretag WHERE foretags_ID='{$_SESSION['foretags_ID']}'");

        $foretagsnamn=mysql_result($sql, 0, 'foretagsnamn');
        $adress=mysql_result($sql, 0, 'adress');
        $leveransadress=mysql_result($sql, 0, 'leveransadress');
        $postnr=mysql_result($sql, 0, 'postnr');
        $postadress=mysql_result($sql, 0, 'postadress');
        $orgnummer=mysql_result($sql, 0, 'orgnummer');
        $telefon=mysql_result($sql, 0, 'telefon');
        $mail=mysql_result($sql, 0, 'epost');
        $ovrigt=mysql_result($sql, 0, 'ovrigt');

        echo "<form action=\"index.php?op=foretag_uppdatera\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"op\" value=\"\">";
        echo "<table border=\"0\">";

        echo "<tr><td width=\"200\">";
        echo "<table border=\"0\">";

        echo "<tr><td>Företagsnamn:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"foretagsnamn\" value=\"$foretagsnamn\"></td></tr>";
        echo "<tr><td>Adress:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"adress\" value=\"$adress\"></td></tr>";
        echo "<tr><td>Leveransadress:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"leveransadress\" value=\"$leveransadress\"></td></tr>";
        echo "<tr><td>Postnr:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"postnr\" value=\"$postnr\"></td></tr>";
        echo "<tr><td>Postadress:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"postadress\" value=\"$postadress\"></td></tr>";
        echo "<tr><td>Orgnummer:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"orgnummer\" value=\"$orgnummer\"></td></tr>";
        echo "<tr><td>Telefon:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"telefon\" value=\"$telefon\"></td></tr>";
        echo "<tr><td>Epost:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"mail\" value=\"$mail\"></td></tr>";

        echo "</table>";
        echo "</td>";
        echo "<td valign=\"top\">";
        echo "<table border=\"0\">";

        echo "<tr><td>Övrigt:</td></tr>";
        echo "<tr><td><textarea class=\"skugga_textarea\" rows=\"5\" cols=\"40\" name=\"ovrigt\">$ovrigt</textarea></td></tr>";
        echo "<tr><td>&nbsp;</td></tr>";
        echo "<tr><td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"spara\" value=\"Spara\"></td></tr>";

        echo "</table>";
        echo "</td>";

        echo "</table>";
        echo "</form>";

    }

    if (!empty($_POST['spara'])) {

        $foretagsnamn=$_POST['foretagsnamn'];
        $adress=$_POST['adress'];
        $leveransadress=$_POST['leveransadress'];
        $postnr=$_POST['postnr'];
        $postadress=$_POST['postadress'];
        $orgnummer=$_POST['orgnummer'];
        $telefon=$_POST['telefon'];
        $mail=$_POST['mail'];
        $ovrigt=$_POST['ovrigt'];

        $foretag=unserialize($_SESSION['foretag']);

        $foretag[$_SESSION['foretags_ID']]->setforetagsnamn($foretagsnamn);
        $foretag[$_SESSION['foretags_ID']]->setadress($adress);
        $foretag[$_SESSION['foretags_ID']]->setleveransadress($leveransadress);
        $foretag[$_SESSION['foretags_ID']]->setpostnr($postnr);
        $foretag[$_SESSION['foretags_ID']]->setpostadress($postadress);
        $foretag[$_SESSION['foretags_ID']]->setorgnummer($orgnummer);
        $foretag[$_SESSION['foretags_ID']]->settelefon($telefon);
        $foretag[$_SESSION['foretags_ID']]->setepost($mail);
        $foretag[$_SESSION['foretags_ID']]->setovrigt($ovrigt);

        $_SESSION['foretag']=serialize($foretag);

        mysql_query("UPDATE crm_foretag SET 
        foretagsnamn='$foretagsnamn',
        adress='$adress',
        leveransadress='$leveransadress',
        postnr='$postnr',
        postadress='$postadress',
        orgnummer='$orgnummer',
        telefon='$telefon',
        epost='$mail',
        ovrigt='$ovrigt'
        WHERE foretags_ID='{$_SESSION['foretags_ID']}'");

        header("Location: index.php?op=foretag_visa");
    }

}

function ForetagRadera() {

}

function KontaktpersonNy() {

    if (empty($_POST['spara'])) {

        echo "<table>";
        echo "<tr><td width=\"200\">";

        echo "<form action=\"index.php?op=foretag_visa&op2=kontaktperson_ny\" method=\"post\">";
        echo "<table border=\"0\">";
        echo "<tr><td>Förnamn:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"fnamn\"></td></tr>";
        echo "<tr><td>Efternamn:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"enamn\"></td></tr>";
        echo "<tr><td>Titel:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"titel\"></td></tr>";
        echo "<tr><td>Telefon:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"telefon\"></td></tr>";
        echo "<tr><td>Mobil:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"mobil\"></td></tr>";
        echo "<tr><td>Epost:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"mail\"></td></tr>";
        echo "</table>";

        echo "</td>";

        echo "<td>";
        echo "<table>";
        echo "<tr><td>Övrigt:</td></tr>";
        echo "<tr><td><textarea class=\"skugga_textarea\" name=\"ovrigt\" rows=\"5\" cols=\"40\"></textarea></td></tr>";
        echo "<tr><td>&nbsp;</td></tr>";
        echo "<tr><td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"spara\" value=\"Spara\"></td></tr>";
        echo "</table>";
        echo "</form>";

        echo "</td></tr>";
        echo "</table>";

    }

    if (!empty($_POST['spara'])) {

        $foretags_ID=$_SESSION['foretags_ID'];
        $fnamn=$_POST['fnamn'];
        $enamn=$_POST['enamn'];
        $titel=$_POST['titel'];
        $telefon=$_POST['telefon'];
        $mobil=$_POST['mobil'];
        $mail=$_POST['mail'];
        $ovrigt=$_POST['ovrigt'];

        mysql_query("INSERT INTO crm_kontaktpersoner (foretags_ID,fnamn,enamn,titel,telefon,mobil,epost,ovrigt)
                    VALUES('$foretags_ID','$fnamn','$enamn','$titel','$telefon','$mobil','$mail','$ovrigt')");
        header("Location: index.php?op=foretag_visa");
    }
}

function KontaktpersonUppdatera() {

    if (empty($_POST['spara'])) {

        $kontaktperson_ID=$_GET['kontaktperson_ID'];

        $sql=mysql_query("SELECT * FROM crm_kontaktpersoner WHERE kontaktperson_ID=$kontaktperson_ID");

        $fnamn=mysql_result($sql, 0, 'fnamn');
        $enamn=mysql_result($sql, 0, 'enamn');
        $titel=mysql_result($sql, 0, 'titel');
        $telefon=mysql_result($sql, 0, 'telefon');
        $mobil=mysql_result($sql, 0, 'mobil');
        $mail=mysql_result($sql, 0, 'epost');
        $ovrigt=mysql_result($sql, 0, 'ovrigt');

        echo "<form action=\"index.php?op=foretag_visa&op2=kontaktperson_uppdatera\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"kontaktperson_ID\" value=\"$kontaktperson_ID\">";
        echo "<table border=\"0\">";
        echo "<tr><td width=\"200\">";
        echo "<table border=\"0\">";
        echo "<tr><td>Förnamn:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"fnamn\" value=\"$fnamn\"></td></tr>";
        echo "<tr><td>Efternamn:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"enamn\" value=\"$enamn\"></td></tr>";
        echo "<tr><td>Titel:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"titel\" value=\"$titel\"></td></tr>";
        echo "<tr><td>Telefon:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"telefon\" value=\"$telefon\"></td></tr>";
        echo "<tr><td>Mobil:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"mobil\" value=\"$mobil\"></td></tr>";
        echo "<tr><td>Epost:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"mail\" value=\"$mail\"></td></tr>";
        echo "</table>";
        echo "</td>";
        echo "<td valign=\"top\">";
        echo "<table border=\"0\">";
        echo "<tr><td>Övrigt:</td></tr>";
        echo "<tr><td><textarea class=\"skugga_textarea\" name=\"ovrigt\" rows=\"5\" cols=\"40\">$ovrigt</textarea></td></tr>";
        echo "<tr><td>&nbsp;</td></tr>";
        echo "<tr><td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"spara\" value=\"Spara\"></td></tr>";
        echo "</table>";
        echo "</td></tr>";
        echo "</table>";
        echo "</form>";

    }

    if (!empty($_POST['spara'])) {

        $kontaktperson_ID=$_POST['kontaktperson_ID'];
        $fnamn=$_POST['fnamn'];
        $enamn=$_POST['enamn'];
        $titel=$_POST['titel'];
        $telefon=$_POST['telefon'];
        $mobil=$_POST['mobil'];
        $mail=$_POST['mail'];
        $ovrigt=$_POST['ovrigt'];

        mysql_query("UPDATE crm_kontaktpersoner SET
                    fnamn='$fnamn',
                    enamn='$enamn',
                    titel='$titel',
                    telefon='$telefon',
                    mobil='$mobil',
                    epost='$mail',
                    ovrigt='$ovrigt'
                    WHERE kontaktperson_ID='$kontaktperson_ID'");

        header("Location: index.php?op=foretag_visa");

    }

}

function KontaktpersonVisa() {

    $kontaktperson_ID=$_GET['kontaktperson_ID'];
    $sql=mysql_query("SELECT * FROM crm_kontaktpersoner WHERE kontaktperson_ID='$kontaktperson_ID'");

    $fnamn=mysql_result($sql, 0, 'fnamn');
    $enamn=mysql_result($sql, 0, 'enamn');
    $titel=mysql_result($sql, 0, 'titel');
    $telefon=mysql_result($sql, 0, 'telefon');
    $mobil=mysql_result($sql, 0, 'mobil');
    $epost=mysql_result($sql, 0, 'epost');
    $ovrigt=mysql_result($sql, 0, 'ovrigt');

    echo "<table>";
    echo "<tr><td>$fnamn</td></tr>";
    echo "<tr><td>$enamn</td></tr>";
    echo "<tr><td>$titel</td></tr>";
    echo "<tr><td>$telefon</td></tr>";
    echo "<tr><td>$mobil</td></tr>";
    echo "<tr><td>$epost</td></tr>";
    echo "<tr><td>$ovrigt</td></tr>";
    echo "<tr><td>&nbsp;</td></tr>";
    echo "<tr><td><b><a href=\"index.php?op=foretag_visa&op2=kontaktperson_uppdatera&kontaktperson_ID=$kontaktperson_ID\">Uppdatera Kontaktperson</a></b></td></tr>";
    echo "</table>";

}

function KontaktpersonRadera() {

}

function KontaktNy() {

    if (empty($_POST['spara'])) {

        echo "<form action=\"index.php?op=foretag_visa&op2=kontakt_ny\" method=\"post\">";
        echo "<table border=\"0\">";

        echo "<tr><td valign=\"top\" width=\"207\">";
        echo "<table border=\"0\">";

        echo "<tr><td>Kontaktperson:</td></tr>";
        echo"<tr><td colspan=\"2\"><select class=\"skugga_textarea\" name=\"kontaktperson_ID\">";
        $sql=mysql_query("SELECT * FROM crm_kontaktpersoner WHERE foretags_ID={$_SESSION['foretags_ID']}");
        while ($rad=mysql_fetch_array($sql)) {
            echo"<option value=".$rad['kontaktperson_ID'].">".substr($rad['fnamn'], 0, 13)."&nbsp;".substr($rad['enamn'], 0, 13)."</option>";
        };
        echo"</select></td></tr>";

        echo "<tr><td>Typ av kontakt:</td></tr>";
        echo"<tr><td colspan=\"2\"><select class=\"skugga_textarea\" name=\"kontaktkategori_ID\">";
        $sql=mysql_query("SELECT * FROM crm_kontaktkategori");
        while ($rad=mysql_fetch_array($sql)) {
            echo"<option value=".$rad['kontaktkategori_ID'].">".substr($rad['kategori'], 0, 8)."</option>";
        }
        echo"</select></td></tr>";

        $kontaktdatum = date("Y-m-d");
        $aterkontaktdatum = date("Y-m-d");
        echo "<tr><td>Kontaktdatum:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" id=\"kontaktdatum\" name=\"kontaktdatum\" value=\"$kontaktdatum\"></td>";
        ?>
        <td><a href="javascript:NewCssCal('kontaktdatum','yyyymmdd')">
        <img src="images/app_date.png" width="20" height="20" border="0" alt="Välj Datum"/></a></td><?php
        echo "</tr>";
        echo "<tr><td>Kontaktas igen den:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" id=\"aterkontaktdatum\" name=\"aterkontaktdatum\" value=\"$aterkontaktdatum\"></td>";
        ?>
        <td><a href="javascript:NewCssCal('aterkontaktdatum','yyyymmdd')">
        <img src="images/app_date.png" width="20" height="20" border="0" alt="Välj Datum"/></a></td>
        <?php
        echo "</tr>";
        echo "<tr><td><input type=\"button\" class=\"button_s\" name=\"kontakt\" value=\"Kontaktas inte\" onClick=\"this.form.aterkontaktdatum.value=kontaktnoll\"></td></tr>";

        echo "</table>";
        echo "</td>";

        echo "<td>";
        echo "<table border=\"0\">";

        echo "<tr><td>Övrigt:</td></tr>";
        echo "<tr><td><textarea class=\"skugga_textarea\" name=\"ovrigt\" rows=\"15\" cols=\"40\"></textarea></td></tr>";
        echo "<tr><td>&nbsp;</td></tr>";
        echo "<tr><td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"spara\" value=\"Spara\"></td></tr>";

        echo "</table>";
        echo "</td></tr>";

        echo "</table>";
        echo "</form>";

    }

    if (!empty($_POST['spara'])) {

        $saljar_ID=$_SESSION['saljar_ID'];
        $foretags_ID=$_SESSION['foretags_ID'];
        $kontaktperson_ID=$_POST['kontaktperson_ID'];
        $kontaktkategori_ID=$_POST['kontaktkategori_ID'];
        $arbetsgrupps_ID=$_SESSION['arbetsgrupps_ID'];
        $kontaktdatum=$_POST['kontaktdatum'];
        $aterkontaktdatum=$_POST['aterkontaktdatum'];
        $ovrigt=$_POST['ovrigt'];

        mysql_query("UPDATE crm_kontakt SET kontaktad='1' WHERE foretags_ID='$foretags_ID'");

        mysql_query("INSERT INTO crm_kontakt (saljar_ID,foretags_ID,kontaktperson_ID,kontaktkategori_ID,arbetsgrupps_ID,kontaktdatum,aterkontaktdatum,kontaktad,ovrigt)
                    VALUES('$saljar_ID','$foretags_ID','$kontaktperson_ID','$kontaktkategori_ID','$arbetsgrupps_ID','$kontaktdatum','$aterkontaktdatum','0','$ovrigt')");
        if ($aterkontaktdatum=='0000-00-00') {
            mysql_query("UPDATE crm_kontakt SET kontaktad='1' WHERE foretags_ID='$foretags_ID'");
        }
        header("Location: index.php?op=foretag_visa");
    }

}

function KontaktUppdatera() {


    if (empty($_POST['spara'])) {

        $kontakt_ID=$_GET['kontakt_ID'];

        $sql=mysql_query("SELECT * FROM crm_kontakt WHERE kontakt_ID='$kontakt_ID'");

        $kontaktperson_ID=mysql_result($sql, 0, 'kontaktperson_ID');
        $kontaktkategori_ID=mysql_result($sql, 0, 'kontaktkategori_ID');
        $kontaktdatum=mysql_result($sql, 0, 'kontaktdatum');
        $aterkontaktdatum=mysql_result($sql, 0, 'aterkontaktdatum');
        $ovrigt=mysql_result($sql, 0, 'ovrigt');

        echo "<form action=\"index.php?op=foretag_visa&op2=kontakt_uppdatera\" method=\"post\">";
        echo "<table border=\"0\">";
        echo "<tr><td valign=\"top\" width=\"200\">";

        echo "<table>";
        echo "<input type=\"hidden\" name=\"kontakt_ID\" value=\"$kontakt_ID\">";
        echo "<tr><td>Kontaktperson:</td></tr>";
        echo"<tr><td><select class=\"skugga_textarea\" name=\"kontaktperson_ID\">";
        
        $sql=mysql_query("SELECT fnamn,enamn FROM crm_kontaktpersoner WHERE kontaktperson_ID=$kontaktperson_ID");
//        $fnamn=mysql_result($sql, 0, 'fnamn');
//        $enamn=mysql_result($sql, 0, 'enamn');
        $fnamn=substr(mysql_result($sql, 0, 'fnamn'), 0, 13);
        $enamn=substr(mysql_result($sql, 0, 'enamn'), 0, 13);

        echo"<option value=\"$kontaktperson_ID\">$fnamn&nbsp;$enamn</option>";

        $sql=mysql_query("SELECT * FROM crm_kontaktpersoner WHERE foretags_ID={$_SESSION['foretags_ID']}");
        while ($rad=mysql_fetch_array($sql)) {
            echo"<option value=".$rad['kontaktperson_ID'].">".substr($rad['fnamn'], 0, 13)."&nbsp;".substr($rad['enamn'], 0, 13)."</option>";

        }
        echo"</select></td></tr>";

        echo "<tr><td>Typ av kontakt:</td></tr>";
        echo"<tr><td><select class=\"skugga_textarea\" name=\"kontaktkategori_ID\">";


        $sql=mysql_query("SELECT kategori FROM crm_kontaktkategori WHERE kontaktkategori_ID=$kontaktkategori_ID");
        $kategori=mysql_result($sql, 0, 'kategori');
        echo"<option value=\"$kontaktkategori_ID\">$kategori</option>";

        $sql=mysql_query("SELECT * FROM crm_kontaktkategori");
        while ($rad=mysql_fetch_array($sql)) {
            echo"<option value=".$rad['kontaktkategori_ID'].">".$rad['kategori']."</option>";
        }
        echo"</select></td></tr>";

        echo "<tr><td>Kontaktdatum:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"kontaktdatum\" value=\"$kontaktdatum\"></td></tr>";
        echo "<tr><td>Kontaktas igen den:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"aterkontaktdatum\" value=\"$aterkontaktdatum\"></td></tr>";
        echo "</table>";

        echo "</td>";
        echo "<td>";

        echo "<table>";

        echo "<tr><td>Övrigt:</td></tr>";
        echo "<tr><td><textarea class=\"skugga_textarea\" name=\"ovrigt\" rows=\"15\" cols=\"40\">$ovrigt</textarea></td></tr>";
        echo "<tr><td>&nbsp;</td></tr>";
        echo "<tr><td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"spara\" value=\"Spara\"></td></tr>";
        echo "</table>";
        echo "</td></tr>";
        echo "</table>";
        echo "</form>";

    }

    if (!empty($_POST['spara'])) {

        $kontakt_ID=$_POST['kontakt_ID'];
        $foretags_ID=$_SESSION['foretags_ID'];
        $kontaktperson_ID=$_POST['kontaktperson_ID'];
        $kontaktkategori_ID=$_POST['kontaktkategori_ID'];
        $kontaktdatum=$_POST['kontaktdatum'];
        $aterkontaktdatum=$_POST['aterkontaktdatum'];
        $ovrigt=$_POST['ovrigt'];

        mysql_query("UPDATE crm_kontakt SET foretags_ID='$foretags_ID',
                    kontaktperson_ID='$kontaktperson_ID',
                    kontaktkategori_ID='$kontaktkategori_ID',
                    kontaktdatum='$kontaktdatum',
                    aterkontaktdatum='$aterkontaktdatum',
                    ovrigt='$ovrigt'
                    WHERE kontakt_ID='$kontakt_ID'");
        header("Location: index.php?op=foretag_visa");

    }

}

function KontaktVisa() {

    $kontakt_ID=$_GET['kontakt_ID'];
    $sql=mysql_query("SELECT * FROM crm_kontakt WHERE kontakt_ID='$kontakt_ID'");
    $kontaktperson_ID=mysql_result($sql, 0, 'kontaktperson_ID');
    $sql2=mysql_query("SELECT * FROM crm_kontaktpersoner WHERE kontaktperson_ID='$kontaktperson_ID'");

    $kontaktperson_fnamn=mysql_result($sql2, 0, 'fnamn');
    $kontaktperson_enamn=mysql_result($sql2, 0, 'enamn');
    $kontaktkategori_ID=mysql_result($sql, 0, 'kontaktkategori_ID');
    $kontaktdatum=mysql_result($sql, 0, 'kontaktdatum');
    $aterkontaktdatum=mysql_result($sql, 0, 'aterkontaktdatum');
    $ovrigt=mysql_result($sql, 0, 'ovrigt');

    $sql3=mysql_query("SELECT kategori FROM crm_kontaktkategori WHERE kontaktkategori_ID='$kontaktkategori_ID'");
    $kategori=mysql_result($sql3, 0, 'kategori');

    echo "<table>";
    echo "<tr><td>".$kontaktperson_fnamn."&nbsp;".$kontaktperson_enamn."</td></tr>";
    echo "<tr><td>".$kategori."</td></tr>";
    echo "<tr><td>".$kontaktdatum."</td></tr>";
    echo "<tr><td>".$aterkontaktdatum."</td></tr>";
    echo "<tr><td>".$ovrigt."</td></tr>";
    echo "<tr><td>&nbsp;</td></tr>";
    echo "<tr><td><b><a href=\"index.php?op=foretag_visa&op2=kontakt_uppdatera&kontakt_ID=$kontakt_ID\">Uppdatera Kontakt</a></b><br></td></tr>";
    echo "</table>";

}

function KontaktKategoriNy() {

    if (empty($_POST['spara'])) {

        echo "<div class=\"box\">";
        echo "<form action=\"index.php?op=kontakt_kategori_ny\" method=\"post\">";
        echo "<table border=\"0\">";
        echo "<tr><td>Kategori:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"kategori\" value=\"\"></td></tr>";
        echo "<tr><td>&nbsp;</td></tr>";
        echo "<tr><td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"spara\" value=\"Spara\"></td></tr>";
        echo "</table>";
        echo "</form>";
        echo "</div>";

    }

    if (!empty($_POST['spara'])) {

        $kategori=$_POST['kategori'];

        mysql_query("INSERT INTO crm_kontaktkategori (kategori) VALUES('$kategori')");
        
    }

}

function KontaktSaljareUppdatera() {
    
    if (empty($_POST['spara'])) {

        $sql=mysql_query("SELECT * FROM crm_saljare WHERE saljar_ID='{$_SESSION['saljar_ID']}'");
        
        $avdelnings_ID=mysql_result($sql, 0, 'arbetsgrupps_ID');
        $fnamn=mysql_result($sql, 0, 'fnamn');
        $enamn=mysql_result($sql, 0, 'enamn');
        $personnummer=mysql_result($sql, 0, 'personnummer');
        $telefon=mysql_result($sql, 0, 'telefon');
        $mobil=mysql_result($sql, 0, 'mobil');
        $epost=mysql_result($sql, 0, 'epost');
        $ovrigt=mysql_result($sql, 0, 'ovrigt');

        echo "<div class=\"box\">";
        echo "<form action=\"index.php?op=kontakt_saljare_uppdatera\" method=\"post\">";
        echo "<table border=\"0\">";
        echo "<tr><td>Förnamn:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"fnamn\" value=\"$fnamn\"></td></tr>";
        echo "<tr><td>Efternamn:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"enamn\" value=\"$enamn\"></td></tr>";
        echo "<tr><td>Personnummer:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"personnummer\" value=\"$personnummer\"></td></tr>";
        echo "<tr><td>Telefon:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"telefon\" value=\"$telefon\"></td></tr>";
        echo "<tr><td>Mobiltelefon:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"mobil\" value=\"$mobil\"></td></tr>";
        echo "<tr><td>Mail:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"epost\" value=\"$epost\"></td></tr>";
        echo "<tr><td>Övrigt:</td></tr>";
        echo "<tr><td><textarea class=\"skugga_textarea\" name=\"ovrigt\" rows=\"5\" cols=\"40\">$ovrigt</textarea></td></tr>";
        echo "<tr><td>&nbsp;</td></tr>";
        echo "<tr><td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"spara\" value=\"Spara\"></td></tr>";
        echo "</table>";
        echo "</form>";
        echo "</div>";

    }

    if (!empty($_POST['spara'])) {
        
    $arbetsgrupps_ID=$_SESSION['arbetsgrupps_ID'];
    $fnamn=$_POST['fnamn'];
    $enamn=$_POST['enamn'];
    $personnummer=$_POST['personnummer'];
    $telefon=$_POST['telefon'];
    $mobil=$_POST['mobil'];
    $epost=$_POST['epost'];
    $ovrigt=$_POST['ovrigt'];

    mysql_query("UPDATE crm_saljare SET 
    arbetsgrupps_ID='$arbetsgrupps_ID',
    fnamn='$fnamn',
    enamn='$enamn',
    personnummer='$personnummer',
    telefon='$telefon',
    mobil='$mobil',
    epost='$epost',
    ovrigt='$ovrigt'
    WHERE saljar_ID='{$_SESSION['saljar_ID']}'");

    $_SESSION['fnamn']=$fnamn;
    $_SESSION['enamn']=$enamn;
    $_SESSION['personnummer']=$personnummer;
    $_SESSION['telefon']=$telefon;
    $_SESSION['mobil']=$mobil;
    $_SESSION['epost']=$epost;
    $_SESSION['ovrigt']=$ovrigt;
    header("Location: index.php");

    }

}

function ValjArbetsgrupp() {

    $spara=$_POST['spara'];

    if (empty($spara)) {
        echo "<div class=\"box\">";
        echo"<table>";
        echo "<form action=\"index.php?op=valj_arbetsgrupp\" method=\"post\">";
        echo"<tr><td><select name=\"arbetsgrupps_ID\">";

        $sql=mysql_query("SELECT * FROM crm_arbetsgrupp");

        while ($rad=mysql_fetch_array($sql)) {
            echo"<option value=".$rad['arbetsgrupps_ID'].">".$rad['arbetsgrupp']."</option>";
        }

        echo"</select></td>";
        echo "<td align=\"lef\"t><input type=\"submit\" class=\"button_s\" name=\"spara\" value=\"Spara\"></td></tr>";
        echo "</form>";
        echo"</table>";
        echo "</div>";
    }
    
    if (!empty($spara)) {

        $arbetsgrupps_ID=$_POST['arbetsgrupps_ID'];
        $saljar_ID=$_SESSION['saljar_ID'];
        
        mysql_query("UPDATE crm_saljare SET arbetsgrupps_ID='$arbetsgrupps_ID' WHERE saljar_ID='$saljar_ID'");
        $sql=mysql_query("SELECT arbetsgrupp FROM crm_arbetsgrupp WHERE arbetsgrupps_ID=$arbetsgrupps_ID");

        $arbetsgrupp=mysql_result($sql, 0, 'arbetsgrupp');
        echo"Vald Arbetsgrupp: $arbetsgrupp";

        $_SESSION['arbetsgrupps_ID']=$arbetsgrupps_ID;
        header("Location: index.php");

    }

}

function ArbetsgruppNy() {

    if (empty($_POST['spara'])) {

        echo "<div class=\"box\">";
        echo "<form action=\"index.php?op=arbetsgrupp_ny\" method=\"post\">";
        echo "<table border=\"0\">";
        echo "<tr><td>Arbetsgrupp:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"arbetsgrupp\" value=\"\"></td></tr>";
        echo "<tr><td>&nbsp;</td></tr>";
        echo "<tr><td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"spara\" value=\"Spara\"></td></tr>";
        echo "</table>";
        echo "</form>";
        echo "</div>";
    }

    if (!empty($_POST['spara'])) {
        
        $arbetsgrupp=$_POST['arbetsgrupp'];
        mysql_query("INSERT INTO crm_arbetsgrupp (arbetsgrupp) VALUES('$arbetsgrupp')");      
    }

}

function KontaktSaljareNy() {
    
    if (empty($_POST['spara'])) {

        $avdelnings_ID=$_SESSION['avdelnings_ID'];
        $fnamn=$_SESSION['fnamn'];
        $enamn=$_SESSION['enamn'];
        $password=$_SESSION['password'];
        $personnummer=$_SESSION['personnummer'];
        $telefon=$_SESSION['telefon'];
        $mobil=$_SESSION['mobil'];
        $email=$_SESSION['epost'];
        $ovrigt=$_SESSION['ovrigt'];

        $errmsg=$_SESSION['errmsg'];

        echo "<div class=\"box\">";
        echo "<form action=\"index.php?op=saljare_spara\" method=\"post\">";
        echo "<table border=\"0\">";
        
        echo "<tr><td>Förnamn:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"fnamn\" value=\"$fnamn\"></td><td>$errmsg[1]</td></tr>";
        echo "<tr><td>Efternamn:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"enamn\" value=\"$enamn\"></td><td>$errmsg[2]</td></tr>";
        echo "<tr><td>Password:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"password\" name=\"password\" value=\"$password\"></td><td>$errmsg[3]</td></tr>";
        echo "<tr><td>Personnummer:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"personnummer\" value=\"$personnummer\"></td><td>$errmsg[4]</td></tr>";
        echo "<tr><td>Telefon:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"telefon\" value=\"$telefon\"></td><td>$errmsg[5]</td></tr>";
        echo "<tr><td>Mobiltelefon:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"mobil\" value=\"$mobil\"></td><td>$errmsg[6]</td></tr>";
        echo "<tr><td>Mail:</td></tr>";
        echo "<tr><td><input class=\"skugga\" type=\"text\" name=\"mail\" value=\"$email\"></td><td>{$errmsg[7]}{$errmsg[8]}</td></tr>";
        echo "<tr><td>Övrigt:</td></tr>";
        echo "<tr><td colspan=\"2\"><textarea class=\"skugga_textarea\" name=\"ovrigt\" rows=\"5\" cols=\"40\" value=\"\"></textarea></td></tr>";
        echo "<tr><td>&nbsp;</td></tr>";
        echo "<tr><td align=\"left\"><input type=\"submit\" class=\"button_s\" name=\"spara\" value=\"Spara\"></td></tr>";
        echo "</table>";
        echo "</form>";
        echo "</div>";

    }

}

function SaljareSpara() {

//    $epost=$_POST['mail'];
//    $sql = mysql_query("SELECT * FROM crm_saljare WHERE epost='$epost'");
//    $count=count(mysql_fetch_array($sql));
//
//    if (!empty($sql)) {
//        $pass = mysql_result($sql, 0, 'epost');
//    }
//
//    if (empty($pass)) {

        $_SESSION['avdelnings_ID']=$avdelnings_ID=$_POST['avdelnings_ID'];
        $_SESSION['fnamn']=$fnamn=$_POST['fnamn'];
        $_SESSION['enamn']=$enamn=$_POST['enamn'];
        $_SESSION['password']=$password=$_POST['password'];
        $_SESSION['personnummer']=$personnummer=$_POST['personnummer'];
        $_SESSION['telefon']=$telefon=$_POST['telefon'];
        $_SESSION['mobil']=$mobil=$_POST['mobil'];
        $_SESSION['epost']=$email=$_POST['mail'];
        $_SESSION['ovrigt']=$ovrigt=$_POST['ovrigt'];

   $errmsg = array();

   if(trim($fnamn) == '')
   {
      $errmsg[1] = 'Var vänlig och fyll i ditt Förnamn';
   }
   if(trim($enamn) == '')
   {
      $errmsg[2] = 'Var vänlig och fyll i ditt Efternamn';
   }
   if(trim($password) == '')
   {
      $errmsg[3] = 'Var vänlig och fyll i ditt Password';
   }
   if(trim($personnummer) == '')
   {
      $errmsg[4] = 'Var vänlig och fyll i ditt Personnummer';
   }
   if(trim($telefon) == '')
   {
      $errmsg[5] = 'Var vänlig och fyll i ditt Telefonnummer';
   }
   if(trim($mobil) == '')
   {
      $errmsg[6] = 'Var vänlig och fyll i ditt Mobiltelefonnummer';
   }

   if(trim($email) == '')
   {
      $errmsg[7] = 'Var vänlig och fyll i din E-postadress';
   }
   else if(IsEmail($email)==false)
   {
      $errmsg[8] = 'E-postadressen är inte giltig';
   }

   foreach ($errmsg as $key => $val) {
        echo $val."<br>";
   }

   if(!empty($errmsg)) {
       header("Location: index.php?op=kontakt_saljare_ny");
       $_SESSION['errmsg']=$errmsg;
//       echo "<br><a href=index.php?op=kontakt_saljare_ny><b>Tillbaks till Registreringsformuläret</b></a>";
   }

   if(empty($errmsg)) {

        mysql_query("INSERT INTO crm_saljare (arbetsgrupps_ID,fnamn,enamn,password,personnummer,telefon,mobil,epost,ovrigt)
                     VALUES('$avdelnings_ID','$fnamn','$enamn','$password','$personnummer','$telefon','$mobil','$epost','$ovrigt')");

        $to      =   $mail;
        $from    =   "crm.adlertz.se";
        $subject =   utf8_decode("Registrering crm.adlertz.se");
        $message =   utf8_decode("Du är registrerad");

   }

//        if (mail($to, $subject, $message ,"From: <$from>")) {}
//    }

//    if (!empty ($pass)) {
//        $registrerad=mysql_result($sql1, 0, 'registrerad');
//        echo "Mailadressen:&nbsp;$mail<br>Registrerades:&nbsp;$registrerad.<br>
//              Klicka på knappen nedan för att få lösenordet skickat till&nbsp;$mail.";
//        echo "<form name=form action='index.php?op=skicka_password' method=post>";
//        echo "<input type=hidden name=mail value=$mail>";
//        echo "<input type=submit class='button_s' value='Skicka Lösenord' name=ok>";
//        echo "</form>";
//    }
//    header("Location: index.php");
}

function SkickaPassword() {
        if (empty($_POST['mail'])) {
            echo "<table>";
            echo "<form action=\"index.php?op=skicka_password\" method=\"post\">";
            echo "<tr><td>E-post</td></tr>";
            echo "<tr><td><input type=\"text\" class=\"skugga\" name=\"mail\"></td></tr>";
            echo "<tr><td><input type=\"submit\" class=\"button_s\" value=\"Skicka\"></td></tr>";
            echo "</form>";
            echo "</table>";
        }

        if (!empty($_POST['mail'])) {
            $mail=$_POST['mail'];

            $sql = mysql_query("SELECT password FROM crm_saljare WHERE mail='$mail'");

            $password = mysql_result($sql, 0, 'password');
            $to      =   $_POST['mail'];
            $from    =   "crm.adlertz.se";
            $subject =   utf8_decode("Ditt Lösenord");
            $message =   utf8_decode("Ditt Lösenord: $password");

            if (mail($to, $subject, $message ,"From: <$from>")) {
                echo "Ditt Lösenord är skickat till:&nbsp;$mail";
            }
        }
}

function IsEmail($email) {
  // First, we check that there's one @ symbol,
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
    (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
    ↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
    $local_array[$i])) {
    return false;
    }
  }
  // Check if domain is IP. If not,
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
  }
  for ($i = 0; $i < sizeof($domain_array); $i++) {
    if
        (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
        ↪([A-Za-z0-9]+))$",
        $domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

################################################################################

?>
