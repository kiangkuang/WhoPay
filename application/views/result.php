<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>WhoPay</title>
	<meta name="description" content="A Simple, Elegant &amp; Flat Bootstrap Theme">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/assets/dist/css/paper.min.css">
	<link rel="stylesheet" href="/assets/assets/css/style.css">
</head>

<body>
	<div class="container">
	  <h2>Bill (By Name)</h2>
	  <!--$user[0] = name, $user[1] = total, $user[2] and onwards = array of items -->
	  <?php 
	  $count = 1;
	  foreach ($userTable as $user): ?>
	  <div class="panel-group">
	    <div class="panel panel-default">
	      <div class="panel-heading">
	        <h4 class="panel-title">
	          <a data-toggle="collapse" href="#collapse<?= $count ?>"><?php echo ($user[0]." | $".number_format(round($user[1], 2, PHP_ROUND_HALF_UP), 2, '.', '')) ?></a>
	        </h4>
	      </div>
	      <div id="collapse<?= $count++ ?>" class="panel-collapse collapse">
	      	<?php
	      	$totalItems = count($user); 
	  		for ($i = 2; $i < $totalItems; $i++): ?>
	        <div class="panel-body"><?php echo ($user[$i][0]." | $".number_format(round($user[$i][1], 2, PHP_ROUND_HALF_UP), 2, '.', '')) ?></div>
	        <?php endfor; ?> 
	      </div>
	    </div>
	  </div>
		<?php endforeach; ?> 
	</div>

	<div class="container">
	  <h2>Bill (By Item)</h2>
	  <!--$user[0] = name, $user[1] = total, $user[2] and onwards = array of items -->
	  <?php 
	  foreach ($itemTable as $item): ?>
	  <div class="panel-group">
	    <div class="panel panel-default">
	      <div class="panel-heading">
	        <h4 class="panel-title">
	          <a data-toggle="collapse" href="#collapse<?= $count ?>"><?php echo ($item[0]." | $".number_format(round($item[1], 2, PHP_ROUND_HALF_UP), 2, '.', '')) ?></a>
	        </h4>
	      </div>
	      <div id="collapse<?= $count++ ?>" class="panel-collapse collapse">
	      	<?php
	      	$totalUsers = count($item); 
	  		for ($i = 2; $i < $totalUsers; $i++): ?>
	        <div class="panel-body"><?php echo ($item[$i][1]." | $".number_format(round($item[$i][2], 2, PHP_ROUND_HALF_UP), 2, '.', '')) ?></div>
	        <?php endfor; ?> 
	      </div>
	    </div>
	  </div>
		<?php endforeach; ?> 
	</div>


	<script type="text/javascript" src="/assets/dist/js/vendor/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/dist/js/paper.min.js"></script>
	<script type="text/javascript">
		window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
	</script>
	<script type="text/javascript" src="https://apis.google.com/js/platform.js" async defer></script>
</body>
</html>