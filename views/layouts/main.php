<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Учёт оборудования</title>
    <link rel="stylesheet" href="<?= app()->route->getUrl('/css/style.css') ?>">
</head>
<body>
<?php if (app()->auth::check()): ?>
    <nav>
        <a href="<?= app()->route->getUrl('/equipment') ?>">Оборудование</a>
        <a href="<?= app()->route->getUrl('/report') ?>">Отчёт</a>
        <?php if (app()->auth::user()->isAdmin()): ?>
            <a href="<?= app()->route->getUrl('/equipment/create') ?>">+ Добавить</a>
            <a href="<?= app()->route->getUrl('/signup') ?>">+ Пользователь</a>
        <?php endif; ?>
        <span class="nav-user">
        <?= htmlspecialchars(app()->auth::user()->full_name) ?> |
        <a href="<?= app()->route->getUrl('/logout') ?>">Выход</a>
    </span>
    </nav>
<?php endif; ?>
<main>
    <?= $content ?? '' ?>
</main>
</body>
</html>