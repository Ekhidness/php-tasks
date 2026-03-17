<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: userAuthorization.php');
    exit;
}
?>
<h1>Привет, <?= htmlspecialchars($_SESSION['user']) ?>!</h1>
<h3>Ты успешно авторизован!</h3>
