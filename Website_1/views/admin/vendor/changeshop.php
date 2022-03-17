<?php
session_start();
if (!$_SESSION['admin']) {
    header('Location: ../../login.php');
}
require_once ("design/createnav.php");
require_once ("../../../app/include/database.php");
$index = !empty($_POST['index']) ? $_POST['index'] : array();
$name = !empty($_POST['name']) ? $_POST['name'] : array();
$owner = !empty($_POST['owner']) ? $_POST['owner'] : array();
$img = !empty($_POST['img']) ? $_POST['img'] : array();
$deals = !empty($_POST['deals']) ? $_POST['deals'] : array();
$satoshi = !empty($_POST['rub']) ? $_POST['rub'] : array();
$about = !empty($_POST['about']) ? $_POST['about'] : array();
$ind = $_POST['indx'];
$sql = "UPDATE shops SET name = '$name[$ind]', owner = '$owner[$ind]', img = '$img[$ind]', deals = $deals[$ind], rub = $satoshi[$ind], about = '$about[$ind]'
 WHERE shopid = $index[$ind]";
$result = mysqli_query($link, $sql);
if ($result)
    $_SESSION['messag'] = "Успешно";
else
    $_SESSION['messag'] = mysqli_error($link);
header("Location: ../shopmanage.php");
?>