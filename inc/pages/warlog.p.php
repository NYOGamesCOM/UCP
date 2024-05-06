<?php
if(!defined('AWM'))
	die('Nope.');
if(!Config::isLogged() && !isset(Config::$_url[1])) header('Location: ' . $_PAGE_URL . 'login');


$q = Config::$g_con->prepare('SELECT * FROM `log_war` ORDER BY `id` DESC ' . Config::init()->_pagLimit());
$q->execute();



?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		War Logs
		</h3>
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="<?php echo Config::$_PAGE_URL; ?>">
					Home
				</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">
					War Logs
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>          
<?php                   
echo ' <div class="row"><div class="col-md-12">

		<div class="table-responsive">
			<table class="table table-bordered table-advance table-hover">
				<thead>
					<tr class="data">
						<th class="data">ID</th>
						<th class="data">Details</th>
						<th class="data">Date</th>';
					echo '</tr>
				</thead>';
	echo 
				"<tbody>";
					while($row = $q->fetch(PDO::FETCH_OBJ)) {
					$date = new DateTime();
					$date->setTimestamp($row->war_time);
					$string = $row->war_text;
					$trans = array("{F7CC22}" => "<font color=F7CC22>", "{FFFFFF}" => "</font><font size=2>", "{309ED3}" => "<font color=309ED3>");
					$result = strtr($string,$trans);
					echo"<tr class='ban_{$row->id}'>
						<td><font size=2>{$row->id}</font></td>
						<td><font size=2>{$result}</font></td>
						<td><font size=2>{$date->format('Y-m-d H:i:s')}</font></td>
					</tr>";}
				echo"</tbody>
			</table>";
			echo "</div>";
?>

<center><?php echo Config::_pagLinks(Config::rows('log_war'));?></center>
</div>
</div>


