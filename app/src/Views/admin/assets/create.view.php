<?php

use Entities\Category;

/** @var Category[] $categories */
/** @var array $previousData */
/** @var string|null $errorMessage */
/** @var array $errors */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>assets</title>
	<?php renderComponent('tinymce', ['selector' => '#description']) ?>
</head>
    <body>
        <h1>Create Asset</h1>
		<?php renderComponent('assets/form',
            [
                'categories' => $categories,
                'previousData' => $previousData ?? [],
                'errors' => $errors ?? [],
                'asset' => null,
                'action' => '/admin/assets/create',
                'isEdit' => false,
                'method' => 'post'
            ]) ?>
    </body>
</html>    
