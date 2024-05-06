<?php
if(!defined('AWM'))
	die('Nope.');
$q = Config::$g_con->prepare('SELECT SQLID, PlayerName, level, TotalPlayTime, Money, Bank FROM PlayerInfo WHERE level > 0 ORDER BY level+TotalPlayTime+Money+Bank DESC LIMIT 20');
$q->execute();

$rank = 0;
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Top Players
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
					Top
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>       
<div class="row">      
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="data">#</th>
						<th class="data">Name</th>
						<th class="data">Level</th>
						<th class="data">Played Hours</th>
						<th class="data">Money</th>
						<th class="data">Bank Money</th>
					
					</tr>
				</thead>
				<?php echo 
					'
					<tbody>';
						while($row = $q->fetch(PDO::FETCH_OBJ)) {
						$rank ++;
						echo 
						"<tr>
							<td align='center'>$rank</td>
							<td align='center'><a href=".Config::$_PAGE_URL.'profile2/'.$row->SQLID.">".$row->PlayerName."</td>
							<td align='center'>{$row->level}</td>
							<td align='center'>{$row->TotalPlayTime}</td>
							<td align='center'>". number_format("$row->Money",0,'.','.')." $</td>
							<td align='center'>". number_format("$row->Bank",0,'.','.')." $</td>
						</tr>";}
					echo"</tbody>";?>
				</table>
		</div>
	</div>
</div>
	 