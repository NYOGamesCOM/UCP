<?php
if(!defined('AWM'))
	die('Nope.');
$q = Config::$g_con->prepare('SELECT SQLID, PlayerName, level FROM PlayerInfo WHERE level > 0 ORDER BY level DESC LIMIT 20');
$q->execute();

$rank = 0;
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Highest level
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
					Highest Level
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
						</tr>";}
					echo"</tbody>";?>
				</table>
		</div>
	</div>
</div>
	 