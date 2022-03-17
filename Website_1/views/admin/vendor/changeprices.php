<?php
session_start();
if (!$_SESSION['admin'])
{
    header('Location: ../../login.php');
}
require_once ("../../../app/include/database.php");
$index = !empty($_POST['index']) ? $_POST['index'] : array();
$price = !empty($_POST['price']) ? $_POST['price'] : array();
foreach($index as $indexx => $value)
{
    $sql = "UPDATE prices SET price = $price[$indexx] WHERE id = $value";
    $result = mysqli_query($link, $sql);
}
if ($result)
    $_SESSION['messag'] = "Успешно";
else $_SESSION['messag'] = "Ошибка";
header("Location: ../prices.php");
?>