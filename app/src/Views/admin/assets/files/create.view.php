<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create file</title>
</head>
	<body>
        <h1>create file</h1>
        <form action="/admin/assets/<?php echo $asset_id ?>/files/create" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="post">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($previousData['name'] ?? '') ?>">
            <label for="info">version</label>
            <input type="text" name="version" id="version" value="<?php echo htmlspecialchars($previousData['info'] ?? '') ?>">
            <label for="description">Description</label>
            <textarea name="description" id="description"><?php echo htmlspecialchars($previousData['description'] ?? '') ?></textarea>
            <label for="images">File</label>
			<!--TODO: add filetype restriction -->
            <input type="file" name="file" id="file">
            <button type="submit">Create</button>
        </form>
        <?if (isset($errorMessage)) : ?>
            <p><?php echo $errorMessage ?></p>
        <?endif; ?>
	</body>
</html>
