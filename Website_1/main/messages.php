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
    <link rel = "stylesheet" href="..\assets\css\messages.css">
    <link rel = "stylesheet" href="..\assets\css\style2.css">
    <script src="../js_ext/icons.js" crossorigin="anonymous"></script>
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
            <h2><?=$lang['msg']?></h2>
            <?php
            $userid = $_SESSION['user']['id'];
            $sql = "SELECT * FROM `messages` WHERE `user_id` = $userid ORDER BY `time` DESC";
            $result = mysqli_query($link, $sql);

            if (empty($result)) die();

            if (mysqli_num_rows($result) > 0)
            {
                $data[] = null;
                $cnb = 1;
                while ($row = mysqli_fetch_array($result))
                {
                    $shopid = $row['shop_id'];
                    if (!in_array($shopid, $data))
                    {
                        array_push($data, $shopid);
                        $content = $row['content'];
                        $date = $row['time'];
                        $tmspt = strtotime($date);
                        $dt = date('m.d.Y H:i:s', $tmspt);
                        $resultt = mysqli_query($link, "SELECT * FROM `shops` WHERE `shopid` = $shopid");
                        $resultt = mysqli_fetch_assoc($resultt);
                        $shopname = $resultt['name'];
                        echo "<div class='messagebox'><div class='mbody'><a href='message.php?id=$shopid'><span class='mcontent'><b>$cnb.</b> $content</span><span class='datee'>$dt</span></a><span class='shopnam'><a href='mhome.php?id=$shopid&page=1'>$shopname</a></span></div></div>";
                        $cnb++;
                    }

                }
            }
            else
            {
                echo "<p>История сообщений пуста</p>";
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
