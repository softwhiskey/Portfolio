<?php
session_start();
if (!$_SESSION['user'])
{
    header('Location: ../../../login.php');
    die();
}
require_once ('../../app/include/database.php');
require_once ('../vendor/language.php');
require_once ('../../app/include/api.php');
require_once ('../../app/include/sec.php');
require_once ('vendor/createleft.php');
if(!userHasShop($_SESSION['user']['id'])) header('Location: ../index.php');
if (empty(formatstr($_GET['page'])) and empty(formatstr($_GET['id'])))
{
    header("Location: goods.php?page=1");
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Магазин - Главная</title>
        <link rel = "stylesheet" href="assets/style.css">
        <script src="../../js_ext/icons.js" crossorigin="anonymous"></script>
        <script src="../../js_ext/jquery-3.6.0.min.js"></script>
        <script src="../../js_ext/duhjf.js"></script>
    </head>
    <body>
        <div class="toppanel" id="shine">
            <h1 class="titlee">Товары</h1>
        </div>
        <div class="main">
            <div class="left_navig">
                <div id="leftboard">
                    <?php createLeft();?>
                </div>
            </div>
            <div class="pcontent">
                <?php
                $usershop = intval(userHasShop($_SESSION['user']['id']));
                if (empty (formatstr($_GET['page'])))
                {
                    $id = formatstr($_GET['id']);
                    $sql = "SELECT p.id, p.title, p.price, p.count, p.type, p.image, p.description, p.location,
                    p.category_id FROM posts as p, shops as s, shoposts as sp WHERE p.id = sp.postid AND sp.shopid = $usershop
                    AND s.shopid = $usershop AND p.id = $id";
                    $result = mysqli_query($link, $sql);
                    if (mysqli_num_rows($result) > 0)
                    {
                        $result = mysqli_fetch_assoc($result);
                        $title = $result['title'];
                        $description = $result['description'];
                        $count = $result['count'];
                        $type = $result['type'];
                        $location = $result['location'];
                        $imgpath = $result['image'];
                        $categoryid = $result['category_id'];
                        $price = $result['price'];
                        echo "<h2>$title - Редактирование товара</h2><br>";
                        echo "<form action='vendor/changegood.php' method='post'>
                            <label>Название:</label><input value='$title' name='title'>
                            <label>Цена:</label><label id='pricesatoshi'>$price</label><input id='priceinput' value='$price' name='title'>
                        </form>";
                        echo "<script>
                        $(document).ready(function() 
                        {
                            changeprice();
                            $(\"#priceinput\").keyup(function () 
                            {
                                changeprice();
                            });
                        });
                        function changeprice(tmp)
                        {
                            var price = $(\"#priceinput\").val();
                            if(tmp != null) price = tmp;
                            try
                            {
                                $(\"#pricesatoshi\").html(sb.toBitcoin(parseInt(price)));
                            }
                            catch (e) {
                              changeprice(0);
                            }
                        }
                        </script>";
                    }
                    else
                    {
                        echo "Товар не найден";
                    }
                }
                else
                {
                    $page = intval(formatstr($_GET['page']));
                    if(empty($page)) $page = 1;
                    $page-=1;
                    $limit = 12;
                    $offset = $page * 12;
                    $sql = "SELECT p.id, p.title, p.price, p.remain FROM posts as p, shops as s, shoposts as sp WHERE p.id = sp.postid AND sp.shopid = $usershop
                    AND s.shopid = $usershop LIMIT $limit OFFSET $offset";
                    $result = mysqli_query($link, $sql);
                    if (mysqli_num_rows($result) > 0)
                    {
                        echo "<table>
                              <thead>
                                  <tr>
                                      <td>Название</td><td>Цена</td><td>Остаток</td>
                                 </tr></thead>";
                        while ($row = mysqli_fetch_array($result))
                        {
                            echo "<tr><td>";
                            $id = $row['id'];
                            echo $row['title'] . "</td><td>". $row['price'] . "</td><td>" . $row['remain'] . "</td><td><a href='goods.php?id=$id'>Редактировать</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                    else
                    {
                        echo "<span>Страницы не существует</span>";
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>

