<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Unreal Asset Store</title>
	</head>
	<body>
		<? if($user): ?>
			<h2>welcome <?= $user['name'] ?? '' ?></h2>
			<a href="/signout">sign out</a>
		<? else:?>
			<a href="/signin">sign in</a>
			<a href="/signup">sign up</a>
		<? endif ?>
		<script src="main.js"></script>
	</body>	
</html>
