<?php
session_start();
if (!$_SESSION['admin']) {
    header('Location: ../../login.php');
}
require_once ("design/createnav.php");
require_once ("../../../app/include/database.php");
$index = !empty($_POST['index']) ? $_POST['index'] : array();
$user_id = !empty($_POST['user_id']) ? $_POST['user_id'] : array();
$shop_name = !empty($_POST['shop_name']) ? $_POST['shop_name'] : array();
$shop_desc = !empty($_POST['shop_desc']) ? $_POST['shop_desc'] : array();
$shop_img = !empty($_POST['shop_img']) ? $_POST['shop_img'] : array();
$shop_about = !empty($_POST['shop_about']) ? $_POST['shop_about'] : array();
$ind = $_POST['indx'];
$type = $_POST['typee'];
if ($type == 1)
{
    $sql = "SELECT * FROM extra WHERE identifier = 'adminshop'";
    $result = mysqli_query($link, $sql);
    $result = mysqli_fetch_assoc($result);
    $adminshopid = $result['value'];
    $sql = "DELETE FROM shopaccept WHERE user_id = $user_id[$ind]";
    $result = mysqli_query($link, $sql);
    $sql = "INSERT INTO messages VALUES (DEFAULT, $user_id[$ind], $adminshopid, 'Ваша заявка была принята. Для управления магазином перейдите в профиль',
    DEFAULT, 0)";
    $result = mysqli_query($link, $sql);
    $sql = "INSERT INTO shops VALUES (DEFAULT, '$shop_name[$ind]', $user_id[$ind], '', '$shop_img[$ind]', 0, 0, '$shop_about[$ind]')";
    $result = mysqli_query($link, $sql);
    $abspath =realpath(dirname(__DIR__, 3));
    rename($abspath ."\\main\\shop\\verification\\img\\$shop_img[$ind]",$abspath .
        "\\main\\shop\\img\\$shop_img[$ind]");
    if ($result)
        $_SESSION['messag'] = "Успешно принято";
    else
        $_SESSION['messag'] = mysqli_error($link);
}
else if ($type == 2)
{
    $sql = "SELECT * FROM extra WHERE identifier = 'adminshop'";
    $result = mysqli_query($link, $sql);
    $result = mysqli_fetch_assoc($result);
    $adminshopid = $result['value'];
    $sql = "DELETE FROM shopaccept WHERE user_id = $user_id[$ind]";
    $result = mysqli_query($link, $sql);
    $sql = "INSERT INTO messages VALUES (DEFAULT, $user_id[$ind], $adminshopid, 'Ваша заявка была отклонена', DEFAULT, 0)";
    $result = mysqli_query($link, $sql);
    $abspath =realpath(dirname(__DIR__, 3));
    unlink($abspath ."\\main\\shop\\verification\\img\\$shop_img[$ind]");
    if ($result)
        $_SESSION['messag'] = "Успешно отклонено";
    else
        $_SESSION['messag'] = mysqli_error($link);
}
header("Location: ../shopvalidation.php");
?>