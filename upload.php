<?php
$uploadDir = 'uploads/';
$messages = [];
$errors = [];

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['userfile'])) {
    $file = $_FILES['userfile'];


    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Ошибка загрузки: код " . $file['error'];
    } else {

        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            $errors[] = "Файл слишком большой (макс. 2MB)!";
        } else {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt', 'doc', 'docx'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $errors[] = "Недопустимый формат! Разрешены: " . implode(', ', $allowed);
            } else {
                $newName = uniqid('file_', true) . '.' . $ext;
                $destination = $uploadDir . $newName;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $messages[] = "Файл загружен: " . htmlspecialchars($file['name']);
                } else {
                    $errors[] = "Не удалось сохранить файл!";
                }
            }
        }
    }
}

$uploadedFiles = [];
if (is_dir($uploadDir)) {
    $uploadedFiles = array_filter(scandir($uploadDir), fn($f) => !in_array($f, ['.', '..']));
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Загрузка файлов</title>
    <style>
        body {
            font-family: Arial;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        .error {
            color: red;
            background: #ffe0e0;
            padding: 10px;
            margin: 10px 0;
        }

        .success {
            color: green;
            background: #e0ffe0;
            padding: 10px;
            margin: 10px 0;
        }

        form {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
        }

        input,
        button {
            margin: 5px 0;
            padding: 8px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        a {
            color: #0066cc;
        }

        .file-info {
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <h2>Загрузка файлов</h2>

    <?php foreach ($messages as $msg): ?>
        <div class="success"><?= $msg ?></div>
    <?php endforeach; ?>

    <?php foreach ($errors as $err): ?>
        <div class="error"><?= htmlspecialchars($err) ?></div>
    <?php endforeach; ?>
    <form method="POST" enctype="multipart/form-data">
        <p>Разрешённые форматы: jpg, jpeg, png, gif, pdf, txt, doc, docx</p>
        <p>Макс. размер 2MB</p>
        <input type="file" name="userfile" required>
        <button type="submit">Загрузить</button>
    </form>

    <h3>Загруженные файлы (<?= count($uploadedFiles) ?>)</h3>
    <?php if (empty($uploadedFiles)): ?>
        <p>Нет загруженных файлов</p>
    <?php else: ?>
        <ul>
            <?php foreach ($uploadedFiles as $f): ?>
                <li>
                    <a href="<?= $uploadDir . urlencode($f) ?>" target="_blank">
                        <?= htmlspecialchars($f) ?>
                    </a>
                    <span class="file-info">
                        (<?= round(filesize($uploadDir . $f) / 1024, 1) ?> KB)
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</body>

</html>
