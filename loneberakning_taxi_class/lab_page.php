<?php
include "_config.php";
include "_connect_database.php";
include "_class.php";

    for ($i1=1;$i1<13;$i1++){
        for ($i2=1;$i2<28;$i2++){
            $manad=$i1;
            $datum          =date('Y-m-d',mktime($H,$i2,$s,$manad,$i2,2004));
            $inkort         =rand(2000,6000);
            $passnr         =rand(1,400);
            $forarid        ='710304';
            $attredovisa    =rand(2000,6000);
            $redovisat      =rand(2000,6000);
//            $sql=mysql_query("insert into loneberakning(datum, forarid, passnr, inkort, attredovisa, redovisat)
//            values('$datum','$forarid','$passnr','$inkort','$attredovisa','$redovisat')");
            echo $datum;
            echo "<br>";

        }
    }
?>
