<?php
session_start();
if($_SESSION['member_login'] == 'true'){}
else {header("Location: login.php");}
?>
<?php
  include '../loneberakning_taxi/jpgraph/jpgraph.php';
  include '../loneberakning_taxi/jpgraph/jpgraph_log.php';
  include '../loneberakning_taxi/jpgraph/jpgraph_line.php';
  include "_config.php";
  include "_connect_database.php";

  $manad                = $_GET["datum"];
  $forarid              = $_GET["forarid"];
  $datum_title          = substr($manad, 0, -3);
  $array_avg            = array();
  $array_y              = array();
  $result_avg           = mysql_query("SELECT AVG(inkort) AS inkort_avg FROM loneberakning WHERE forarid = '$forarid' AND datum LIKE '$manad';") or die(mysql_error());
  $result_y             = mysql_query("SELECT DATE_FORMAT(datum, '%m%d') AS datum, inkort FROM loneberakning WHERE forarid = '$forarid' AND datum LIKE '$manad' ORDER BY datum") or die(mysql_error());

  while($row = mysql_fetch_array( $result_y ))
     {
		$array_avg[]    = $result_avg;
        $array_y[]      = $row['inkort'];
	 }
  mysql_close($opendb);

  $graph = new Graph(480,350,"auto");
  $graph->tabtitle->Set($datum_title);
  $graph->tabtitle->SetWidth(TABTITLE_WIDTHFULL);
  $graph->tabtitle->SetColor('#BEC2CD;','#BEC2CD;');
  $graph->SetScale('textint');
  $graph->SetMarginColor('#E7E7E7');
  $graph->SetFrame(true);
  $graph->SetShadow();
  $graph->ygrid->SetFill(true,'#FFFFFF','#E0DFF7');
  $plot_y = new LinePlot($array_y);
  $plot_y->mark->SetType(MARK_UTRIANGLE );
  $plot_y->mark->SetColor('#E7E7E7');
  $plot_y->value->SetFormat('%d');
  $plot_y->value->SetColor('#3C4151');
  $plot_y->value-> Show();
  $graph->Add($plot_y);
  $plot_y->SetLegend($datum_title);
  $graph->legend->Pos(0.01,0.01,"left","top");

  $plot_avg = new LinePlot($array_avg);
  $plot_avg-> mark->SetType(MARK_UTRIANGLE );
  $plot_avg->value->SetFormat('%d');
  $plot_avg->value-> Show();
  $graph->Add($plot_avg);
  $graph->Stroke();
?>