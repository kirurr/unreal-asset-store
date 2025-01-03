<?php
/** @var array<string,mixed> $user */
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Unreal Asset Store</title>
	</head>
	<body>
		<? renderComponent('navbar', ['user' => $user]);?>
		<? renderComponent('main/top-assets', ['assets' => $topAssets]);?>
		<? renderComponent('main/more-assets', ['assets' => $moreAssets]);?>
		<script src="main.js"></script>
	</body>	
</html>
