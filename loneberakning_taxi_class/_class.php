<?php
session_start();
if($_SESSION['member_login'] == 'true'){}
else {header("Location: login.php");}

include "_config.php";
include "_connect_database.php";

############################ CLASS KORPASS #####################################

    class korpass{
    private $raknare;
    private $datum;
    private $forarid;
    private $passnr;
    private $inkort;
    private $attredovisa;
    private $redovisat;

############################ KORPASS CONSTRUCTOR ###############################

    function __construct($raknare,$datum,$forarid,$passnr,$inkort,$attredovisa,$redovisat){
        $this->setraknare($raknare);
        $this->setdatum($datum);
        $this->setforarid($forarid);
        $this->setpassnr($passnr);
        $this->setinkort($inkort);
        $this->setattredovisa($attredovisa);
        $this->setredovisat($redovisat);
    }

############################ KORPASS SET #######################################

    function setraknare($raknare){
        $this->raknare=$raknare;
    }
    function setdatum($datum){
        $this->datum=$datum;
    }
    function setforarid($forarid){
        $this->forarid=$forarid;
    }
    function setpassnr($passnr){
        $this->passnr=$passnr;
    }
    function setinkort($inkort){
        $this->inkort=$inkort;
    }
    function setattredovisa($attredovisa){
        $this->attredovisa=$attredovisa;
    }
    function setredovisat($redovisat){
        $this->redovisat=$redovisat;
    }

############################ KORPASS GET #######################################

    function getraknare(){
        return $this->raknare;
    }
    function getdatum(){
        return $this->datum;
    }
    function getforarid(){
        return $this->forarid;
    }
    function getpassnr(){
        return $this->passnr;
    }
    function getinkort(){
        return $this->inkort;
    }
    function getattredovisa(){
        return $this->attredovisa;
    }
    function getredovisat(){
        return $this->redovisat;
    }

############################ KORPASS PRINT #####################################

    function printraknare(){
        echo "<td class='td' align='right'>";
        echo $this->raknare;
        echo "</td>";
    }
    function printdatum(){
        echo "<td class='td' align='right'>";
        echo $this->datum;
        echo "</td>";
    }
    function printforarid(){
        echo "<td class='td' align='right'>";
        echo $this->forarid;
        echo "</td>";
    }
    function printpassnr(){
        echo "<td class='td' align='right'>";
        echo $this->passnr;
        echo "</td>";
    }
    function printinkort(){
        echo "<td class='td' align='right'>";
        echo $this->inkort;
        echo "</td>";
    }
    function printattredovisa(){
        echo "<td class='td' align='right'>";
        echo $this->attredovisa;
        echo "</td>";
    }
    function printredovisat(){
        echo "<td class='td' align='right'>";
        echo $this->redovisat;
        echo "</td>";
    }

############################ SQL SAVE ##########################################

    function sqlsave(){
        $datum=$this->datum;
        $forarid=$this->forarid;
        $passnr=$this->passnr;
        $inkort=$this->inkort;
        $attredovisa=$this->attredovisa;
        $redovisat=$this->redovisat;
        $dbhost="localhost";
        $dbuser="adlertz_se";
        $dbpass="mysqladlertz";
        $dbname="adlertz_se";
        $opendb=mysql_connect($dbhost, $dbuser, $dbpass);
        $sql=mysql_query("insert into loneberakning(datum, forarid, passnr, inkort, attredovisa, redovisat)
        values('$datum','$forarid','$passnr','$inkort','$attredovisa','$redovisat')");
        mysql_close($opendb);
    }

############################ SQL UPDATE ########################################

    function sqlupdate(){
        $raknare=$this->raknare;
        $datum=$this->datum;
        $forarid=$this->forarid;
        $passnr=$this->passnr;
        $inkort=$this->inkort;
        $attredovisa=$this->attredovisa;
        $redovisat=$this->redovisat;
        $dbhost="localhost";
        $dbuser="adlertz_se";
        $dbpass="mysqladlertz";
        $dbname="adlertz_se";
        $opendb=mysql_connect($dbhost, $dbuser, $dbpass);
        mysql_select_db($dbname);
        $sql=mysql_query("update loneberakning set datum='$datum', passnr='$passnr', inkort='$inkort', attredovisa='$attredovisa', redovisat='$redovisat'
        where raknare='$raknare' and forarid='$forarid';");
        mysql_close($opendb);
    }

############################ SQL DELETE ########################################

    function sqldelete(){
        $raknare=$this->raknare;
        $forarid=$this->forarid;
        $dbhost="localhost";
        $dbuser="adlertz_se";
        $dbpass="mysqladlertz";
        $dbname="adlertz_se";
        $opendb=mysql_connect($dbhost, $dbuser, $dbpass);
        mysql_select_db($dbname);
        $sql=mysql_query("delete from loneberakning where raknare = '$raknare' and forarid = '$forarid'");
        mysql_close($opendb);
    }
}

############################ END OF KORPASS ####################################



?>
