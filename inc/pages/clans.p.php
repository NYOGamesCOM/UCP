<?php
if(!defined('AWM'))
	die('Nope.');
$q = Config::$g_con->prepare('SELECT a.playerName,g.clanName,g.clanID FROM clans g LEFT JOIN playeraccounts a ON ( a.playerClan = g.clanID) GROUP BY g.clanID');
$q->execute();
?>

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		THEG Clans
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
					Clans
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>

<?php	
echo '<div class="row">
		<div class="col-lg-12">
		
			<div class="table-responsive">
				 <table class="table table-hover">
					<thead>
			<th class="data">Clan name</th>
			<th class="data">Leader</th>
			<th class="data">Details</th>
		</tbody>
	';
while($row = $q->fetch(PDO::FETCH_OBJ)) {
	echo 
	"<tr>
		<td>{$row->clanName}</td>
		<td>" . (!$row->playerName ? 'No-one' : $row->playerName) . "</td>
		<td><a href='".Config::$_PAGE_URL."clan/".$row->clanID."'><i class='fa fa-search'></i></a></td>	
	</tr>";
}
echo '</table>';?>

</div>
