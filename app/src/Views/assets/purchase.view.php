<?php

use Entities\Asset;

/**
 * @var Asset $asset
 * @var string $errorMessage
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>purchase asset</title>
</head>
<body>
		<h1>purchase asset</h1>
		<form action="/assets/<?= $asset->id ?>/purchase/" method="post">
			<button type="submit">purchase</button>
		</form>
		<p><?= $errorMessage ?? '' ?></p>
</body>
</html>
