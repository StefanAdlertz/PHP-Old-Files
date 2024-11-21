<?php
session_start();
if($_SESSION['member_login'] == 'true'){}
else {header("Location: login.php");}

include "_config.php";
include "_connect_database.php";
include "_class.php";

$raknare        = $_GET["raknare"];
$manad          = $_GET["manad"];
$sida           = $_GET["sida"];
$datum          = mysql_real_escape_string($_POST["datum"]);
$forarid        = $_SESSION['member_username'];
$passnr         = mysql_real_escape_string($_POST["passnr"]);
$inkort         = mysql_real_escape_string($_POST["inkort"]);
$attredovisa    = mysql_real_escape_string($_POST["attredovisa"]);
$redovisat      = mysql_real_escape_string($_POST["redovisat"]);

################################# SAVE #########################################

if($_GET["cmd"]=="add"){
    $korpass=new korpass(
    $raknare,
    $datum,
    $forarid,
    $passnr,
    $inkort,
    $attredovisa,
    $redovisat);
    
    $korpass->sqlsave();
    $page_name = "korpass.php?cmd=add";   
}

################################# DELETE #######################################

if($_GET["cmd"]=="delete"){

    $korpass=new korpass(
    $raknare,
    $datum,
    $forarid,
    $passnr,
    $inkort,
    $attredovisa,
    $redovisat);

    $korpass->sqldelete();
    $page_name="redigera_lista.php?manad=$manad&sida=$sida";   
}

################################# UPDATE #######################################

if($_GET["cmd"]=="update"){
    $korpass=new korpass(
    $raknare,
    $datum,
    $forarid,
    $passnr,
    $inkort,
    $attredovisa,
    $redovisat);

    $korpass->sqlupdate();
    $page_name="redigera_lista.php?manad=$manad&sida=$sida";
}

################################################################################

{header("Location: $page_name");}
?>