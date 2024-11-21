<?php
session_start();
if($_SESSION['member_login'] == 'true'){}
else {header("Location: login.php");}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="__mall_jp.css" rel="stylesheet" type="text/css">
</head>
<br>
<body align="right">
<table border="0" cellpadding="2" cellspacing="0" align="right">
<td valign="top">

<?php

echo "<td colspan='1' valign='top' align='center'>";
echo "<table border='0' cellpadding='2' cellspacing='0' height='auto' width='auto'>";
    // ansluter till databasen
    include "_config.php";
    include "_connect_database.php";

    // SIDNUMMER: om @GET är definierad används innehållet som sidnummer, annars används angivet sidnummer
    if (isset($_GET['sida'])) {
        $sida = mysql_real_escape_string(trim($_GET['sida']));
    }
    else { $sida = 1; }

    $forarid = $_SESSION['member_username'];
    // ange antal rader från sökresultatet som ska visas per sida
    $limit = 12;
    // Antal sidlänkar som ska visas i navigeringen, exempel: | 1 2 3 4 5 |
    $numLinks = 3;

    // intervall på antal rader som ska hämtas från MySQL
    $offset = ($sida - 1) * $limit;

    // sökfrågan som hämtar information från den angivna tabellen - intervallet för visningen anges med LIMIT
    $query = "SELECT DISTINCT DATE_FORMAT(datum, '%Y-%m') AS year FROM loneberakning WHERE forarid = '$forarid' GROUP BY datum DESC LIMIT $offset, $limit";
    $result = mysql_query($query) or die(mysql_error());

    // räknar antalet rader och sparar resultatet i arrayen "antal_rader"
    $result_antal_rader = mysql_query("SELECT DISTINCT DATE_FORMAT(datum, '%Y-%m') AS year FROM loneberakning WHERE forarid = '$forarid' group by datum DESC") or die(mysql_error());
    $numrows['antal_rader'] = 0;
    while($row = mysql_fetch_array( $result_antal_rader )){
        $numrows['antal_rader'] = $numrows['antal_rader'] +1;
    }

    // beräknar antal rader som ska visas per sida
    if ($numrows['antal_rader'] > 0 ) {
        $sidor_totalt = (ceil($numrows['antal_rader'] / $limit) );
    }

    // skriver ut sökresultatet - antal rader av totalt
    //echo 'Din sökning gav resultatet ' . $numrows['antal_rader'] . ' rader (här visas ' . $limit . ' rader per sida).';
    //echo '' . $limit . ' av (' . $numrows['antal_rader'] . ' totalt).';
    //echo '<br /><br />';

################################################################################
    // START AV FUNKTION FÖR NAVIGERING 1:
    //  << första < föregående | 1 2 3 4 5 | nästa > sista >>
################################################################################

    function sidnavigering1($sida, $sidor_totalt) {
        global $numLinks;
        // beräknar startsidan
        if ($sidor_totalt > $numLinks){
            $startLink = $sida - floor($numLinks / 2);
        if ($startLink >($sidor_totalt - $numLinks)){
            $startLink = $sidor_totalt - $numLinks + 1;
        }
    }
    else $startLink = 1;
    // beräknar sista sidan
    if ($startLink < 1) $startLink = 1;
        $stopLink = $startLink + $numLinks - 1;
    if ($stopLink > $sidor_totalt) $stopLink = $sidor_totalt;

//------------------------------------------------------------------------------
    // visar "<< första < föregående " om INTE den första sidan visas
    if ($sida > 1) {
    //echo "&laquo; <a href=\"{$_SERVER['PHP_SELF']}?sida=1\">f&ouml;rsta</a> ";
    //echo "&lsaquo; <a href=\"{$_SERVER['PHP_SELF']}?sida=" . ($sida - 1) . "\">f&ouml;reg&aring;ende</a> ";
        echo "<a href=\"{$_SERVER['PHP_SELF']}?sida=1\">&laquo; </a> ";
        echo " <a href=\"{$_SERVER['PHP_SELF']}?sida=" . ($sida - 1) . "\">&lsaquo; </a> ";
    }
    //    else echo '<font color="#cccccc">&laquo; f&ouml;rsta &lsaquo; f&ouml;reg&aring;ende</font>';
    else echo '<font color="#cccccc">&laquo; &lsaquo; </font>';

//------------------------------------------------------------------------------
    // skriver ut sidlänkar i navigeringen
    //   1 2 3 4 5 osv..
    if($sidor_totalt > 0) {
        echo ' | ';
        for ($i=$startLink; $i<=$stopLink; $i++){
        if ($i == $sida){
            echo '<strong>'.$i.'</strong>';
        }
        else {
            echo " <a href=\"{$_SERVER['PHP_SELF']}?sida=$i\">$i</a>";
        }
        echo ' ';
        }
        echo ' | ';
    }
//------------------------------------------------------------------------------
    // visar " nästa > sista >> " om INTE den sista sidan visas
    if ($sida < $sidor_totalt) {
    //echo " <a href=\"{$_SERVER['PHP_SELF']}?sida=".($sida + 1)."\">n&auml;sta</a> &rsaquo;";
    //echo " <a href=\"{$_SERVER['PHP_SELF']}?sida=$sidor_totalt\">sista</a> &raquo;";
        echo " <a href=\"{$_SERVER['PHP_SELF']}?sida=".($sida + 1)."\"> &rsaquo;</a>";
        echo " <a href=\"{$_SERVER['PHP_SELF']}?sida=$sidor_totalt\"> &raquo;</a>";
    }
    //    else echo '<font color="#cccccc">n&auml;sta &rsaquo; sista &raquo;</font>';
    else echo '<font color="#cccccc"> &rsaquo; &raquo;</font>';
    }
    // SLUT FUNKTION NAVIGERING 1
