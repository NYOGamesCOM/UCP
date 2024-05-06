<?php
if(!defined('AWM'))
	die('Nope.');


$q = Config::$g_con->prepare('SELECT `Banned` FROM `PlayerInfo` ORDER BY `Banned` DESC ' . Config::init()->_pagLimit());
$q->execute();
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Banlist
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
					Banlist
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<div class="col-md-12">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-advance table-hover">
		<thead>
		<tr>
			<th>
				<i class="fa fa-sort-numeric-asc"></i> ID
			</th>
			<th class="hidden-xs">
				<i class="fa fa-user"></i> Banned player
			</th>
			<th>
				<i class="fa fa-at"></i> Banned by
			</th>
			<th>
				<i class="fa fa-comment"></i> Reason
			</th>
			<th>
				<i class="fa fa-clock-o"></i> Date
			</th>
			<?php if(Config::isLogged()) {
			$admin = Config::getPlayerData($_SESSION['awm_user'],'AdminLevel');
			if($admin != 0) echo '<th><i class="fa fa-unlock-alt"></i>Unban</th>';	
			}?>
		</tr>
		</thead>
		<tbody>
		<?php while($row = $q->fetch(PDO::FETCH_OBJ)) {
		echo"<tr class='{$row->Banned}'>
			<td>{$row->PlayerName}</td>
			<td>".($row->WhoBannedMe)."</td>
			<td>".($row->BanReason)."</td>
			<td>{$row->WhenIGotBanned}</td>";
			echo(Config::isLogged() && $admin != 0 ? 
			'<td align="center"><img src="'.Config::$_PAGE_URL.'assets/img/remove.png" class="unban" id="'.$row->Banned.'" style="cursor:pointer;"></td>' : '');
		echo "</tr>";}?>
		</tbody>
		</table>
		<center><?php echo Config::_pagLinks(Config::rows('bans'));?></center>
	</div>
</div>

<?php if(Config::isLogged() && $admin != 0) { ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script>
		$(".unban").click(function() {
			var id = ($(this).attr('id'));
			$.ajax({
				url: _PAGE_URL + "action/unban",
				type: "POST",
				data: { id : id },
				
				success: function(result) {
	
					result = JSON.parse(result);
					$('<div id="message"><b><font color="' + result.color + '">' + result.message + '</font></b></div>').hide().prependTo('.page-title').fadeIn('slow');
					$("#message").delay(5000).fadeOut(400);
					if(typeof(result.success) != 'undefined') {
						var tr = $('.ban_' + id);
						tr.fadeOut(400, function(){
							tr.remove();
						});
					}
				},
			});
		});
		</script>
<?php } ?>