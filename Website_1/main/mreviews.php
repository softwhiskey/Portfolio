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
                    echo "<h2>". $result['name']."<span class='rating'><span style='padding-left: 10px;' class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span style='padding-right: 10px'; class=\"fa fa-star fa-xs notchecked\"></span></span><span class='deals'>".(floor($result['deals']/ 10) * 10)."+ сделок</span></h2>";
                    echo "<div class= \"stoppanel\"><ul><li><a href='mhome.php?id=$pg&page=1'>Главная</a></li><li><a href='mreviews.php?id=$pg&page=1'>Отзывы</a></li><li><a href='mabout.php?id=$pg'>О магазине</a></li><li><a href='message.php?id=$pg'>Связаться с продавцом</a></li></ul></div>";
                    $sql = "SELECT * FROM posts as p, reviewsgoods as rg, shoposts as sp, shops as s WHERE sp.shopid = s.shopid AND sp.shopid = $pg 
                AND p.id = sp.postid AND rg.postid = p.id";
                    $result = mysqli_query($link, $sql);
                    $count = mysqli_num_rows($result);
                    $pages = floor($count / 12);
                    if (($count % 12) !=0) $pages++;
                    echo "<div class=\"sgoods\"><h2>Отзывы</h2>";
                    if(mysqli_num_rows($result) == 0) echo "<h3>Отзывов нету</h3>";
                    echo "<span class='pagebar'><p>";
                    $page = 1;
                    while ($pages != 0)
                    {
                        $hreff = "mreviews.php?id=$pg&page=$page";
                        echo "<a href=$hreff><span class='bar'>$page</span></a>";
                        $pages--;
                        $page++;
                    }
                    echo "</p></span>";?>
                    <script>
                        var url = window.location.href;
                        var pages = url.substring(url.indexOf("page=") + 5);
                        if (pages.indexOf("&") != -1) pages = pages.substring(0, pages.indexOf("&"));
                        var found = false;
                        $(".pagebar .bar").each(function (i)
                        {
                            if (this.innerText == pages)
                            {
                                $(this).css("background-color", "#08345a");
                                found = true;
                            }
                        });
                        if(!found)
                        {
                            $(".pagebar .bar").first().css("background-color", "#08345a");
                        }
                        //https://dmarket.ru/main/goods.php?categoryid=1&page=1&xyu=1
                    </script>
                    <?php
                    $page = 1;
                    if(!empty($_GET['page'])) $page = $_GET['page'];
                    $page-=1;
                    $limit = 12;
                    $offset = $page * 12;
                    $sql = "SELECT r.username, r.content, r.rating, r.datee FROM posts as p, reviews as r, reviewsgoods as rg, shops as s, shoposts 
as sp WHERE s.shopid = $pg AND sp.shopid = s.shopid AND sp.postid = p.id AND rg.postid = p.id AND rg.reviewsid = r.id LIMIT $limit OFFSET $offset";
                    $result = mysqli_query($link, $sql);
                    if (mysqli_num_rows($result) > 0)
                    {
                        while ($row = mysqli_fetch_array($result))
                        {
                            $usrn = $row['username'];
                            $cntn = $row['content'];
                            $rati = $row['rating'];
                            $datee = new DateTime($row['datee']);
                            $datee = date_format($datee, 'd-m-Y');
                            $rati = stars($rati);
                            echo "<div class= \"sreviewcell\">
                                <span class='username'>$usrn</span><span class='date'>$datee</span><span class='rating'>$rati</span>
                                <div class='border'></div>
                                <br><div class='content'>$cntn</div>
                            </div>";
                        }
                    }
                    echo "</div>";
                }
                else
                {
                    notFound();
                }
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
