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
    <title><?=$lang['products']?></title>
    <link rel = "stylesheet" href="..\assets\css\style2.css">
    <script src="../js_ext/icons.js" crossorigin="anonymous"></script>
    <link rel = "stylesheet" href="..\assets\css\goods.css">
    <script src="../js_ext/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="wrapper">
    <div class="content">
        <div class="toppanel" id="shine">
            <h1 class="titlee">Market</h1>
            <?php createTopPanel(); ?>
        </div>
        <div class="main">
            <div id="shine" class="left_navig">
                <?=$left_panel?>
            </div>
            <div class="pcontent">
                <h2><?php echo $lang['products'];
                    $categoryid = 1;
                    if (isset($_GET['categoryid'])) $categoryid = $_GET['categoryid'];
                    $sql = "SELECT * FROM `categories` WHERE `id` = '$categoryid'";
                    $result = mysqli_query($link, $sql);
                    echo " - " . mysqli_fetch_assoc($result)['title'];
                    ?>
                </h2>
                <?php
                $sql = "SELECT * FROM `posts` WHERE `category_id` = '$categoryid'";
                $result = mysqli_query($link, $sql);
                $count = mysqli_num_rows($result);
                $pages = floor($count / 12);
                if (($count % 12) !=0) $pages++;
                echo "<span class='pagebar'><p>";
                $page = 1;
                while ($pages != 0)
                {
                    $hreff = "goods.php?categoryid=$categoryid&page=$page";
                    echo "<a href=$hreff><span class='bar'>$page</span></a>";
                    $pages--;
                    $page++;
                }
                echo "</p></span>"
                ?>
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
                <div class="goods">
                    <?php
                    $page = 1;
                    if(!empty($_GET['page'])) $page = $_GET['page'];
                    $page-=1;
                    $limit = 12;
                    $offset = $page * 12;
                    $sql = "SELECT * FROM `posts` WHERE `category_id` = '$categoryid' LIMIT $limit OFFSET $offset";
                    $result = mysqli_query($link, $sql);
                    if (mysqli_num_rows($result) > 0)
                    {
                        $i = 1;
                        while ($row = mysqli_fetch_array($result))
                        {
                            $title = $row['title'];
                            $id = $row['id'];
                            $sql = "SELECT s.shopid, s.name, p.description, p.price, p.count, p.type, p.id as pid FROM posts as p, shops as s, shoposts as sp WHERE p.id = sp.postid 
                                    AND s.shopid = sp.shopid AND p.id = " . $id;
                            $result1 = mysqli_query($link, $sql);
                            $res = mysqli_fetch_assoc($result1);
                            $storename = $res['name'];
                            $postdesc = $res['description'];
                            $shopid = $res['shopid'];
                            $price = $res['price'];
                            $type = $res['type'];
                            $countt = $res['count'];
                            $mpid = $res['pid'];

                            $sql = "SELECT COUNT(id) as idd FROM posts as p, shops as s, shoposts as sp WHERE sp.shopid = ". $shopid ." AND p.id = sp.postid AND s.shopid = " . $shopid . ";";
                            $resu = mysqli_query($link, $sql);
                            $resu = mysqli_fetch_assoc($resu);
                            $gcount = $resu['idd'];

                            $sql = "SELECT p.title, p.id as pid FROM posts as p, shops as s, shoposts as sp WHERE p.id = sp.postid 
                                    AND s.shopid = sp.shopid AND sp.shopid = ". $shopid ." AND s.shopid = " . $shopid . " ORDER BY RAND() LIMIT 1";
                            $result1 = mysqli_query($link, $sql);
                            $res = mysqli_fetch_assoc($result1);
                            $goodsid = $res['pid'];
                            $goodsid = "good.php? id=" . $goodsid;
                            $goodz = "<span class='footergood'>Ещё товары от этого продавца:<br><a href=\"$goodsid\">".$res['title']."</a></span>";
                            echo '
                        <div class="cell">
                            <span class="cellphoto">
                                <img height="200px" width="200px" src="goods/img/'.$mpid.'.jpg">
                            </span>
                            <div class="desc">
                                <a style="padding-right: 10px" href="good.php?id='.$id.'">' . $title . '</a>
                                <span class="title"><a href="mhome.php?id='.$shopid.'&page=1"><i class="fas fa-store-alt"></i>'.$storename.'</a></span>
                                <span class="text" id="gdesc">папалопалопалпалоапдлопалопадлоапдлопдлоаплоадпадлопдлоаваолваловадловдлоавдлоа</span>
                                <span class="info">
                                    <span id="geospan" title="" class="geo"><span id="geospan1">
                                        </span>
                                        
                                    '.$goodz.'
                                </span>
                                <span class="price"><span class="fa fa-star fa-xs checked"></span>
                                <span class="fa fa-star fa-xs checked"></span>
                                <span class="fa fa-star fa-xs checked"></span>
                                <span class="fa fa-star fa-xs checked"></span>
                                <span class="fa fa-star fa-xs notchecked"></span>   '.$price.' рублей</span>
                                <span class="button"><a href="good.php?id='.$id.'"><button class="buybutton">Купить</button></a></span>
                        </div>
                    </div>';
                            if (($i % 2) == 0) echo "<br/>";
                            $i++;
                        }
                        echo "</div>";
                    }
                    else
                    {
                        echo $lang['nogoods'];
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
