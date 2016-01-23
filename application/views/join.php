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

	<!-- Main menu -->
	<div class="container">
		<div class="row" style="margin-top: 50px;">
			<div class="col-lg-10 col-lg-offset-1">
				<div class="text-center">
					<h1>WhoPay</h1>
					<hr>
					<form method="post" action="/index.php/main/receipt">
						<div class="form-group">
							<input class="form-control" id="focusedInput" type="text" name="receiptCode" placeholder="Enter receipt code">
						</div>
						<div class="form-group">
							<input class="form-control" id="focusedInput" type="text" name="name" placeholder="Enter your name">
						</div>
						<input type="submit" class="btn btn-default" value="Join">
					</form>
					<a href="/" class="btn btn-default">Back</a>
					<hr>
				</div>
			</div>
		</div>
	</div>
	<br><br>

	<!-- Footer -->
	<div class="container">
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1 text-center">
				<span>Released under MIT License</span> | 
				<span>Built on <a href="http://getbootstrap.com/">Bootstrap</a></span> |
				<span>Made by <a href="https://github.com/sudharti">sudharti</a></span>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="../../assets/dist/js/vendor/jquery.min.js"></script>
	<script type="text/javascript" src="../../assets/dist/js/paper.min.js"></script>
	<script type="text/javascript">
		window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
	</script>
	<script type="text/javascript" src="https://apis.google.com/js/platform.js" async defer></script>
</body>
</html>