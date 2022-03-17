<?php
session_start();
if (!$_SESSION['user'])
{
    header('Location: ../login.php');
}
require_once ('../../app/include/database.php');
require_once ('../../app/include/api.php');
require_once ('../../app/include/sec.php');
$postid = intval(htmlspecialchars(mysqli_real_escape_string($link, $_POST['goodid'])));
$shopid = intval(htmlspecialchars(mysqli_real_escape_string($link, $_POST['shopid'])));
//$postid = intval($postid);
//$shopid = intval($shopid);
if (!IsNullOrEmptyString($postid) and !IsNullOrEmptyString($shopid)) 
{
    $sql = "SELECT * FROM posts WHERE id = $postid";
    $result = mysqli_query($link, $sql);
    $sql = "SELECT * FROM shops WHERE shopid = $shopid";
    $result1 = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) != 0 and mysqli_num_rows($result1) != 0)
    {
        $sql = "SELECT * FROM shoposts WHERE shopid = $shopid and postid = $postid";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) > 0)
        {
            $userid = $_SESSION['user']['id'];
            $sql = "SELECT * FROM favourite WHERE post_id = $postid AND user_id = $userid AND shop_id = $shopid";
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) == 0)
            {
                $sql = "INSERT INTO favourite VALUES (DEFAULT, $userid, $postid, $shopid, DEFAULT)";
                $result = mysqli_query($link, $sql);
                $_SESSION['message'] = "Вы добавили товар в избранное";
            }
            else
            {
                $sql = "DELETE FROM favourite WHERE post_id = $postid AND user_id = $userid AND shop_id = $shopid";
                $result = mysqli_query($link, $sql);
                $_SESSION['message'] = "Вы убрали товар из избранного";
            }
        }
    }
    else
    {
        $_SESSION['message'] = "Error";
    }
}
header("Location: ../good.php?id=". $postid);

?>