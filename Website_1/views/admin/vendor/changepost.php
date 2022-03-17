<?php
session_start();
if (!$_SESSION['admin']) {
    header('Location: ../../login.php');
}
require_once ("design/createnav.php");
require_once ("../../../app/include/database.php");
$index = !empty($_POST['index']) ? $_POST['index'] : array();
$title= !empty($_POST['title']) ? $_POST['title'] : array();
$price = !empty($_POST['price']) ? $_POST['price'] : array();
$remain = !empty($_POST['remain']) ? $_POST['remain'] : array();
$content = !empty($_POST['content']) ? $_POST['content'] : array();
$description = !empty($_POST['description']) ? $_POST['description'] : array();
$category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : array();
$ind = $_POST['indx'];
$indd = $_POST['indd'];
$sql = "UPDATE posts SET title = '$title[$ind]', price = $price[$ind], remain = $remain[$ind], content = '$content[$ind]', description = '$description[$ind]', category_id = $category_id[$ind]
 WHERE id = $index[$ind]";
if($indd == 1) $sql = "DELETE FROM posts WHERE id = $index[$ind]";
$result = mysqli_query($link, $sql);
if ($result)
    $_SESSION['messag'] = "Успешно";
else
    $_SESSION['messag'] = mysqli_error($link);
header("Location: ../postmanage.php");
?>