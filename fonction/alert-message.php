<?php if(!empty($_SESSION['notification'])):?>
	<div class="alert alert-<?php echo $_SESSION['notification']['type'];?>">
		<button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<p class="text-center" style="font-size: 15px; font-weight: bold;">
			<?php echo $_SESSION['notification']['message'];?>
		</p>
	</div>
<?php endif; unset($_SESSION['notification']);?>