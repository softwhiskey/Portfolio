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
    <title><?=$lang['category']?></title>
    <link rel = "stylesheet" href="..\assets\css\style2.css">
    <link rel = "stylesheet" href="..\assets\css\shop.css">
    <link rel = "stylesheet" href="..\assets\css\goods.css">
    <script src="../js_ext/icons.js" crossorigin="anonymous"></script>
    <script src="../js_ext/jquery-3.6.0.min.js"></script>
</head>
<body id="contentBody" >
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
                function gooderror()
                {
                    echo '<h2>Запрашиваемый товар не найден либо был удалён</h2>';
                    die();
                }
                $pg = formatstr($_GET['id']);
                if (is_numeric($pg) and !IsNullOrEmptyString($pg))
                {
                    $sql = "SELECT sh.name as nname, sh.deals as ddeals, sh.shopid FROM shops as sh, shoposts as sp, posts as p WHERE sh.shopid = sp.shopid 
AND sp.postid = p.id AND p.id = " . $pg;
                    $result = mysqli_query($link, $sql) or gooderror();
                    $result = mysqli_fetch_assoc($result);
                    if (empty($result)) gooderror();
                    $shopid = $result['shopid'];
                    echo "<h2>". $result['nname']."<span class='rating'><span style='padding-left: 10px;' class=\"fa fa-star fa-xs checked\"></span>
                <span class=\"fa fa-star fa-xs checked\"></span>
                <span class=\"fa fa-star fa-xs checked\"></span>
                <span class=\"fa fa-star fa-xs checked\"></span>
                <span style='padding-right: 10px'; class=\"fa fa-star fa-xs notchecked\"></span></span><span class='deals'>".(floor($result['ddeals']/ 10) * 10)."+ сделок</span></h2>";
                    echo "<div class= \"stoppanel\"><ul><li><a href='mhome.php?id=$shopid&page=1'>Главная</a></li><li><a href='mreviews.php?id=$shopid&page=1'>Отзывы</a></li><li><a href='mabout.php?id=$shopid'>О магазине</a></li><li><a href='message.php?id=$shopid'>Связаться с продавцом</a></li></ul></div>";
                    echo "</p></span>";
                    $sql = "SELECT * FROM posts WHERE id = " . $pg;
                    $result = mysqli_query($link, $sql) or gooderror();
                    $result = mysqli_fetch_assoc($result);
                    if (empty($result)) gooderror();
                    $name = $result['title'];
                    $mid = $result['id'];

                    $price = $result['price'];
                    $type = $result['type'];
                    $countt = $result['count'];
                    $desc = $result['description'];
                    $categid = $result['category_id'];
                    $dateadded1 = $result['added'];
                    $dateadded = date("d-m-Y", strtotime($dateadded1));
                    $sql2 = "SELECT * FROM post_lines WHERE post_id = $pg";
                    $result2 = mysqli_query($link, $sql2) or die();
                    $remain = mysqli_num_rows($result2);
                    $sql1 = "SELECT * FROM categories WHERE id = " . $categid;
                    $result1 = mysqli_query($link, $sql1);
                    $result1 = mysqli_fetch_assoc($result1);
                    $categname = $result1['title'];
                    echo "<div class='goodcont'><div class='contenttv'>";
                    $sesmsg = $_SESSION['message'];
                    //<i class="fas fa-ruble-sign"></i>
                    echo "<div class='gooddesc'>$sesmsg<h2>$name</h2>
            <span>$desc</span><br><br>
            <span class='gprice'>Цена: $price рублей<br>
            В наличии: $remain штук</span><br>
            Дата добавления:  $dateadded
            <form method= 'POST' id='sbm' action='vendor/buy.php'>
                <input hidden name='goodid' value='$pg'>
                <input hidden name = 'shopid' value='$shopid'>
                <div class='buttonsection'><span><button class=\"bbutton\" onclick=\"completeAndRedirect(1)\">Купить</button>
                <button class=\"bbutton\" style='padding: 10px 10px 10px 10px' onclick=\"completeAndRedirect(2)\"><i class=\"fas fa-star\"></i></button></span></div></form>
            </div>";
                    unset($_SESSION['message']);
                    echo "<script>
                    function completeAndRedirect(x)
                    {
                        x = parseInt(x);
                        if(x == 1)
                        {
                            var r = confirm(\"Вы хотите купить это?\");
                            if (r == true) 
                            {
                                $(\"#sbm\").attr('action', 'vendor/buy.php');
                                $(\"#sbm\").submit();
                            }
                        }
                        if(x == 2)
                        {
                            $(\"#sbm\").attr('action', 'vendor/addfavourite.php');
                            $(\"#sbm\").submit();
                        }
                  }
                  </script>";
                    echo "<div class='goodimg'>
                      <img height=\"245px\" width=\"245px\" src=\"goods/img/$mid.jpg\">
                  </div></div>";
                    echo "<span style='margin-top: 20px'></span><div class='reviewcells'>";
                    $sql = "SELECT * FROM posts as p, reviewsgoods as rg, shoposts as sp, shops as s WHERE sp.shopid = s.shopid AND sp.shopid = $shopid 
                    AND p.id = sp.postid AND rg.postid = p.id AND p.id = $pg";
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
                        $hreff = "good.php?id=$pg&page=$page";
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
as sp WHERE s.shopid = $shopid AND sp.shopid = s.shopid AND sp.postid = p.id AND rg.postid = p.id AND rg.reviewsid = r.id AND p.id = $pg LIMIT $limit OFFSET $offset";
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
                    echo "</div></div>";
                }
                else
                {
                    gooderror();
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