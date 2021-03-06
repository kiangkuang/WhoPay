<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>WhoPay</title>
	<meta name="description" content="View Split Receipt">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="http://<?= $ogImg ?>">
    <meta property="og:image:secure_url" content="https://<?= $ogImg ?>">
	<link rel="stylesheet" href="/assets/dist/css/paper.min.css">
	<link rel="stylesheet" href="/assets/assets/css/style.css">
	<link rel="shortcut icon" href="/assets/img/favicon1.ico" type="image/x-icon">
</head>

<body>

	<div class="container">
		<div class="row" style="margin-top: 50px;">
			<div class="col-md-6 col-md-offset-3">
				<div class="text-center">
					<h1><a href="/" style="text-decoration:none; color:black;">WhoPay</a></h1>
					<label>Share this receipt!</label><br>
					<div class="col-md-6 col-md-offset-3">
						<input class="form-control" type="text" value="<?= $url ?>" readonly>
					</div>
					<div class="col-md-12" style="margin-bottom:20px;">
						<?php if ($isMobile): ?>
							<a href="whatsapp://send?text=<?= $url ?>" data-action="share/whatsapp/share">Share via WhatsApp</a>
						<?php endif; ?>
					</div>
					<ul class="nav nav-tabs">
						<li class="active"><a href="#billbyname" data-toggle="tab" aria-expanded="true">Split bill by names</a></li>
						<li class=""><a href="#billbyitem" data-toggle="tab" aria-expanded="false">Split bill by items</a></li>
					</ul>

					<!-- Split bill by name -->
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane fade active in" id="billbyname">
							<div class="something">
			
								<!--$user[0] = name, $user[1] = total, $user[2] and onwards = array of items -->
								<?php 
								$count = 1;
								foreach ($userTable as $user): ?>
								<div class="panel-group">
									<div class="panel panel-default">
										<button class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#collapse<?= $count ?>" style="width:100%; border:none;">
											<h4 class="panel-title" >
												<a class="accordion-toggle"><span class="pull-left"><?= $user[0]?></span>&nbsp;<span class="pull-right">$<?= number_format(round($user[1], 2, PHP_ROUND_HALF_UP), 2, '.', '') ?></span></a>
											</h4>
										</button>
										<div id="collapse<?= $count++ ?>" class="panel-collapse collapse">
											<?php
											$totalItems = count($user); 
											for ($i = 2; $i < $totalItems; $i++): ?>
											<div class="panel-body"><span class="pull-left"><?= $user[$i][0] ?></span>&nbsp;<span class="pull-right">$<?= number_format(round($user[$i][1], 2, PHP_ROUND_HALF_UP), 2, '.', '') ?></span></div>
										<?php endfor; ?> 
									</div>
								</div>
							</div>
						<?php endforeach; ?> 
					</div>
				</div>

				<!-- Split bill by item -->
				<div class="tab-pane fade" id="billbyitem">
					<div class="something">
						<!--$user[0] = name, $user[1] = total, $user[2] and onwards = array of items -->
						<?php 
						foreach ($itemTable as $item): ?>
						<div class="panel-group">
							<div class="panel panel-default">
								<button class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#collapse<?= $count ?>" style="width:100%; border:none;">
									<h4 class="panel-title">
										<a class="accordion-toggle"><span class="pull-left"><?= $item[0] ?></span>&nbsp;<span class="pull-right">$<?= number_format(round($item[1], 2, PHP_ROUND_HALF_UP), 2, '.', '') ?></a>
									</h4>
								</button>
								<div id="collapse<?= $count++ ?>" class="panel-collapse collapse">
									<?php
									$totalUsers = count($item); 
									for ($i = 2; $i < $totalUsers; $i++): ?>
									<div class="panel-body"><span class="pull-left"><?= $item[$i][1] ?></span>&nbsp;<span class="pull-right">$<?= number_format(round($item[$i][2], 2, PHP_ROUND_HALF_UP), 2, '.', '') ?></div>
								<?php endfor; ?> 
							</div>
						</div>
					</div>
				<?php endforeach; ?> 
			</div>
		</div>
	</div>

	<hr>
</div>
</div>
</div>
</div>

<!-- Footer -->
	<div class="container">
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1 text-center"> 
				<span>Built on <a href="http://getbootstrap.com/">Bootstrap</a></span> |
				<span>Github: <a href="https://github.com/kiangkuang/WhoPay">WhoPay</a></span>
			</div>
		</div>
	</div>

<script type="text/javascript" src="/assets/dist/js/vendor/jquery.min.js"></script>
<script type="text/javascript" src="/assets/dist/js/paper.min.js"></script>
<script type="text/javascript">
	window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
</script>
<script type="text/javascript" src="https://apis.google.com/js/platform.js" async defer></script>
</body>
</html>