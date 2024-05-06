<?php
if(!defined('AWM'))
	die('Nope.');
$q = Config::$g_con->prepare('SELECT * FROM `referral_log` ORDER BY `rIP` DESC ' . Config::init()->_pagLimit());
$q->execute();
echo '
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
<div class="row">
	<div class="col-md-12">
<table class="table table-bordered table-hover">
		<tr class="data">
			<th class="data">Name</th>
			<th class="data">IP</th>
			<th class="data">Used Referral</th>';	
echo '</tr>';
while($row = $q->fetch(PDO::FETCH_OBJ)) {
	echo 
	"<tr class='ban_{$row->Name}'>
		<td align='center'><font size=2>{$row->Name}</font></td>
		<td align='center'><font size=2>{$row->rIP}</font></td>
		<td align='center'><font size=2>{$row->rName}</font></td>";
		
}
echo '</table></div></div>';
echo '<center>'; echo Config::_pagLinks(Config::rows('referral_log')); echo '</center>';
?>
<?php if(Config::isLogged() && $admin != 0) { ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	
<?php } ?>