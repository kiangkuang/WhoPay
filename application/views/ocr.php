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
	<!-- <div class="container">
		<div class="row" style="margin-top: 50px;">
			<div class="col-md-6 col-md-offset-3">
				<div class="text-center">
					<h1>WhoPay</h1>
					<hr>
					<video id="video" width="555" height="480" autoplay></video>
					<button type="button" class="btn btn-default" id="snap">Snap Photo of Receipt</button>
					<a href="/" class="btn btn-default">Cancel</a>
					<canvas id="canvas" width="640" height="480"></canvas>
					<hr>
				</div>
			</div>
		</div>
	</div> -->

	<div id="container">

	  <h1><a href="../../index.html" title="simpl.info home page">simpl.info</a> MediaStreamTrack.getSources</h1>

	  <div class="select">
	    <label for="audioSource">Audio source: </label><select id="audioSource"></select>
	  </div>

	  <div class="select">
	    <label for="videoSource">Video source: </label><select id="videoSource"></select>
	  </div>

	  <video muted autoplay></video>

	  <script src="js/main.js"></script>

	  <p>This demo requires Chrome 30 or later.</p>

	  <p>For more information, see <a href="http://www.html5rocks.com/en/tutorials/getusermedia/intro/" title="Media capture article by Eric Bidelman on HTML5 Rocks">Capturing Audio &amp; Video in HTML5</a> on HTML5 Rocks.</p>

	<a href="https://github.com/samdutton/simpl/blob/master/getusermedia/sources/js/main.js" title="View source for this page on GitHub" id="viewSource">View source on GitHub</a>

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
	<script> // Script for capturing video as an image and draw onto canvas
	// Old method: 

	// Put event listeners into place
	// var image = new Image();

	// window.addEventListener("DOMContentLoaded", function() {
	// 	// Grab elements, create settings, etc.
	// 	var canvas = document.getElementById("canvas"),
	// 	context = canvas.getContext("2d"),
	// 	video = document.getElementById("video"),
	// 	videoObj = { "video": true },
	// 	errBack = function(error) {
	// 		console.log("Video capture error: ", error.code); 
	// 	};

	// 	// Put video listeners into place
	// 	if(navigator.getUserMedia) { // Standard
	// 		navigator.getUserMedia(videoObj, function(stream) {
	// 			video.src = stream;
	// 			video.play();
	// 		}, errBack);
	// 	} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
	// 		navigator.webkitGetUserMedia(videoObj, function(stream){
	// 			video.src = window.webkitURL.createObjectURL(stream);
	// 			video.play();
	// 		}, errBack);
	// 	}
	// 	else if(navigator.mozGetUserMedia) { // Firefox-prefixed
	// 		navigator.mozGetUserMedia(videoObj, function(stream){
	// 			video.src = window.URL.createObjectURL(stream);
	// 			video.play();
	// 		}, errBack);
	// 	}

	// 	document.getElementById("snap").addEventListener("click", function() {
	// 		context.drawImage(video, 0, 0, 640, 480);
	// 		image.src = canvas.toDataURL("image/png");
	// 	});
	// }, false);


	// New method:
	var videoElement = document.querySelector('video');
var audioSelect = document.querySelector('select#audioSource');
var videoSelect = document.querySelector('select#videoSource');

navigator.getUserMedia = navigator.getUserMedia ||
  navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

function gotSources(sourceInfos) {
  for (var i = 0; i !== sourceInfos.length; ++i) {
    var sourceInfo = sourceInfos[i];
    var option = document.createElement('option');
    option.value = sourceInfo.id;
    if (sourceInfo.kind === 'audio') {
      option.text = sourceInfo.label || 'microphone ' +
        (audioSelect.length + 1);
      audioSelect.appendChild(option);
    } else if (sourceInfo.kind === 'video') {
      option.text = sourceInfo.label || 'camera ' + (videoSelect.length + 1);
      videoSelect.appendChild(option);
    } else {
      console.log('Some other kind of source: ', sourceInfo);
    }
  }
}

if (typeof MediaStreamTrack === 'undefined' ||
    typeof MediaStreamTrack.getSources === 'undefined') {
  alert('This browser does not support MediaStreamTrack.\n\nTry Chrome.');
} else {
  MediaStreamTrack.getSources(gotSources);
}

function successCallback(stream) {
  window.stream = stream; // make stream available to console
  videoElement.src = window.URL.createObjectURL(stream);
  videoElement.play();
}

function errorCallback(error) {
  console.log('navigator.getUserMedia error: ', error);
}

function start() {
  if (window.stream) {
    videoElement.src = null;
    window.stream.stop();
  }
  var audioSource = audioSelect.value;
  var videoSource = videoSelect.value;
  var constraints = {
    audio: {
      optional: [{
        sourceId: audioSource
      }]
    },
    video: {
      optional: [{
        sourceId: videoSource
      }]
    }
  };
  navigator.getUserMedia(constraints, successCallback, errorCallback);
}

audioSelect.onchange = start;
videoSelect.onchange = start;

start();


</script>


</body>
</html>