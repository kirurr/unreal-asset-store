<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>assets</title>
</head>
    <body>
        <h1>Create Asset</h1>
        <form action="/admin/assets/create" method="post" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($previousData['name'] ?? '') ?>">
            <label for="info">Info</label>
            <input type="text" name="info" id="info" value="<?php echo htmlspecialchars($previousData['info'] ?? '') ?>">
            <label for="description">Description</label>
            <textarea name="description" id="description"><?php echo htmlspecialchars($previousData['description'] ?? '') ?></textarea>
            <label for="images">Images</label>
			<input type="file" name="images[]" id="images" multiple>
            <label for="price">Price</label>
            <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($previousData['price'] ?? '') ?>">
            <label for="engine_version">Engine Version</label>
            <input type="text" name="engine_version" id="engine_version" value="<?php echo htmlspecialchars($previousData['engine_version'] ?? '') ?>">
            <label for="category_id">Category ID</label>
            <select name="category_id" id="category_id">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Create</button>
        </form>
        <?php if (isset($errorMessage)) : ?>
            <p><?php echo $errorMessage ?></p>
        <?php endif; ?>
    </body>
</html>    
