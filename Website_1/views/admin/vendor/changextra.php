<?php

session_start();
if (!$_SESSION['admin']) header('Location: ../../login.php');

require_once ("../../../app/include/database.php");
$index = !empty($_POST['index']) ? $_POST['index'] : array();
$value = !empty($_POST['value']) ? $_POST['value'] : array();
foreach($index as $indexx => $ind)
{
    $sql = "UPDATE extra SET value = $value[$indexx] WHERE id = $ind";
    $result = mysqli_query($link, $sql);
}
if ($result)
    $_SESSION['messag'] = "Успешно";
else $_SESSION['messag'] = "Ошибка";
header("Location: ../index.php");
?>