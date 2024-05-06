<!-- BEGIN STYLE CUSTOMIZER -->
<div class="theme-panel hidden-xs hidden-sm">
	<div class="toggler">
	</div>
	<div class="toggler-close">
	</div>
	<div class="theme-options">
		<div class="theme-option theme-colors clearfix">
			<span>
				 THEME COLOR
			</span>
			<ul>
				<li class="color-black" data-style="default">
					<img src="<?php echo Config::$_PAGE_URL; ?>assets/img/trans.png" class="ct" name="default" style="cursor:pointer;">
				</li>
				<li class="color-blue" data-style="blue" >
					<img src="<?php echo Config::$_PAGE_URL; ?>assets/img/trans.png" class="ct" name="blue" style="cursor:pointer;">
				</li>
				<li class="color-brown" data-style="brown">
					<img src="<?php echo Config::$_PAGE_URL; ?>assets/img/trans.png" class="ct" name="brown" style="cursor:pointer;">
				</li>
				<li class="color-purple" data-style="purple">
					<img src="<?php echo Config::$_PAGE_URL; ?>assets/img/trans.png" class="ct" name="purple" style="cursor:pointer;">
				</li>
				<li class="color-grey" data-style="grey">
					<img src="<?php echo Config::$_PAGE_URL; ?>assets/img/trans.png" class="ct" name="grey" style="cursor:pointer;">
				</li>
				<li class="color-white color-light" data-style="light">
					<img src="<?php echo Config::$_PAGE_URL; ?>assets/img/trans.png" class="ct" name="light" style="cursor:pointer;">
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- END STYLE CUSTOMIZER -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
$(".ct").click(function() {
	var name = ($(this).attr('name'));
	$.ajax({
		url: _PAGE_URL + "action/changetheme",
		type: "POST",
		data: { name : name },
		success: function(result) {
			result = JSON.parse(result);
			$('<div id="message"><b><font color="' + result.color + '">' + result.message + '</font></b></div>').hide().prependTo('.page-title').fadeIn('slow');
			$("#message").delay(5000).fadeOut(400);
			
		},
	});
});
</script>