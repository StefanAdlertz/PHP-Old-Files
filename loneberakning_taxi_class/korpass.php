<?php
    session_start();
    if($_SESSION['member_login'] == 'true'){}
    else {header("Location: login.php");}

    echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN'>";
    echo "<html>";
    echo "<head>";
    echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
    echo "<script language='javascript' type='text/javascript' src='datetimepicker.js'></script>";
    echo "<link href='__mall.css' rel='stylesheet' type='text/css'>";
    echo "<title>Registrera K&ouml;rpass</title>";
    echo "</head>";
    echo "<body>";

    include "_config.php";
    include "_connect_database.php";
    include "_class.php";
    include "_functions.php";

    begin_main_table();
    top_border();
    menu_border();
    middle_border();
################################################################################

    echo"<tr>";
    echo"<td colspan='3' valign ='top'>";
    echo"<table align='left' border='0' cellpadding='2' cellspacing='0' width=100%>";
    echo"<td height='400' valign='top'>";  
    
    if($_GET["cmd"]=="update"){
        echo "<title>Editera K&ouml;rpass</title>";
        $forarid        = $_SESSION['member_username'];
        $manad          = $_GET["manad"];
        $sida           = $_GET["sida"];
        $raknare        = $_GET["raknare"];
        $datum          = $_GET["datum"];
        $passnr         = $_GET["passnr"];
        $inkort         = $_GET["inkort"];
        $attredovisa    = $_GET["attredovisa"];
        $redovisat      = $_GET["redovisat"];

        echo"<form action='sql_korpass_save.php?cmd=update&raknare=$raknare&manad=$manad&sida=$sida' form method='post'>";
        echo"<table border='0' cellpadding='2' cellspacing='0' bgcolor='#ccff66' class='formularfalt'>";
        echo"<tr><td align='right'>Datum</td>        <td><input name='datum'         type='text' class='skugga' value='$datum'></td></tr><br>";
        echo"<tr><td align='right'>Passnummer</td>   <td><input name='passnr'        type='text' class='skugga' value='$passnr'></td></tr><br>";
        echo"<tr><td align='right'>Inkört</td>       <td><input name='inkort'        type='text' class='skugga' value='$inkort'></td></tr><br>";
        echo"<tr><td align='right'>Att Redovisa</td> <td><input name='attredovisa'   type='text' class='skugga' value='$attredovisa'></td></tr><br>";
        echo"<tr><td align='right'>Redovisat</td>    <td><input name='redovisat'     type='text' class='skugga' value='$redovisat'></td></tr><br>";
        echo"<tr><td>&nbsp;</td>                     <td><input type='submit' value='&Auml;ndra' class='button'></td>";
        echo"</table>";
        echo"<br>";
        echo"</form>";

    }

    if($_GET["cmd"]=="add"){
        echo"<form action='sql_korpass_save.php?cmd=add' form method='post'>";
        echo"<table border='0' cellpadding='2' cellspacing='0' bgcolor='#ccff66' class='formularfalt'>";
        echo"<tr><td align='right'>Datum</td>        <td><input name='datum' type='text' class='skugga'></td>";
        ?>
        <td><a href="javascript:NewCal('datum','yyyymmdd')"><img src="images/app_date.png" width="20" height="20" border="0" alt="Välj Datum"></a></td>
        <?php
        echo"</tr><br>";
        echo"<tr><td align='right'>Passnummer</td>   <td><input name='passnr'        type='text' class='skugga'></td></tr><br>";
        echo"<tr><td align='right'>Inkört</td>       <td><input name='inkort'        type='text' class='skugga'></td></tr><br>";
        echo"<tr><td align='right'>Att Redovisa</td> <td><input name='attredovisa'   type='text' class='skugga'></td></tr><br>";
        echo"<tr><td align='right'>Redovisat</td>    <td><input name='redovisat'     type='text' class='skugga'></td></tr><br>";
        echo"<tr><td>&nbsp;</td>                     <td><input type='submit' value='Redovisa' class='button'></td>";
        echo"</table>";
        echo"<br>";
        echo"</form>";
    }

    echo"</td>";
    echo"</table>";
    echo"</tr>";

################################################################################
    bottom_border();
    end_main_table();

    echo"</body>";
    echo"</html>";
    ?>
