<?php
if(!defined('AWM'))
	die('Nope.');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<h3 class="page-title">
		Map
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
					Map
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<div class="row" align="center">
	<?php
	if(isset(Config::$_url[1]) && isset(Config::$_url[2])) 
	{
		$x = (int)Config::$_url[1];
		$y = (int)Config::$_url[2];
	?>	
		<img src="<?php echo Config::$_PAGE_URL; ?>map/<?php echo $x;?>/<?php echo $y;?>">
	<?php
	}
	?>
</div>