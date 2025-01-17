<?php
/** @var string $error */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php renderComponent('head'); ?>
    <title>Error</title>
</head>
<body class="items-center justify-center">
    <main>
        <section>
            <h1>Error</h1>
            <p>An error occurred</p>
            <p><?= $error ?? '' ?></p>
            <a href="/" class="link mt-4 block">back to site</a>
        </section>
    </main>
</body>
</html>
