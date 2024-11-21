<?php
session_start();
//if($_SESSION['member_login'] == 'true'){}
//else {header("Location: login.php");}

include "__config.php";
include "__connect_database.php";

################################################################################
############################ CLASS FORETAG #####################################
################################################################################

    class foretag{
    private $foretags_ID;
    private $foretagsnamn;
    private $adress;
    private $leveransadress;
    private $postnr;
    private $postadress;
    private $orgnummer;
    private $telefon;
    private $epost;
    private $ovrigt;

############################ FORETAG CONSTRUCTOR ###############################

    function __construct($foretags_ID,$foretagsnamn,$adress,$leveransadress,$postnr,$postadress,$orgnummer,$telefon,$epost,$ovrigt){
        $this->setforetags_ID($foretags_ID);
        $this->setforetagsnamn($foretagsnamn);
        $this->setadress($adress);
        $this->setleveransadress($leveransadress);
        $this->setpostnr($postnr);
        $this->setpostadress($postadress);
        $this->setorgnummer($orgnummer);
        $this->settelefon($telefon);
        $this->setepost($epost);
        $this->setovrigt($ovrigt);
    }

############################ FORETAG SET #######################################

    function setforetags_ID($foretags_ID){
        $this->foretags_ID=$foretags_ID;
    }
    function setforetagsnamn($foretagsnamn){
        $this->foretagsnamn=$foretagsnamn;
    }
    function setadress($adress){
        $this->adress=$adress;
    }
    function setleveransadress($leveransadress){
        $this->leveransadress=$leveransadress;
    }
    function setpostnr($postnr){
        $this->postnr=$postnr;
    }
    function setpostadress($postadress){
        $this->postadress=$postadress;
    }
    function setorgnummer($orgnummer){
        $this->orgnummer=$orgnummer;
    }
    function settelefon($telefon){
        $this->telefon=$telefon;
    }
    function setepost($epost){
        $this->epost=$epost;
    }
    function setovrigt($ovrigt){
        $this->ovrigt=$ovrigt;
    }

############################ FORETAG GET #######################################

    function getforetags_ID(){
        return $this->foretags_ID;
    }
    function getforetagsnamn(){
        return $this->foretagsnamn;
    }
    function getadress(){
        return $this->adress;
    }
    function getleveransadress(){
        return $this->leveransadress;
    }
    function getpostnr(){
        return $this->postnr;
    }
    function getpostadress(){
        return $this->postadress;
    }
    function getorgnummer(){
        return $this->orgnummer;
    }
    function gettelefon(){
        return $this->telefon;
    }
    function getepost(){
        return $this->epost;
    }
    function getovrigt(){
        return $this->ovrigt;
    }

############################ SQL SAVE ##########################################

    function sqlsave(){
        $foretagsnamn=$this->foretagsnamn;
        $adress=$this->adress;
        $leveransadress=$this->leveransadress;
        $postnr=$this->postnr;
        $postadress=$this->postadress;
        $orgnummer=$this->orgnummer;
        $telefon=$this->telefon;
        $epost=$this->epost;
        $ovrigt=$this->ovrigt;
        $dbhost="localhost";
        $dbuser="adlertz_se";
        $dbpass="mysqladlertz";
        $dbname="adlertz_se";
        $opendb=mysql_connect($dbhost, $dbuser, $dbpass);
        $sql=mysql_query("insert into crm_foretag(foretagsnamn, adress, leveransadress, postnr, postadress, orgnummer, telefon, epost, ovrigt)
        values('$foretagsnamn','$adress','$leveransadress','$postnr','$postadress','$orgnummer','$telefon','$epost','$ovrigt');");
        mysql_close($opendb);
    }

############################ SQL UPDATE ########################################

    function sqlupdate(){
        $foretagsnamn=$this->foretagsnamn;
        $adress=$this->adress;
        $leveransadress=$this->leveransadress;
        $postnr=$this->postnr;
        $postadress=$this->postadress;
        $orgnummer=$this->orgnummer;
        $telefon=$this->telefon;
        $epost=$this->epost;
        $ovrigt=$this->ovrigt;
        $dbhost="localhost";
        $dbuser="adlertz_se";
        $dbpass="mysqladlertz";
        $dbname="adlertz_se";
        $opendb=mysql_connect($dbhost, $dbuser, $dbpass);
        mysql_select_db($dbname);
        $sql=mysql_query("update crm_foretag set foretagsnamn='$foretagsnamn', adress='$adress', leveransadress='$leveransadress', postnr='$postnr', postadress='$postadress', orgnummer='$orgnummer', telefon='$telefon', epost='$epost', ovrigt='$ovrigt'
        where foretags_ID = '$foretags_ID' and foretagsnamn = '$foretagsnamn';");
        mysql_close($opendb);
    }

############################ SQL DELETE ########################################

    function sqldelete(){
        $foretags_ID=$this->foretags_ID;
        $foretagsnamn=$this->foretagsnamn;
        $dbhost="localhost";
        $dbuser="adlertz_se";
        $dbpass="mysqladlertz";
        $dbname="adlertz_se";
        $opendb=mysql_connect($dbhost, $dbuser, $dbpass);
        mysql_select_db($dbname);
        $sql=mysql_query("delete from crm_foretag where foretags_ID = '$foretags_ID' and foretagsnamn = '$foretagsnamn';");
        mysql_close($opendb);
    }
}

################################################################################
############################ END OF KORPASS ####################################
################################################################################



################################################################################
############################ CLASS KONTAKTPERSONER #############################
################################################################################

    class kontaktpersoner{
    private $kontaktperson_ID;
    private $foretags_ID;
    private $fnamn;
    private $enamn;
    private $titel;
    private $telefon;
    private $mobil;
    private $epost;
    private $ovrigt;

############################ KONTAKTPERSONER CONSTRUCTOR #######################

    function __construct($kontaktperson_ID,$foretags_ID,$fnamn,$enamn,$telefon,$mobil,$epost,$ovrigt){
        $this->setkontaktperson_ID($kontaktperson_ID);
        $this->setforetags_ID($foretags_ID);
        $this->setfnamn($fnamn);
        $this->setenamn($enamn);
        $this->settitel($titel);
        $this->settelefon($telefon);
        $this->setmobil($mobil);
        $this->setepost($epost);
        $this->setovrigt($ovrigt);
    }

############################ KONTAKTPERSONER SET ###############################

    function setkontaktperson_ID($kontaktperson_ID){
        $this->kontaktperson_ID=$kontaktperson_ID;
    }
    function setforetags_ID($foretags_ID){
        $this->foretags_ID=$foretags_ID;
    }
    function setfnamn($fnamn){
        $this->fnamn=$fnamn;
    }
    function setenamn($enamn){
        $this->enamn=$enamn;
    }
    function settitel($titel){
        $this->titel=$titel;
    }
    function settelefon($telefon){
        $this->telefon=$telefon;
    }
    function setmobil($mobil){
        $this->mobil=$mobil;
    }
    function setepost($epost){
        $this->epost=$epost;
    }
    function setovrigt($ovrigt){
        $this->ovrigt=$ovrigt;
    }

############################ KONTAKTPERSONER GET ###############################

    function getkontaktperson_ID(){
        return $this->kontaktperson_ID;
    }
    function getforetags_ID(){
        return $this->foretags_ID;
    }
    function getfnamn(){
        return $this->fnamn;
    }
    function getenamn(){
        return $this->enamn;
    }
    function gettitel(){
        return $this->titel;
    }
    function gettelefon(){
        return $this->telefon;
    }
    function getmobil(){
        return $this->mobil;
    }
    function getepost(){
        return $this->epost;
    }
    function getovrigt(){
        return $this->ovrigt;
    }

############################ SQL SAVE ##########################################

    function sqlsave(){
        $foretags_ID=$this->foretags_ID;
        $fnamn=$this->fnamn;
        $enamn=$this->enamn;
        $titel=$this->titel;
        $telefon=$this->telefon;
        $mobil=$this->mobil;
        $epost=$this->epost;
        $ovrigt=$this->ovrigt;
        $dbhost="localhost";
        $dbuser="adlertz_se";
        $dbpass="mysqladlertz";
        $dbname="adlertz_se";
        $opendb=mysql_connect($dbhost, $dbuser, $dbpass);
        $sql=mysql_query("insert into crm_kontaktpersoner(foretags_ID, fnamn, enamn, titel, telefon, mobil, epost, ovrigt)
        values('$foretags_ID','$fnamn','$enamn','$titel','$telefon','$mobil','$epost','$ovrigt');");
        mysql_close($opendb);
    }

############################ SQL UPDATE ########################################

    function sqlupdate(){
        $kontaktperson_ID=$this->kontaktperson_ID;
        $foretags_ID=$this->foretags_ID;
        $fnamn=$this->fnamn;
        $enamn=$this->enamn;
        $titel=$this->titel;
        $telefon=$this->telefon;
        $mobil=$this->mobil;
        $epost=$this->epost;
        $ovrigt=$this->ovrigt;
        $dbhost="localhost";
        $dbuser="adlertz_se";
        $dbpass="mysqladlertz";
        $dbname="adlertz_se";
        $opendb=mysql_connect($dbhost, $dbuser, $dbpass);
        mysql_select_db($dbname);
        $sql=mysql_query("update crm_kontaktpersoner set foretags_ID='$foretags_ID', fnamn='$fnamn', enamn='$enamn', titel='$titel', telefon='$telefon', mobil='$mobil' , epost='$epost, ovrigt='$ovrigt'
        where kontaktperson_ID = '$kontaktperson_ID' and foretags_ID = '$foretags_ID';");
        mysql_close($opendb);
    }

############################ SQL DELETE ########################################

    function sqldelete(){
        $kontaktperson_ID=$this->kontaktperson_ID;
        $foretags_ID=$this->foretags_ID;
        $dbhost="localhost";
        $dbuser="adlertz_se";
        $dbpass="mysqladlertz";
        $dbname="adlertz_se";
        $opendb=mysql_connect($dbhost, $dbuser, $dbpass);
        mysql_select_db($dbname);
        $sql=mysql_query("delete from crm_kontaktpersoner
        where kontaktperson_ID = '$kontaktperson_ID' and foretags_ID = '$foretags_ID';");
        mysql_close($opendb);
    }
}

################################################################################
############################ END OF KONTAKTPERSONER ############################
################################################################################

?>

