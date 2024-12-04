<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Unreal Asset Store</title>
	</head>
	<body>
		<? if(isset($_SESSION['user'])): ?>
			<h2>welcome <?= $_SESSION['user']['name'] ?></h2>
			<a href="/api/signout">sign out</a>
		<? endif?>
		<form id="sign-in-form" method="post">
			<h2>sign in</h2>
			<input type="text" name="email" placeholder="email">
			<input type="text" name="password" placeholder="password">
			<input hidden type="text" name="_method" value="POST">
			<button type="submit">sign in</button>
		</form>
		<form id="sign-up-form" method="post">
			<h2>sign up</h2>
			<input type="text" name="name" placeholder="name">
			<input type="text" name="email" placeholder="email">
			<input type="text" name="password" placeholder="password">
			<input hidden type="text" name="_method" value="POST">
			<button type="submit">sign up</button>
		</form>
		<script src="main.js"></script>
	</body>	
</html>
