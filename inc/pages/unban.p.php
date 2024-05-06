<?php
if(!defined('AWM'))
	die('Nope.');
if(!Config::isLogged() && !isset(Config::$_url[1])) header('Location: ' . $_PAGE_URL . 'login');


$q = Config::$g_con->prepare('SELECT * FROM `unbanreq` ORDER BY `ID` DESC ' . Config::init()->_pagLimit());
$q->execute();



?>

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Unban Request
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
					Unban Request
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
            
     
                <!-- /.row -->
                      <a href="<?php echo Config::$_PAGE_URL; ?>ureq/"><button type="button" class="btn btn-danger">New Unban Request</button><br></a>
<?php                   
echo ' <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="data">
                                        <th class="data">ID</th>
                                        <th class="data">Username</th>
                                        <th class="data">Date</th>
                                        <th class="data">Status</th>
										<th class="data">Details</th>';
                                    echo '</tr>
                                </thead>';
					echo 
								"<tbody>";
								
                                    while($row = $q->fetch(PDO::FETCH_OBJ)) {
									echo"<tr class='ban_{$row->ID}'>
                                        <td>{$row->ID}</td>
                                        <td>{$row->pName}</td>
                                        <td>{$row->Date}</td>";
										if($row->Closed == 0 && $row->Status == 0) { echo '<td><div id="clos" style="background-color: #C7A444"><b><font color="white">Pending...</font></b></div></td>';
										} else echo "<td>".($row->Closed ? '<div id="clos"><b><font color="white">Closed & '.($row->Status ? "Accepted" : "Rejected").'</font></b></div>' : '<div id="opn"><b><font color="white">Opened & '.($row->Status ? "Accepted" : "Rejected").'</font></b></div>')."</td>";
										echo "<td><a href='".Config::$_PAGE_URL."unbanpg/".$row->ID."'><i class='fa fa-search'></i> Click Here</a></td>
									</tr>";}
								echo"</tbody>
                            </table>";
							echo "</div>";
?>
                            </div>
							
                        </div>
                

         

			




	



