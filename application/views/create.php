<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>WhoPay</title>
</head>
<body>

	<form action="/main/createManual" method="post">
		Name:<br>
		<input type="text" name="name" placeholder="name pls"><br>
		Items:<br>
		<input type="text" name="items[]" placeholder="item name???"><input type="text" name="itemprices[]" placeholder="price pls"><br>
		<input type="text" name="items[]" placeholder="item name???"><input type="text" name="itemprices[]" placeholder="price pls"><br>
		<input type="text" name="items[]" placeholder="item name???"><input type="text" name="itemprices[]" placeholder="price pls"><br>
		<input type="text" name="items[]" placeholder="item name???"><input type="text" name="itemprices[]" placeholder="price pls"><br>

		<br>
		<input type="submit" value="Submit">
	</form>
</body>
</html>