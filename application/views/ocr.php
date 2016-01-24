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
			<div class="col-md-6 col-md-offset-3">
				<div class="text-center">
					<h1>WhoPay</h1>
					<hr>
					<video id="video" width="640" height="480" autoplay></video>
					<button type="button" class="btn btn-default" id="snap">Snap Photo of Receipt</button>
					<canvas id="canvas" width="640" height="480"></canvas>
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
	// Put event listeners into place
	window.addEventListener("DOMContentLoaded", function() {
	// Grab elements, create settings, etc.
	var canvas = document.getElementById("canvas"),
	context = canvas.getContext("2d"),
	video = document.getElementById("video"),
	videoObj = { "video": true },
	errBack = function(error) {
		console.log("Video capture error: ", error.code); 
	};

	// Put video listeners into place
	if(navigator.getUserMedia) { // Standard
		navigator.getUserMedia(videoObj, function(stream) {
			video.src = stream;
			video.play();
		}, errBack);
	} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
		navigator.webkitGetUserMedia(videoObj, function(stream){
			video.src = window.webkitURL.createObjectURL(stream);
			video.play();
		}, errBack);
	}
	else if(navigator.mozGetUserMedia) { // Firefox-prefixed
		navigator.mozGetUserMedia(videoObj, function(stream){
			video.src = window.URL.createObjectURL(stream);
			video.play();
		}, errBack);
	}
	document.getElementById("snap").addEventListener("click", function() {
		context.drawImage(video, 0, 0, 640, 480);
	});
}, false);


</script>
</body>
</html>