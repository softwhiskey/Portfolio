<?php
session_start();
if (!$_SESSION['admin']) {
    header('Location: ../../../login.php');
}
require_once ("design/createnav.php");
require_once ("../../../app/include/database.php");
$index = !empty($_POST['index']) ? $_POST['index'] : array();
$satoshi = !empty($_POST['rub']) ? $_POST['rub'] : array();
$login = !empty($_POST['login']) ? $_POST['login'] : array();
$full_name = !empty($_POST['full_name']) ? $_POST['full_name'] : array();
$banned = !empty($_POST['banned']) ? $_POST['banned'] : array();
$ind = $_POST['indx'];
$sql = "UPDATE users SET rub = $satoshi[$ind], login = '$login[$ind]', full_name = '$full_name[$ind]', banned = $banned[$ind] 
WHERE id = $index[$ind]";
$result = mysqli_query($link, $sql);
if ($result)
    $_SESSION['messag'] = "Успешно";
else
    $_SESSION['messag'] = mysqli_error($link);
header("Location: ../usersmanage.php");
?>