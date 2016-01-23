<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>WhoPay</title>
	<meta name="description" content="Creating a new Bill">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/assets/dist/css/paper.min.css">
  <link rel="stylesheet" href="/assets/assets/css/style.css">
</head>
<body>
	<div class="container">
		<div class="row" style="margin-top: 50px;">
			<div class="col-md-6 col-md-offset-3">
				<form action="/main/receipt" method="post">
					<div class ="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
					</div>
					<div class="form-group">
						<label>Items:</label>
						<input type="text" class="form-control" id="itemname" name="items[]" placeholder="Item name">
						<input type="text" class="form-control" id="itemcost" name="itemcosts[]" placeholder="Price of Item"><br>
						<button type="button" class="btn btn-default btn-sm" id="additem">Add item</button>
					</div>
					<input type="submit" class="btn btn-default" value="Submit">
				</form>
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