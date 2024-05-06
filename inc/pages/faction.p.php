<?php
if(!defined('AWM'))
	die('Nope.');
if(!isset(Config::$_url[1]) || !is_numeric(Config::$_url[1])) header('Location: ' . Config::$_PAGE_URL . 'factions');
$q = Config::$g_con->prepare('SELECT a.Leader,a.PlayerName,,a.ID,g.* FROM FactionInfo g LEFT JOIN PlayerInfo a ON ( a.FactionName = g.ID ) WHERE g.ID = ? ORDER BY a.ID DESC');
$q->execute(array((int)Config::$_url[1]));

if(!$q->rowCount()) header('Location: ' . Config::$_PAGE_URL . 'factions');

if(Config::isLogged()) {
	$pq = Config::$g_con->prepare('SELECT SQLID, RankName, Leader FROM PlayerInfo WHERE FactionID = ?');
	$pq->execute(array((int)Config::$_url[1]));

	$data = $pq->fetch(PDO::FETCH_OBJ);
	
	$user = $_SESSION['awm_user'];
	
}


echo '</table>';


?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		<?php echo Config::$factions[Config::$_url[1]]['name']; ?>
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
				<a href="<?php echo Config::$_PAGE_URL; ?>factions">
					Factions
				</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">
					<?php echo Config::$factions[Config::$_url[1]]['name']; ?>
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
				
				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Tier</th>
									<th>Rank</th>
									<th>Joined at</th>
									<?php if(Config::isLogged()) {
									$leader = Config::getPlayerData($_SESSION['awm_user'],'Leader');
									if($leader == (int)Config::$_url[1]) echo '<th>Actions</th>';	
									}?>
								</tr>
							</thead>
							<?php echo 
								'
								<tbody>';
                                    $i = 0;
									$rank1 = 0;

									while($row = $q->fetch(PDO::FETCH_OBJ)) {
										$rank1 ++;

										$rank = ($row->RankName != 0 ? 'RankName' . $row->RankName : 'groupRankName1');
										echo 
										"<tr class='player_".$row->SQLID."'>
											<td>$rank1</td>
											<td><a href=".Config::$_PAGE_URL.'profile/'.$row->SQLID.">".$row->playerName."</a></td>	
											<td>".$row->Tier."</td>
											<td class='rank_".$row->SQLID."'>" . $row->$rank . "</td>
											" . ($leader == (int)Config::$_url[1] ? '
												<td align="center">
													<img src="'.Config::$_PAGE_URL.'assets/img/up.png" id="'.$row->SQLID.'" class="rank_up" style="cursor:pointer;"/>
													<img src="'.Config::$_PAGE_URL.'assets/img/down.png" id="'.$row->SQLID.'" class="rank_down" style="cursor:pointer;"/>
													<img src="'.Config::$_PAGE_URL.'assets/img/remove.png" id="'.$row->SQLID.'" class="remove" style="cursor:pointer;"/>
												</td>
											' : '') . "
										</tr>";
										$i = 1;
									}?>
								</tbody>
                            </table>
						</div>
				</div>
                <!-- /.row -->

                

   
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<?php if($leader == (int)Config::$_url[1]) { ?>
	<script>
	$(".rank_up, .rank_down, .remove").click(function() {
		var action = $(this).attr('class');
		var id = ($(this).attr('id'));
		var faction = <?php echo Config::$_url[1]; ?>;
		$.ajax({
			url: _PAGE_URL + "action/" + action,
			type: "POST",
			data: { id : id , faction : faction},
			success: function(result) {
				result = JSON.parse(result);
				$('<div id="message"><b><font color="' + result.color + '">' + result.message + '</font></b></div>').hide().prependTo('.page-title').fadeIn('slow');
				$("#message").delay(5000).fadeOut(400);
				if(typeof(result.rank) != 'undefined')
					$('.rank_' + id).html(result.rank);
				if(typeof(result.remove) != 'undefined') {
					var tr = $('.player_' + id);
					tr.fadeOut(400, function(){
			            tr.remove();
			        });
				}
			},
		});
	});
	</script>
	<div class="legend" align="center">
		<img src="<?php echo Config::$_PAGE_URL; ?>assets/img/up.png"/> - rank up<br>
		<img src="<?php echo Config::$_PAGE_URL; ?>assets/img/down.png"/> - rank down<br>
		<img src="<?php echo Config::$_PAGE_URL; ?>assets/img/remove.png"/> - remove from faction<br>
	</div>
	
<?php } ?>