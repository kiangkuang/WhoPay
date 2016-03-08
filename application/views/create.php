<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>WhoPay</title>
	<meta name="description" content="Creating a new receipt">
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
					<hr>
					<form action="/receipt" method="post">
						<fieldset>
							<!-- Name Field -->
							<div class="col-xs-12">
								<div class="form-group">
									<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
								</div>
							</div>

							<div id="itemlist">
								<?php 
								if (isset($displayItems)) {
									foreach ($displayItems as $item): ?>
								<div class="item">
									<div class="col-xs-8">
										<!-- Item Field -->
										<div class="form-group" id="itemlist" style="margin-top: 0px;">
											<input type="text" class="form-control itemname" name="items[]" placeholder="Item name" value="<?= $item ?>" required>
										</div>
									</div>

									<div class="col-xs-4">
										<!-- Item Field -->
										<div class="input-group form-group">
											<div class="input-group-addon">$</div>
												<input type="text" class="form-control" class="form-control itemcost" name="itemcosts[]" placeholder="Price" required>
											<a><span style="position:absolute;top:7px;right:-20px;" class="close remitem">&times;</span></a>
										</div>
									</div>
								</div>
								<?php endforeach; } else {?>
								<div class="item">
									<div class="col-xs-8">
										<!-- Item Field -->
										<div class="form-group" id="itemlist" style="margin-top: 0px;">
											<input type="text" class="form-control itemname" name="items[]" placeholder="Item name" required>
										</div>
									</div>

									<div class="col-xs-4">
										<!-- Item Field -->
										<div class="input-group form-group">
											<div class="input-group-addon">$</div>
												<input type="text" class="form-control" class="form-control itemcost" name="itemcosts[]" placeholder="Price" required>
											<a><span style="position:absolute;top:7px;right:-20px;" class="close remitem">&times;</span></a>
										</div>
									</div>
								</div>
								<?php }?>
							</div>

							<!-- Button to add Items -->
							<button type="button" class="btn btn-info btn-sm" id="additem">Add item</button>

							<!-- Tax and Service Charge -->
							<p class="help-block" style="margin-top:20px;">Check to apply Tax and/or Service Charge to the above prices.</p>

							<div class="form-inline" style="margin-bottom:10px;">
							  <label class="checkbox" style="display:inline-block !important;">
							     <input type="checkbox" name="serviceCharge"> Service Charge
							  </label>
							  <input type="text" class="form-control" name="serviceChargeValue" value="10" style="width:2em;padding:4px;text-align:center;display:inline-block !important;"> %
							</div>
							<div class="form-inline" style="margin-bottom:20px;">
							  <label class="checkbox" style="display:inline-block !important;">
							     <input type="checkbox" name="tax"> Tax
							  </label>
							  <input type="text" class="form-control" name="taxValue" value="7" style="width:2em;padding:4px;text-align:center;display:inline-block !important;"> %
							</div>

							<!-- Submit and Cancel Buttons -->
							<div class="form-group">

								<a href="/" class="btn btn-default">Cancel</a>
								<button type="submit" class="btn btn-primary" value="Submt">Submit</button>

							</div>

						</fieldset>
					</form>
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
	<script type="text/javascript" src="https://apis.google.com/js/platform.js" async defer> </script>	
	<script type="text/javascript" src="/assets/dist/js/create.js"></script>
</body>
</html>