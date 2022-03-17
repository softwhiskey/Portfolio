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
    <link rel = "stylesheet" href="..\assets\css\shop.css">
    <link rel = "stylesheet" href="..\assets\css\goods.css">
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
                    $sql = "SELECT * FROM posts as p, shoposts as sp, shops as s WHERE sp.shopid = s.shopid AND sp.shopid = $pg AND p.id = sp.postid ";
                    $result = mysqli_query($link, $sql);
                    $count = mysqli_num_rows($result);
                    $pages = floor($count / 12);
                    if (($count % 12) !=0) $pages++;
                    echo "<div class=\"sgoods\"><h2>Товары</h2>";
                    echo "<span class='pagebar'><p>";
                    $page = 1;
                    while ($pages != 0)
                    {
                        $hreff = "mhome.php?id=$pg&page=$page";
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
                    $sql = "SELECT s.shopid, p.title, p.id FROM `posts` as `p`, `shops` as `s`, `shoposts` as `sp` WHERE s.shopid = $pg AND 
                                sp.postid = p.id AND sp.shopid = s.shopid LIMIT $limit OFFSET $offset";
                    $result = mysqli_query($link, $sql);
                    if (mysqli_num_rows($result) > 0)
                    {
                        $i = 1;
                        while ($row = mysqli_fetch_array($result))
                        {
                            $title = $row['title'];
                            $id = $row['id'];
                            $sql = "SELECT s.shopid, s.name, p.description, p.price, p.id as pid FROM posts as p, shops as s, shoposts as sp WHERE p.id = sp.postid 
                                    AND s.shopid = sp.shopid AND sp.postid = p.id AND p.id = sp.postid AND s.shopid = " . $pg;
                            $result1 = mysqli_query($link, $sql);
                            $res = mysqli_fetch_assoc($result1);
                            $storename = $res['name'];
                            $postdesc = $res['description'];
                            $shopid = $res['shopid'];
                            $price = $res['price'];
                            //$mpid = $res['pid'];

                            //$sql = "SELECT COUNT(id) as idd FROM posts as p, shops as s, shoposts as sp WHERE sp.shopid = ". $shopid ." AND p.id = sp.postid AND s.shopid = " . $shopid . ";";
                            //$resu = mysqli_query($link, $sql);
                            //$resu = mysqli_fetch_assoc($resu);
                            //$gcount = $resu['idd'];

                            $sql = "SELECT p.title, p.id as pid FROM posts as p, shops as s, shoposts as sp WHERE p.id = sp.postid 
                                    AND s.shopid = sp.shopid AND sp.shopid = ". $shopid ." AND s.shopid = " . $shopid . " ORDER BY RAND() LIMIT 1";
                            $result1 = mysqli_query($link, $sql);
                            $res = mysqli_fetch_assoc($result1);
                            $goodsid = $res['pid'];
                            $goodsid = "good.php?id=" . $goodsid;
                            $goodz = "<span class='footergood'>Ещё товары от этого продавца:<br><a href=\"$goodsid\">".$res['title']."</a></span>";
                            echo '
                        <div class="cell">
                            <span class="cellphoto">
                                <img height="200px" width="200px" src="goods/img/'.$id.'.jpg">
                            </span>
                            <div class="desc">
                                <a style="padding-right: 10px" href="good.php?id='.$id.'">' . $title . '</a>
                                <span class="title"><a href="mhome.php?id='.$shopid.'&page=1"><i class="fas fa-store-alt"></i>'.$storename.'</a></span>
                                <span class="text" id="gdesc">папалопалопалпалоапдлопалопадлоапдлопдлоаплоадпадлопдлоаваолваловадловдлоавдлоа</span>
                                <span class="info">
                                    <span id="geospan" title="" class="geo"><span id="geospan1"></span>
                                        
                                    <script>
                                        $("#geospan").attr("title", $("#geospan1").clone().children().remove().end().text());
                                    </script>
                                    '.$goodz.'
                                </span>
                                <span class="price"><span class="fa fa-star fa-xs checked"></span>
                                <span class="fa fa-star fa-xs checked"></span>
                                <span class="fa fa-star fa-xs checked"></span>
                                <span class="fa fa-star fa-xs checked"></span>
                                <span class="fa fa-star fa-xs notchecked"></span> '.$price.' рублей</span>
                                <span class="button"><a href="'.$goodsid.'"><button class="buybutton">Купить</button></a></span>
                        </div>
                    </div>';
                            if (($i % 2) == 0) echo "<br/>";
                            $i++;
                        }
                        echo "</div>";
                    }
                    else
                    {
                        echo "Список товаров пуст";
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
