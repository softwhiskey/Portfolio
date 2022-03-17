<?php
session_start();
if (!$_SESSION['user'])
{
    header('Location: ../login.php');
}
require_once('../app/include/database.php');
include_once ('vendor/language.php');
include_once ('../app/include/api.php');
include_once ('design/leftpanel.php');
include_once ('design/toppanel.php');
require_once ('../app/include/sec.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$lang['favourite']?></title>
    <link rel = "stylesheet" href="..\assets\css\style2.css">
    <script src="../js_ext/icons.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="wrapper">
    <div class="content">
        <div class="toppanel" id="shine">
            <h1 class="titlee">Emerald</h1>
            <?php createTopPanel(); ?>
        </div>
        <div class="main">
            <div id="shine" class="left_navig">
                <?=$left_panel?>
            </div>
            <div class="pcontent">
                <h2><?=$lang['favourite']?></h2>
                <?php
                $userid = $_SESSION['user']['id'];
                $sql = "SELECT * FROM favourite WHERE user_id = $userid ORDER BY date DESC";
                $result = mysqli_query($link, $sql);
                echo "<table><thead><tr><td>Номер</td><td>Магазин</td><td>Цена</td><td>Название</td><td>Дата добавления</td></tr>";
                $index = 1;
                while ($row = mysqli_fetch_array($result))
                {
                    $postid = $row['post_id'];
                    $shopid = $row['shop_id'];
                    $date = $row['date'];
                    $sql = "SELECT name FROM shops WHERE shopid = $shopid";
                    $result1 = mysqli_query($link, $sql);
                    $result1 = mysqli_fetch_assoc($result1);
                    $shopname = $result1['name'];
                    $sql = "SELECT * FROM posts WHERE id = $postid";
                    $result1 = mysqli_query($link, $sql);
                    $result1 = mysqli_fetch_assoc($result1);
                    $price = convertToBTCFromSatoshi($result1['price']);
                    $post_name = $result1['title'];
                    echo "<tr><td>$index</td><td><a href='mhome.php?id=$shopid'>$shopname</a></td><td>$price</td>
                    <td><a href='good.php?id=$postid'>$post_name</a></td><td>$date</td></tr>";
                    $index++;
                }
                echo ("</table></thead>");
                ?>
            </div>
        </div>
    </div>
    <div class="footer">
        <?php createFooter();?>
    </div>
</div>
</body>
</html>
