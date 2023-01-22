<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/custom.css">
    <title><?= $HTML_PAGE_NAME ?? 'Donde' ?></title>
</head>
<body <?= isset($HTML_PAGE_NAME) ? "class='$HTML_PAGE_NAME'" : '' ?>>
<?php require(__DIR__ . DIRECTORY_SEPARATOR . 'navbar.html.php') ?>
<main class="col-12"><?= $HTML_MAIN ?? null ?></main>
<?php require(__DIR__ . DIRECTORY_SEPARATOR . 'footer.html.php') ?>
</body>
</html>
