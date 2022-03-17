<?php
session_start();
if (!$_SESSION['user'])
{
    header('Location: ../login.php');
}
require_once '../../app/include/database.php';
require_once ('../../app/include/sec.php');
$g = intval(htmlspecialchars(mysqli_real_escape_string($link, $_POST['goodid'])));

$success = false;
if (!IsNullOrEmptyString($g))
{
    $sql = "SELECT * FROM posts WHERE id = $g";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) != 0)
    {
        $result = mysqli_fetch_assoc($result);
        $userid = intval($_SESSION['user']['id']);
        $sql2 = "SELECT * FROM post_lines WHERE post_id = $g";
        $result2 = mysqli_query($link, $sql2) or die();
        $remain = mysqli_num_rows($result2);
        $postname = $result['title'];
        if ($remain > 0)
        {
            $gprice = intval($result['price']);
            $gcontent = $result['content'];
            $sql = "SELECT rub FROM users WHERE id = $userid";
            $result = mysqli_query($link, $sql);
            $result = mysqli_fetch_assoc($result);
            $usatoshi = intval($result['rub']);
            if ($usatoshi >= $gprice)
            {
                $usatoshi -= $gprice;
                $sql = "UPDATE users SET rub = $usatoshi WHERE id = $userid";
                mysqli_query($link, $sql);
                $sql = "SELECT sh.shopid, sh.deals, sh.rub FROM shops as sh, shoposts as sp, posts as p WHERE sh.shopid = sp.shopid 
                AND sp.postid = p.id AND p.id = " . $g;
                $result = mysqli_query($link, $sql);
                $result = mysqli_fetch_assoc($result);
                $sg = intval($result['shopid']);
                $ssatoshi = intval($result['rub']);
                $sdeals = intval($result['deals']);
                $sql = "SELECT price FROM prices WHERE id = 2";
                $result = mysqli_query($link, $sql);
                $result = mysqli_fetch_assoc($result);
                $comission = intval($result['price']);
                $comission = (100 - 5) / 100;
                $ssatoshi+= $comission * $gprice;
                $pricenocomis = $comission * $gprice;
                $sdeals++;
                $sql = "SELECT id, content FROM post_lines WHERE post_id = $g ORDER BY date_added ASC LIMIT 1";
                $result = mysqli_query($link, $sql);
                $result = mysqli_fetch_assoc($result);
                $ggcontent = $result['content'];
                $postlineid = $result['id'];
                $gcontent = "Это сообщение создано автоматически. Благодарим вас за покупку
в нашем магазине. Сообщение от продавца: " . $ggcontent; //." Сообщение от продавца: " . $gcontent;
                $sql = "INSERT INTO messages VALUES (DEFAULT, $userid, $sg, '$gcontent',
                                DEFAULT, 0)";
                mysqli_query($link, $sql);
                $sql = "DELETE FROM post_lines WHERE id = $postlineid";
                mysqli_query($link, $sql);
                $sql = "INSERT INTO orders VALUES (DEFAULT, $userid, $sg, $g,
                                $gprice,  '$postname', DEFAULT, 0)";
                mysqli_query($link, $sql);
                $sql = "UPDATE shops SET rub = $ssatoshi, deals = $sdeals WHERE shopid = $sg";
                mysqli_query($link, $sql);
                $remain--;
                $sql = "UPDATE posts SET remain = $remain WHERE id = $g";
                mysqli_query($link, $sql);
                $sql = "INSERT INTO income VALUES(DEFAULT, $pricenocomis, 'order')";
                mysqli_query($link, $sql);
                $success = true;

            }
            else
            {
                $_SESSION['message'] = "У вас недостаточно средств для покупки.";
            }
        }
        else
        {
            $_SESSION['message'] = 'Товара нет в наличии';
        }
    }
    else
    {
        $_SESSION['message'] = 'Ошибка';
    }
}
else
{
    $_SESSION['message'] = 'Ошибка';
}
if (!$success)
    header("Location: ../good.php?id=". $g);
else
    header("Location: ../message.php?id=". $sg);
?>