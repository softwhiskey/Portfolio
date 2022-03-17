<?php
session_start();

if ($_SESSION['admin']) {
    header('Location: views/admin/index.php');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<!-- Форма авторизации -->

    <form action="vendor/adminsign.php" method="POST">
        <h2 style="padding: 25px 0">Авторизация</h2>
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите свой пароль">
        <label>Хэш</label>
        <input type="password" name="hash" placeholder="Hash">
        <button type="submit">Войти</button>
    </form>

</body>
</html>
