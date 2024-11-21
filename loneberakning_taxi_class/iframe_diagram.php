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
<title>Diagram</title>
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
echo "<tr>";
echo "<td height='400' valign='top' align='left'>";
echo "<iframe src='frameset_diagram.php' border='1' name='iframe' width='100%' height='100%' scrolling='auto'></iframe>";
echo "</td>";
echo "</tr>";
################################################################################
        bottom_border();
        end_main_table();
      ?>
</body>
</html>
