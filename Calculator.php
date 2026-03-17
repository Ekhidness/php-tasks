<?php
$result = null;
$error = null;

$method = $_SERVER['REQUEST_METHOD'];
$data = $method == 'POST' ? $_POST : $_GET;

if ($method === 'POST' || $method === 'GET') {
    if (isset($data['num1'], $data['num2'], $data['operation'])) {
        $num1 = floatval($data['num1']);
        $num2 = floatval($data['num2']);
        $operation = $data['operation'];

        if ($num2 == 0 and $operation == 'div') {
            $error = 'На ноль делить нельзя';
        } else {
            switch ($operation) {
                case 'add':
                    $result = $num1 + $num2;
                    break;
                case 'sub':
                    $result = $num1 - $num2;
                    break;
                case 'mul':
                    $result = $num1 * $num2;
                    break;
                case 'div':
                    $result = $num1 / $num2;
                    break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор</title>
</head>

<body>
    <form method="GET">
        <input type='number' name='num1' required>
        <input type='number' name='num2' required>
        <select name="operation">
            <option value="add">+</option>
            <option value="sub">-</option>
            <option value="mul">*</option>
            <option value="div">/</option>
        </select>
        <button type="submit">Рассчитать (GET)</button>
    </form>

    <form method=" POST">
        <input type='number' name='num1' required>
        <input type='number' name='num2' required>
        <select name="operation">
            <option value="add">+</option>
            <option value="sub">-</option>
            <option value="mul">*</option>
            <option value="div">/</option>
        </select>
        <button type="submit">Рассчитать (POST)</button>
    </form>

    <?php if ($error): ?>
        <p class="error"> <?= $error ?></p>
    <?php elseif ($result !== null): ?>
        <p class="result">Результат:<?= $result ?></p>
    <?php endif; ?>
</body>

</html>
