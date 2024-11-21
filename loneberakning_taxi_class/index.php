<?php
        session_start();
        if($_SESSION['member_login'] == 'true'){}
        else {header("Location: login.php");}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="__mall.css" rel="stylesheet" type="text/css">
<title></title>
</head>
<body>
    <?php
        include "_config.php";
        include "_connect_database.php";
        include "_class.php";
        include "_functions.php";

        begin_main_table();
        top_border();
        menu_border();
        middle_border();
################################################################################
        begin_content();
        echo 'Detta är en webbplats för att få bättre översikt på dina körpass.
        Du kan registrera körpass - beräkna lön - se diagram över dina
        körpass mm.
        ';



        end_content();
################################################################################
        bottom_border();
        end_main_table();
        ?>
</body>
</html>
