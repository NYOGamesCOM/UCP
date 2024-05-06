<?php
if(!defined('AWM'))
	die('Nope.');
$q = Config::$g_con->prepare('SELECT ID, FactioName, Leader, MaxMembers FROM FactionInfo GROUP BY ID');
$q->execute();


?>

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Factions
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
					Factions
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<?php	
echo '<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-12">
			<div class="table-responsive">
				 <table class="table table-hover">
					<thead>
			<th class="data">Faction ID</th>
			<th class="data">Faction name</th>
			<th class="data">Leader</th>
			<th class="data">Max Members</th>
		</tbody>
	';
while($row = $q->fetch(PDO::FETCH_OBJ)) {
$m = Config::$g_con->prepare('SELECT SQLID FROM PlayerInfo WHERE FactionName = ?');
$m->execute(array($row->ID));
$numm = $m->rowCount();

	echo 
	"<tr>
		<td>{$row->FactionID}</td>
		<td>" . (!$row->PlayerName ? 'No-one(Available)' : '<a href='.Config::$_PAGE_URL.'profile/'.$row->SQLID.'>'.$row->PlayerName.'</a>') . "</td>
		<td>{$numm}/{$row->MaxMembers}</td>
		<td><a href='".Config::$_PAGE_URL."faction/".$row->ID."'><i class='fa fa-search'></i></a></td>		
	</tr>";
}
echo '</table></div>';?>


</div>
</div>
</div>

