<?php
############################ BEGIN MAIN TABLE ##################################

    function begin_main_table(){
        echo "<table class='maintable' cellspacing='0' cellPadding='0' border='0' align='center' valign='top'><tr><td>";
    }

############################ END MAIN TABLE ####################################

    function end_main_table(){
        echo "</tr></td></table>";
    }

############################ MENY TABLE ########################################

    function menu_border(){
        echo "<tr>";
        echo "<td colspan='3' valign ='top'>";
        echo "<table border='0' cellpadding='0' cellspacing='0'>";
        echo "<tr>";
        echo "<td class='i_border' align='left'>";
        echo "<a href='index.php'>          <img src='images/action_gohome.png' border='0' alt='Home'></a>";
        echo "<a href='korpass.php?cmd=add'><img src='images/action_db_add.png' border='0' alt='Registrera K&ouml;rpass'></a>";
        echo "<a href='loneberakning.php'>  <img src='images/app_calc.png'      border='0' alt='L&ouml;neber&auml;kning'></a>";
        echo "<a href='iframe_diagram.php'> <img src='images/app_kchart.png'    border='0' alt='Diagram'></a>";
        echo "<a href='redigera_lista.php'> <img src='images/app_edit.png'      border='0' alt='Radera - Editera K&ouml;rpass'></a>";
        echo "<a href='edit_account.php'>   <img src='images/app_kdmconfig.png' border='0' alt='Redigera Kontouppgifter'></a>";
        echo "</td>";
        echo "<td class='i_border' align='right'>";
        echo "<a href='logout.php'>         <img src='images/app_shutdown.png'  border='0' alt='Exit'></a>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</tr>";
    }

############################ TOP TABLE #########################################

    function top_border(){
        echo "<tr>";
        echo "<td colspan='3'>";
        echo "<table class='t_border' border='0' cellpadding='0' cellspacing='0'>";
        echo "<tr>";
        echo "<td class='t_border' valign ='middle' align='right'>.: INLOGGAD SOM : {$_SESSION['member_username']} :.</td>";
        echo "</tr>";
        echo "</table>";
        echo "</tr>";
    }

 ############################ MIDDLE TABLE #####################################

    function middle_border(){
        echo "<tr>";
        echo "<td colspan='3'>";
        echo "<table class='m_border' border='0' cellpadding='0' cellspacing='0'>";
        echo "<tr>";
        echo "<td class='m_border'></td>";
        echo "</tr>";
        echo "</table>";
        echo "</tr>";
    }

############################ BOTTOM TABLE ######################################

    function bottom_border(){
        echo "<tr>";
        echo "<td colspan='3'>";
        echo "<table class='b_border' border='0' cellpadding='0' cellspacing='0'>";
        echo "<tr>";
        echo "<td class='b_border'></td>";
        echo "</tr>";
        echo "</table>";
        echo "</tr>";
    }

############################ BEGIN CONTENT #####################################

    function begin_content(){
        echo "<tr>";
        echo "<td valign='top' height='400'>";
        echo "<div class='box'><p>";
    }

############################ END CONTENT #######################################

    function end_content(){
        echo "</p></div>";
        echo "</td>";
        echo "</tr>";
    }

############################ PRINT FUNCTIONS ###################################

    function print_loneberakning_lista($manad,$opendb){
        $manad;
        $opendb;
        $arraykorpass = array();

        echo "<tr>
        <td>Pass Datum</td>
        <td>Pass Nummer</td>
        <td>Summa Inkört</td>
        <td>Att Redovisa</td>
        <td>Redovisat</td>
        </tr>";

        $result = mysql_query("SELECT * FROM loneberakning WHERE forarid = '{$_SESSION['member_username']}' AND datum LIKE '$manad' ORDER BY datum") or die(mysql_error());
        while($row = mysql_fetch_array( $result )){
            $korpass=new korpass(
            $row['raknare'],
            $row['datum'],
            $row['forarid'],
            $row['passnr'],
            $row['inkort'],
            $row['attredovisa'],
            $row['redovisat']);
            $arraykorpass[]=$korpass;

            echo "<tr>";
            echo "<td>{$korpass->getdatum()}</td>";
            echo "<td>{$korpass->getpassnr()}</td>";
            echo "<td>{$korpass->getinkort()}</td>";
            echo "<td>{$korpass->getattredovisa()}</td>";
            echo "<td>{$korpass->getredovisat()}</td>";
            echo "</tr>";
        }
        mysql_close($opendb);
    }

