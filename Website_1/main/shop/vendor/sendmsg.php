<?php
session_start();
if (!$_SESSION['user']) header('Location: ../../../index.php');

require_once ("../../../app/include/database.php");
require_once ("../../../app/include/sec.php");
if(!userHasShop($_SESSION['user']['id'])) header('Location: ../../../index.php');
$m = $_POST['msg'];
$g = intval($_POST['s']);
$d = intval($_POST['d']);

if (!IsNullOrEmptyString($m) and !IsNullOrEmptyString($g))
{
    $sql = "SELECT * FROM users WHERE id = $g";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) == 0)
    {
        header("Location: ../admindm.php?id=". $g);
    }
    $sql = "INSERT INTO `messages` (`id`, `user_id`, `shop_id`, `content`, `time`,
        `type`) 
        VALUES (DEFAULT, $g, $d, '$m', DEFAULT, 0)";
    mysqli_query($link, $sql);
    if ($sql)
    {
        $_SESSION['message'] = 'Сообщение отправлено';
    }
}
else
{
    $_SESSION['message'] = 'Введите сообщение';
}

header("Location: ../messages.php?id=". $g);
?>