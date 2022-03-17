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
    <title><?=$lang['home']?></title>
    <link rel = "stylesheet" href="..\assets\css\style2.css">
    <link rel = "stylesheet" href="..\assets\css\goods.css">
    <link rel = "stylesheet" href="..\assets\css\shop.css">
    <script src="../js_ext/icons.js" crossorigin="anonymous"></script>
    <script src="../js_ext/jquery-3.6.0.min.js"></script>
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
                <?php
                function shoperror()
                {
                    echo '<h2>Запрашиваемый магазин не найден либо был удалён</h2>';
                    die();
                }
                $pg = formatstr($_GET['id']);
                if (is_numeric($pg) and !IsNullOrEmptyString($pg))
                {
                    $sql = "SELECT * FROM shops WHERE shopid = " . $pg;
                    $result = mysqli_query($link, $sql) or shoperror();
                    $result = mysqli_fetch_assoc($result);
                    if (empty($result)) shoperror();
                    $about = $result['about'];
                    echo "<h2>" . $result['name'] . "<span class='rating'><span style='padding-left: 10px;' class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span style='padding-right: 10px'; class=\"fa fa-star fa-xs notchecked\"></span></span><span class='deals'>" . (floor($result['deals'] / 10) * 10) . "+ сделок</span></h2>";
                    echo "<div class= \"stoppanel\"><ul><li><a href='mhome.php?id=$pg&page=1'>Главная</a></li><li><a href='mreviews.php?id=$pg&page=1'>Отзывы</a></li><li><a href='mabout.php?id=$pg'>О магазине</a></li><li><a href='message.php?id=$pg'>Связаться с продавцом</a></li></ul></div>";
                    if (($count % 12) != 0) $pages++;
                    echo "<div class=\"sgoods\"><h2>О магазине</h2>";
                    echo "$about</div>";
                }
                else
                {
                    notFound();
                }?>
            </div>
        </div>
    </div>
    <div class="footer">
        <?php createFooter();?>
    </div>
</div>
</body>
</html>