############################ PRINT FUNCTIONS ###################################

    function print_loneberakning($manad,$opendb){
        include "_config.php";
        include "_connect_database.php";
        //Hämtar information från formuläret
        $manad;
        $vald_manad     = substr($manad,0,-3);
        if ($vald_manad == ''){
            $vald_manad = 'Ej Vald';
        }
        $datum_ar   = substr($manad,0,-6) . "-%%-%%";

        //Hämtar information från tabellen
        //Summa inkört totalt
        $inkort_ar     = mysql_query("SELECT SUM(inkort) FROM loneberakning WHERE forarid = '{$_SESSION['member_username']}' AND datum LIKE '$datum_ar'") or die(mysql_error());
        $inkort_sum_ar = mysql_fetch_array($inkort_ar);

        //Summa inkört månad
        $result        = mysql_query("SELECT * FROM loneberakning WHERE forarid = '{$_SESSION['member_username']}' AND datum LIKE '$manad'") or die(mysql_error());
        $inkort_sum_manad;
        $attredovisa_sum_manad;
        $redovisat_sum_manad;
        $pass_sum_manad;
        $avg_inkort_manad;

        while($row=mysql_fetch_array($result)){
        $array_korpass[]=$korpass=new korpass(
        $row['raknare'],
        $row['datum'],
        $row['forarid'],
        $row['passnr'],
        $row['inkort'],
        $row['attredovisa'],
        $row['redovisat']);
        }

        for ($i=0;$i<=count($array_korpass)-1;$i++){
        $korpass               = $array_korpass[$i];
        $inkort_sum_manad      = $inkort_sum_manad      + $korpass->getinkort();
        $attredovisa_sum_manad = $attredovisa_sum_manad + $korpass->getattredovisa();
        $redovisat_sum_manad   = $redovisat_sum_manad   + $korpass->getredovisat();
        $pass_sum_manad ++;
        }
        if ($manad <> ''){
        $avg_inkort_manad = $inkort_sum_manad/$pass_sum_manad;
        }
        //Deklarera variabler
        //Inkort_sum_ar_print
        $inkort_sum_ar_print=$inkort_sum_ar['SUM(inkort)'];
        if ($inkort_sum_ar['SUM(inkort)'] == ''){
            $inkort_sum_ar_print=0;
        }
        //inkortinkmoms_print
        $inkortinkmoms_print=$inkort_sum_manad;
        if ($inkort_sum_manad == ''){
            $inkortinkmoms_print=0;
        }
        //attredovisa_print
        $attredovisa_print=$attredovisa_sum_manad;
        if ($attredovisa_sum_manad == ''){
            $attredovisa_print=0;
        }
        //redovisat_print
        $redovisat_print=$redovisat_sum_manad;
        if ($redovisat_sum_manad == ''){
            $redovisat_print=0;
        }
        $skatt                  =           1-($_SESSION['member_skatt'] / 100);
        $provision              =         ($_SESSION['member_provision'] / 100);
        $semester_ers           =                    (0.94 * $provision * 0.13);
        $result_avg_print       = round(                     $avg_inkort_manad);
        $semester_ers_ar_print  = round($inkort_sum_ar_print   * $semester_ers);
        $inkortexmoms_print     = round($inkortinkmoms_print            * 0.94);
        $lonforeskatt_print     = round($inkortexmoms_print       * $provision);
        $lonefterskatt_print    = round($lonforeskatt_print           * $skatt);
        $semester_ers_print     = round($lonforeskatt_print             * 0.13);
        $redovisningsdiff_print = $redovisat_print         - $attredovisa_print;

        //Löneberäkningstabell
        echo "<tr><td class='toptd'>Vald Månad:      </td><td class='toptd' align = 'right' td>$vald_manad</td></tr>";
        echo "<tr><td class='td'>Inkört under Året:  </td><td class='td'    align = 'right' td>$inkort_sum_ar_print</td></tr>";
        echo "<tr><td class='td'>Inkört ink Moms:    </td><td class='td'    align = 'right' td>$inkortinkmoms_print</td></tr>";
        echo "<tr><td class='td'>Inkört ex Moms:     </td><td class='td'    align = 'right' td>$inkortexmoms_print</td></tr>";
        echo "<tr><td class='td'>Genomsnitt Månad:   </td><td class='td'    align = 'right' td>$result_avg_print</td></tr>";
        echo "<tr><td class='td'>Sem ers År:         </td><td class='td'    align = 'right' td>$semester_ers_ar_print</td></tr>";
        echo "<tr><td class='td'>Sem ers Månad:      </td><td class='td'    align = 'right' td>$semester_ers_print</td></tr>";
        echo "<tr><td class='td'>Lön före Skatt:     </td><td class='td'    align = 'right' td>$lonforeskatt_print</td></tr>";
        echo "<tr><td class='td'>Att Redovisa:       </td><td class='td'    align = 'right' td>$attredovisa_print</td></tr>";
        echo "<tr><td class='td'>Redovisat:          </td><td class='td'    align = 'right' td>$redovisat_print</td></tr>";
        echo "<tr><td class='td'>Redovisningsdiff:   </td><td class='td'    align = 'right' td>$redovisningsdiff_print</td></tr>";
        echo "<tr><td class='td'>Lön efter Skatt:    </td><td class='td'    align = 'right' td>$lonefterskatt_print</td></tr>";

        mysql_close($opendb);
    }

    function print_button(){
        echo "<tr><td><br></td></tr>";
        echo "<td><td align='right'>";
        echo "<a href='#' onclick='window.print()'><img src='images/app_printer.png' width='25' height='25' border='0' alt='Skriv ut'>";
        echo "<xt:intl></xt:intl></a></td></td>";
    }
?>