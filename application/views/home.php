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
	<link rel="shortcut icon" href="/assets/img/favicon1.ico" type="image/x-icon">
</head>

<body>

	<!-- Main menu -->
	<div class="container">
		<div class="row" style="margin-top: 50px;">
			<div class="col-md-6 col-md-offset-3">
				<div class="text-center">
					<h1>WhoPay</h1>
					<hr>
					<?php if (isset($error)): ?>
						<p style="color: red;"><?= $error ?></p>
					<?php endif ?>
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#userChoice">New receipt</button>
					<a href="index.php/main/join" class="btn btn-default">Join</a>
					<hr>
				</div>
			</div>
		</div>
	</div>
	<br><br>

	<!-- Modal -->
	<div class="modal fade" id="userChoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-center" id="myModalLabel">Setting Up</h4>
				</div>
				<div class="modal-body text-center">
					<div class="fileUpload btn btn-default">
						<span>Photo of receipt</span>
						<form id="form" role="form" method="post" enctype="multipart/form-data" action="/index.php/main/ocr">
							<input type="file" class="upload" id="inputFile" name="file" />
						</div>
					</form>
					<a href="index.php/main/create" class="btn btn-default">Manual entry</a>
					<br>
					<img src="/assets/img/loading.gif" style="height:40px;" class="hidden" id="loading">
				</div>
				<div class="modal-footer" id="modalCloseButton">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

	<script>
		document.getElementById("inputFile").onchange = function() {
			document.getElementById("form").submit();
			document.getElementById("inputFile").value = null;
			$('#loading').removeClass('hidden');
		}
	</script>
</body>
</html>