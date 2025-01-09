<?php

use Entities\Category;

/**
 * @var Category[] $categories 
*/
/**
 * @var array $previousData 
*/
/**
 * @var string|null $errorMessage 
*/
/**
 * @var array $errors 
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<?php renderComponent('tinymce', ['selector' => '#description']) ?>
    <title>assets</title>
</head>
    <body>
        <h1>Create Asset</h1>
		<?php renderComponent('assets/form',
            [
                'categories' => $categories,
                'previousData' => $previousData ?? [],
                'errors' => $errors ?? [],
                'asset' => null,
                'action' => '/profile/assets/create',
                'isEdit' => false,
                'method' => 'post'
            ]) ?>
    </body>
</html>    