################################################################################

################################################################################
    // START AV FUNKTION FÖR NAVIGERING 2:
    //  << första < föregående | sidan 1 av 25 | nästa > sista >>
################################################################################
    function sidnavigering2($sida, $sidor_totalt) {
//------------------------------------------------------------------------------
    // visar "<< första < föregående " om INTE den första sidan visas
    if ($sida > 1) {
    //echo "&laquo; <a href=\"{$_SERVER['PHP_SELF']}?sida=1\">f&ouml;rsta</a> ";
    //echo "&lsaquo; <a href=\"{$_SERVER['PHP_SELF']}?sida=".($sida - 1)."\">f&ouml;reg&aring;ende</a> ";
        echo "<a href=\"{$_SERVER['PHP_SELF']}?sida=1\">&laquo;</a> ";
        echo "<a href=\"{$_SERVER['PHP_SELF']}?sida=".($sida - 1)."\">&lsaquo;</a> ";
    }
    //    else echo '<font color="#cccccc">&laquo; f&ouml;rsta &lsaquo; f&ouml;reg&aring;ende</font>';
    else echo '<font color="#cccccc">&laquo; &lsaquo;</font>';
//------------------------------------------------------------------------------
    // Visar "| sidan 1 av 25 | "
    echo " | ";
    echo '<strong>'.($sida).'</strong> av ' .($sidor_totalt);
    echo " | ";
//------------------------------------------------------------------------------
    // visar " nästa > sista >> " om INTE den sista sidan visas
    if ($sida < $sidor_totalt) {
    //echo " <a href=\"{$_SERVER['PHP_SELF']}?sida=".($sida + 1)."\">n&auml;sta</a> &rsaquo;";
    //echo " <a href=\"{$_SERVER['PHP_SELF']}?sida=$sidor_totalt\">sista</a> &raquo;";
        echo " <a href=\"{$_SERVER['PHP_SELF']}?sida=".($sida + 1)."\">&rsaquo;</a> ";
        echo " <a href=\"{$_SERVER['PHP_SELF']}?sida=$sidor_totalt\">&raquo;</a> ";
    }
    //    else echo '<font color="#cccccc">n&auml;sta &rsaquo; sista &raquo;</font>';
    else echo '<font color="#cccccc">&rsaquo; &raquo;</font>';
    }
// SLUT FUNKTION NAVIGERING 2

################################################################################
////////////////////////////////////////////////////////////////////////////////
    // HÄR VISAS MENYN FÖR NAVIGERING 1:
    //  << första < föregående | 1 2 3 4 5 | nästa > sista >>
    sidnavigering1($sida, $sidor_totalt);

////////////////////////////////////////////////////////////////////////////////

    echo '<br />';
    // HTML-tabellens formatering - tabellstart
    echo '<table border="0" cellpadding="2" cellspacing="0" width="100px" height="100%">';
    echo "<tr><td align='center'>V&auml;lj Månad</td></tr>";
    while($row = mysql_fetch_array( $result ))
    {
        //Skriver ut innehållet i raderna till HTML-tabellen
    echo "<tr><td align = 'center'>";
    echo "<a href=\"diagram.php?datum=";
    echo $row['year'];
    echo "-%%&forarid={$_SESSION['member_username']}\" target='left'>";
    echo $row['year'];
    echo "</a><br>";
    echo "</td></tr>";
    }
    // HTML-tabellens formatering - tabellslut
    echo '</table>';

////////////////////////////////////////////////////////////////////////////////
    // HÄR VISAS MENYN FÖR NAVIGERING 2:
    //  << första < föregående | sidan 1 av 25 | nästa > sista >>
    sidnavigering2($sida, $sidor_totalt);
////////////////////////////////////////////////////////////////////////////////

    // stänger databasen
    mysql_close($opendb);

    echo "</table>";
    echo "</td>";
?>


</td>
</table>
</body>
</html>
