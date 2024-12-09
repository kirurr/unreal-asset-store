<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Unreal Asset Store</title>
	</head>
	<body>
		<h1>edit category</h1>
		<form action="/admin/categories/<?= $category->id ?>" method="post">
			<input type="hidden" name="_method" value="put">
			<label for="name">name</label>
			<input type="text" name="name" value="<?= $category->name ?>">
			<label for="description">description</label>
			<textarea name="description"><?= $category->description ?></textarea>
			<button type="submit">save</button>
		</form>
		<a href="/admin/categories">back</a>
		<form action="/admin/categories/<?= $category->id ?>/" method="post">
			<input type="hidden" name="_method" value="delete">
			<button type="submit">delete</button>
		</form>
	</body>
