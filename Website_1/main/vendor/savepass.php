<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: ../../login.php');
}
require_once '../../app/include/database.php';

$login = $_SESSION['user']['login'];
$old_password = md5($_POST['old_password']);
$password = md5($_POST['password']);
$password_confirm = md5($_POST['password_confirm']);

if ($password == $password_confirm)
{
    $check_user = mysqli_query($link, "SELECT * FROM `users` WHERE `login` = '$login'
    AND `password` = '$old_password'");
    if (mysqli_num_rows($check_user) > 0)
    {
        $sql = mysqli_query($link, "UPDATE `users` SET `password` = '$password' 
        WHERE `login` = '$login'");
        if(!$sql)
        {
            $_SESSION['message'] = 'Ошибка при смене пароля';
            header('Location: ../settings.php');
        }
        else
        {
            $_SESSION['message'] = 'Пароль успешно изменен';
            header('Location: ../settings.php');
        }
    }
    else
    {
        $_SESSION['message'] = 'Неверный пароль';
        header('Location: ../settings.php');
    }
}
else
{
    $_SESSION['message'] = 'Пароли не совпадают';
    header('Location: ../settings.php');
}
?>
