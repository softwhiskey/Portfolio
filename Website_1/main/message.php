<?php
session_start();
if (!$_SESSION['user'])
{
    header('Location: ../login.php');
}
require_once('../app/include/database.php');
require_once ('vendor/language.php');
require_once ('../app/include/api.php');
require_once ('design/leftpanel.php');
require_once ('design/toppanel.php');
require_once ('../app/include/sec.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$lang['msg']?></title>
    <link rel = "stylesheet" href="..\assets\css\style2.css">
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
                <h2><?=$lang['msg']?></h2>
                <?php
                $idf = formatstr($_GET['id']);
                if (is_numeric($idf) and !IsNullOrEmptyString($idf))
                {
                    $userrid = $_SESSION['user']['id'];
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
                            if($sname == null) $sname = $row['name'];
                            $data[$b] = $row;
                            $b++;
                        }
                    }
                    echo "<div id='bodybox'>
                    <span><a href='mhome.php?id=$idf'>$sname</a></span>
                <textarea readonly id='chatborder'>";
                    $data = array_reverse($data);
                    if (mysqli_num_rows($result) > 0)
                    {
                        $countf = mysqli_num_rows($result);
                        $ind = 1;
                        foreach ($data as $row)
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
                        $sql = "SELECT * FROM shops WHERE shopid = $idf";
                        $result = mysqli_query($link, $sql);
                        if (mysqli_num_rows($result) == 0)
                        {
                            echo "</textarea>";
                            notFound();
                            die();
                        }
                        echo "</textarea>";
                        echo "<p>История сообщений пуста</p>";
                    }
                }
                else
                {
                    notFound();
                    die();
                }
                echo "<form style='width: 900px;' action=\"vendor/sendmsg.php\" method=\"post\">
                <input class='minpt' type=\"text\" name=\"msg\" placeholder=\"Сообщение\">
                <input type='hidden' name='s' value='$idf'>
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
