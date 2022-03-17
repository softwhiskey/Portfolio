<?php
session_start();
if (!$_SESSION['user'])
{
    header('Location: ../../../login.php');
}
require_once('../../app/include/database.php');
require_once ('../vendor/language.php');
require_once ('../../app/include/api.php');
require_once ('../../app/include/sec.php');
require_once ('vendor/createleft.php');
if(!userHasShop($_SESSION['user']['id'])) header('Location: ../index.php');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Магазин - Главная</title>
        <link rel = "stylesheet" href="assets/style.css">
        <script src="../../js_ext/icons.js" crossorigin="anonymous"></script>
        <script src="../../js_ext/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <div class="toppanel" id="shine">
            <h1 class="titlee">Сообщения</h1>
        </div>
        <div class="main">
            <div class="left_navig">
                <div id="leftboard">
                    <?php createLeft();?>
                </div>
            </div>
            <div class="pcontent">
                <?php
                echo "<p>".$_SESSION['messag'] . "</p>";
                unset($_SESSION['messag']);
                $page = $_GET['page'];
                $adminshopid = userHasShop($_SESSION['user']['id']);
                if(empty($page))
                {
                    $idf = $adminshopid;
                    $userrid = intval($_GET['id']);
                    $sql = "SELECT m.content, m.time, m.type, s.name FROM `messages` as `m`, `shops` as `s` WHERE m.shop_id = $idf AND m.user_id = $userrid
                    AND s.shopid = $idf ORDER BY `time` DESC";
                    $result = mysqli_query($link, $sql);
                    $data[] = null;
                    $b = 0;
                    $sname = null;
                    if (mysqli_num_rows($result) > 0)
                    {
                        while ($row = mysqli_fetch_array($result))
                        {
                            if($sname == null) $sname = $row['login'];
                            $data[$b] = $row;
                            $b++;
                        }
                    }
                    echo "<div id='bodybox'>
                    <span><a>$sname</a></span>
                <textarea readonly id='chatborder'>";
                    $data = array_reverse($data);
                    if (mysqli_num_rows($result) > 0)
                    {
                        $countf = mysqli_num_rows($result);
                        $ind = 1;
                        foreach($data as $row)
                        {
                            $content = $row['content'];
                            $tim = $row['time'];
                            $typ = $row['type'];
                            $from = "";
                            $classname = (bool) $typ;
                            if (!$classname)
                            {
                                $from = $row['name'];
                                $classname = ".messageshop";
                            }
                            else
                            {
                                $from = $_SESSION['user']['login'];
                                $classname = ".messageusr";
                            }
                            $tmspt = strtotime($tim);
                            $dt = date('m.d.Y h:i:s a', $tmspt);
                            echo "$from:$content";
                            if($countf != $ind) echo PHP_EOL;
                            $ind++;
                        }
                        //echo "<input type=\"text\" name=\"chat\" id=\"chatbox\" placeholder=\"Hi there! Type here to talk to me.\" onfocus=\"placeHolder()\"></div>";
                        echo "</textarea>";
                    }
                    else
                    {
                        $sql = "SELECT * FROM users WHERE id = $userrid";
                        $result = mysqli_query($link, $sql) or function()
                        {
                            echo "Пользователь не найден/ошибка</textarea>";
                            die();
                        };
                        //$result = mysqli_fetch_row($result);
                        if (mysqli_num_rows($result) == 0)
                        {
                            echo "Пользователь не найден</textarea>";
                            die();
                        }
                        echo "</textarea>";
                        echo "<p>История сообщений пуста</p>";
                    }
                    echo "<form style='width: 900px;' action=\"vendor/sendmsg.php\" method=\"post\">
                <input class='minpt' type=\"text\" name=\"msg\" placeholder=\"Сообщение\">
                <input type='hidden' name='s' value='$userrid'>
                <input type='hidden' name='d' value='$idf'>
                <script>
                var psconsole = $('#chatborder');
                if(psconsole.length)
                psconsole.scrollTop(psconsole[0].scrollHeight - psconsole.height());
                function hideBtn() 
                {
                  $('#mbuttn').on(\"click\", function() 
                  {
                    $('#mbuttn').attr(\"disabled\", true);
                  })
                }
                </script>
                <button id='mbuttn' class='mbuttn' type=\"submit\" onclick='hideBtn()'>Отправить</button>
                </form></div>";
                    if ($_SESSION['message'])
                    {
                        echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
                    }
                    unset($_SESSION['message']);
                    die();
                }
                $sql = "SELECT * FROM `messages` WHERE `shop_id` = $adminshopid ORDER BY `time` DESC";
                $result = mysqli_query($link, $sql);
                if (empty($result) or mysqli_num_rows($result) == 0)
                {
                    echo "Сообщений нет";
                    die();
                }
                else
                {
                    $data[] = null;
                    $cnb = 1;
                    while ($row = mysqli_fetch_array($result))
                    {
                        $user_id = $row['user_id'];
                        if (!in_array($user_id, $data))
                        {
                            array_push($data, $user_id);
                            $content = $row['content'];
                            $date = $row['time'];
                            $tmspt = strtotime($date);
                            $dt = date('m.d.Y H:i:s', $tmspt);
                            $resultt = mysqli_query($link, "SELECT * FROM users WHERE id = $user_id");
                            $resultt = mysqli_fetch_assoc($resultt);
                            $login = $resultt['login'];
                            echo "<div class='messagebox'><div class='mbody'><a href='messages.php?id=$user_id'><span class='mcontent'><b>$cnb.</b> $content</span><span class='datee'>$dt</span></a><span class='shopnam'><a href='messages.php?id=$user_id'>$login</a></span></div></div>";
                            $cnb++;
                        }

                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>

