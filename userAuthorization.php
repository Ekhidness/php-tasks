<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: authSuccess.php');
    exit;
}
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Заполните все поля!';
    } else {
        $users = require 'phpTaskDB.php';
        $isAuthorized = false;
        foreach ($users as $user) {
            if ($user['login'] === $username && $user['password'] === $password) {
                $_SESSION['user'] = $username;
                setcookie('auth_user', $username, time() + 7 * 24 * 60 * 60, '/');
                $isAuthorized = true;
                break;
            }
        }

        if ($isAuthorized) {
            header('Location: authSuccess.php');
            exit;
        } else {
            $error = 'Неверный логин или пароль!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>

<body>
    <h2>Авторизация</h2>

    <?php if ($error): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Логин" required><br><br>
        <input type="password" name="password" placeholder="Пароль" required><br><br>
        <button type="submit">Войти</button>
    </form>
</body>

</html>
