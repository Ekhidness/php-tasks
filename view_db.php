<?php
$filename = 'phpTaskDB.php';
$content = null;
$error = null;

if (file_exists($filename)) {
    $content = file_get_contents($filename);
} else {
    $error = "Файл не найден!";
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Просмотр БД</title>
</head>

<body>
    <h2>Содержимое <?= htmlspecialchars($filename) ?></h2>

    <?php if ($error): ?>
        <p>Ошибка<?= htmlspecialchars($error) ?></p>
    <?php else: ?>
        <pre><?= highlight_string($content, true) ?></pre>
    <?php endif; ?>
</body>

</html>
