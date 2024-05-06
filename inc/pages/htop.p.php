<?php
if(!defined('AWM'))
	die('Nope.');

if(Config::isLogged()) {

$user = $_SESSION['awm_user'];
$admin = Config::getPlayerData($user,'playerAdminLevel');
$helper = Config::getPlayerData($user,'playerHelperLevel');
}

$q = Config::$g_con->prepare('SELECT playerID, playerName, playerHelps FROM playeraccounts WHERE playerHelperLevel > 0 ORDER BY playerHelps DESC LIMIT 20');
$q->execute();

$rank = 0;
?>


<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Staff
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
					Staff
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>	

<?php if($admin > 0 or $helper > 0) {?>
<div class="row">  
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="data">#</th>
						<th class="data">Name</th>
						<th class="data">Helps</th>
					
					</tr>
				</thead>
				<?php echo 
					'
					<tbody>';
						while($row = $q->fetch(PDO::FETCH_OBJ)) {
						$rank ++;
						echo 
						"<tr>
							<td align='center'><font size=2>$rank</font></td>
							<td align='center'><font size=2><a href=".Config::$_PAGE_URL.'profile/'.$row->playerID.">".$row->playerName."</font></td>
							<td align='center'><font size=2>{$row->playerHelps}</font></td>
						</tr>";}
					echo"</tbody>";?>
				</table>
		</div>
	</div>
</div>
<?php }?>
	