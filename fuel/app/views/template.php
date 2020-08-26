<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<style>
		body { margin: 40px; }
	</style>
	<script>window._epn = {campaign: 5338733485};</script>
<script src="https://epnt.ebay.com/static/epn-smart-tools.js"></script>
</head>
<body>
	<div class="container">
		<div class="col">
			<h1><?php echo $title; ?></h1>
			<hr>

		</div>
		<div class="col">
			<?php echo $content; ?>
		</div>

		<footer>
			<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
			<p>
				<a href="https://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
				<small>Version: <?php echo e(Fuel::VERSION); ?></small>
			</p>
		</footer>
	</div>
</body>
</html>
