<?php
require_once "../class/guild.class.php";
require_once "../class/player.class.php";
?>
<html>
<head>
<title>装等排名</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script src="../js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">  
	$(document).ready(function(){  
		$("#alltable").tablesorter({
			textExtraction:function(s){
				if($(s).find('img').length == 0) return $(s).text();
				return $(s).find('img').attr('alt');
			}
		});
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
<p id="title" align="center">装等排名</p>
<!-- Progress bar -->
<div id="progressbar" style="border:1px solid #ccc;margin: 0 0 0.5em 0;">
<div style="width:0%;background-color:#ddd;">&nbsp;</div>
</div>
<table id="alltable" class="features-table" border="1">
<thead><tr><th>排名</th><th>ID</th><th>职业</th><th>当前装等</th><th>最高装等</th></tr></thead>
<tbody>
<?php
$g = new Guild();
list($server, $members) = $g->get_guild_members();
$template = '<tr><td>%s</td><td><a href="http://www.battlenet.com.cn/wow/zh/character/%s/%s/advanced">%s</a></td><td><img src="./img/Classicon_%s.png" height="32" width="32" alt="%s"></td><td>%s</td><td>%s</td></tr>';
$total = count($members);
$arr = array();
$avg_ilvl = 0;
$avg_max_ilvl = 0;
foreach($members as $no=>$id) {
	$percent = intval(($no+1)/$total * 100)."%";
	$p = new Player($id);
	$ilvl = $p->get_current_item_lvl();
	$avg_ilvl += $ilvl;
	$max_ilvl = $p->get_max_item_lvl();
	$avg_max_ilvl += $max_ilvl;
	$arr[] = array($id, $p->get_class(), $ilvl, $max_ilvl);
	// update progress bar
	echo '<script language="javascript">
    document.getElementById("progressbar").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    </script>';
	flush();
}
$avg_ilvl /= $total;
$avg_max_ilvl /= $total;
function sort_by_current_item_lvl($a, $b) {
	return $b[2] - $a[2];
}
usort($arr, 'sort_by_current_item_lvl');
foreach($arr as $no=>$line) {
	echo sprintf($template, $no+1, $server, $line[0], $line[0], strtolower($line[1]), strtolower($line[1]), $line[2],$line[3], $line[4]);
}
?>
</tbody>
<tfoot><tr><td>总计人数</td><td><?php echo $total;?></td><td>平均装等</td><td><?php echo intval(10*$avg_ilvl)/10;?></td><td><?php echo intval(10*$avg_max_ilvl)/10;?></td></tr></tfoot>
</table>
</div>

</body>
</html>
