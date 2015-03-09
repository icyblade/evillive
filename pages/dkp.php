<?php
require_once "../class/guild.class.php";
require_once "../class/player.class.php";
require_once "../class/dkp.class.php";
?>
<html>
<head>
<title>evil live DKP 系统</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script src="../js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">  
	$(document).ready(function(){  
		$("#alltable").tablesorter();
	});
</script>
<style type="text/css">
/* Title */
#title {
	margin: 0 0 0.5em 0;
	font-weight: 600;
	font-family: 'Titillium Web', sans-serif, Microsoft YaHei;
	position: relative;  
	font-size: 36px;
	line-height: 40px;
	padding: 15px 15px 15px 15px;
	color: #355681;
	box-shadow: 
		inset 0 0 0 1px rgba(53,86,129, 0.4), 
		inset 0 0 5px rgba(53,86,129, 0.5),
		inset -285px 0 35px white;
	border-radius: 0 10px 0 10px;
}
/*General styles*/
body
{
	margin: 0;
	padding: 0;
	background: white no-repeat left top;
}

#main
{
	width: 960px;
	margin: 30px auto 0 auto;
	margin-bottom: 30px;
	background: white;
	-moz-border-radius: 8px;
	-webkit-border-radius: 8px;
	padding: 30px;
	border: 1px solid #adaa9f;
	-moz-box-shadow: 0 2px 2px #9c9c9c;
	-webkit-box-shadow: 0 2px 2px #9c9c9c;
}

/*Features table------------------------------------------------------------*/
.features-table
{
  width: 100%;
  margin: 0 auto;
  border: 0px;
  border-collapse: separate;
  border-spacing: 0;
  text-shadow: 0 1px 0 #fff;
  color: #2a2a2a;
  background: #fafafa;  
  background-image: -moz-linear-gradient(top, #fff, #eaeaea, #fff); /* Firefox 3.6 */
  background-image: -webkit-gradient(linear,center bottom,center top,from(#fff),color-stop(0.5, #eaeaea),to(#fff)); 
}

.features-table td
{
  height: 50px;
  line-height: 50px;
  padding: 0 20px;
  border-bottom: 1px solid #cdcdcd;
  box-shadow: 0 1px 0 white;
  -moz-box-shadow: 0 1px 0 white;
  -webkit-box-shadow: 0 1px 0 white;
  white-space: nowrap;
  text-align: center;
}

/*Body*/
.features-table tbody td
{
  text-align: center;
  font: normal 20px Verdana, Arial, Helvetica, Microsoft YaHei;
  width: 150px;
  border: 1px solid black;
}

.features-table tbody td:first-child
{
  width: auto;
  text-align: left;
}

.features-table td:nth-child(1)
{
  background: #efefef;
  background: rgba(144,144,144,0.15);
  border-right: 1px solid white;
}

.features-table td:nth-child(2)
{
  background: #e7f3d4;  
  background: rgba(184,243,85,0.3);
}
/*Header*/
.features-table thead th
{
  font: bold 1.3em 'trebuchet MS', 'Lucida Sans', Arial, Microsoft YaHei;  
  -moz-border-radius-topright: 10px;
  -moz-border-radius-topleft: 10px; 
  border-top-right-radius: 10px;
  border-top-left-radius: 10px;
  border-top: 1px solid #eaeaea;
}

.features-table thead th:first-child
{
  border-top: none;
}

/*Footer*/
.features-table tfoot td
{
  font: bold 1.4em Georgia, Microsoft YaHei;  
  -moz-border-radius-bottomright: 10px;
  -moz-border-radius-bottomleft: 10px; 
  border-bottom-right-radius: 10px;
  border-bottom-left-radius: 10px;
  border-bottom: 1px solid #dadada;
  border: 1px solid black;
}

.features-table tfoot td:first-child
{
  border-bottom: none;
}

/*Class color*/
.features-table tfoot td:nth-child(3){background: rgba(199,156,110,0.7);}
.features-table tfoot td:nth-child(4){background: rgba(245,140,186,0.7);}
.features-table tfoot td:nth-child(5){background: rgba(196,30,59,0.7);}
.features-table tfoot td:nth-child(6){background: rgba(0,112,222,0.7);}
.features-table tfoot td:nth-child(7){background: rgba(171,212,115,0.7);}
.features-table tfoot td:nth-child(8){background: rgba(255,125,10,0.7);}
.features-table tfoot td:nth-child(9){background: rgba(0,255,150,0.7);}
.features-table tfoot td:nth-child(10){background: rgba(255,245,105,0.7);}
.features-table tfoot td:nth-child(11){background: rgba(255,255,255,0.7);}
.features-table tfoot td:nth-child(12){background: rgba(148,130,201,0.7);}
.features-table tfoot td:nth-child(13){background: rgba(105,204,240,0.7);}

/*Note*/
.note {
font: normal 15px Verdana, Arial, Helvetica, Microsoft YaHei;
}
</style>
</head>
<body>
<div id="main">
<p id="title" align="center">DKP 排名</p>
<!-- Progress bar -->
<div id="progressbar" style="border:1px solid #ccc;margin: 0 0 0.5em 0;">
<div style="width:0%;background-color:#ddd;">&nbsp;</div>
</div>
<table id="alltable" class="features-table" border="1">
<thead><tr><th>排名</th><th>ID</th><th>职业</th><th>DKP</th></tr></thead>
<tbody>
<?php
$g = new Guild();
list($server, $members) = $g->get_guild_members();
$template = '<tr><td>%s</td><td><a href="http://www.battlenet.com.cn/wow/zh/character/%s/%s/advanced">%s</a></td><td><img src="./img/Classicon_%s.png" height="32" width="32"></td><td>%s</td></tr>';
$total = count($members);
$arr = array();
foreach($members as $no=>$id) {
	$percent = intval(($no+1)/$total * 100)."%";
	$d = new Dkp($id);
	$p = new Player($id);
	$arr[] = array($id, $p->get_class(), $d->get_total_dkp());
	// update progress bar
	echo '<script language="javascript">
    document.getElementById("progressbar").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    </script>';
	flush();
}
function sort_by_dkp($a, $b) {
	return $b[2] - $a[2];
}
usort($arr, 'sort_by_dkp');
foreach($arr as $no=>$line) {
	echo sprintf($template, $no+1, $server, $line[0], $line[0], strtolower($line[1]), $line[2]);
}
?>
</tbody>
</table>
</div>

</body>
</html>
