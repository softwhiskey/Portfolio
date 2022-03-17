<?php
session_start();
if (!$_SESSION['admin']) {
    header('Location: ../../login.php');
}
require_once ("vendor/design/createnav.php");
require_once ("../../app/include/database.php");
require_once ("../../app/include/api.php");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Income</title>
    <link href="style.css" rel="stylesheet">
    <script src="../../js_ext/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="nav">
    <?php createNav(); ?>
</div>
<div class="main">
    <h1>User Dm</h1>
    <?php
    echo "<p>".$_SESSION['messag'] . "</p>";
    unset($_SESSION['messag']);
    ?>
    <?php
    echo "<form action='userdm.php' method='post'><label>ID Пользователя: </label><input type='text' name='userid'>
          <label>ID Шопа: </label><input type='text' name='shopid'><input type='submit'></form>";
    $shopid = $_POST['shopid'];
    $userid = $_POST['userid'];
    $sql = "SELECT m.content, m.time, m.type, s.name FROM `messages` as `m`, `shops` as `s` WHERE m.shop_id = $shopid AND m.user_id = $userid
                    AND s.shopid = $shopid ORDER BY `time` DESC";
    $result = mysqli_query($link, $sql) or die();
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
            if ($countf != $ind) echo PHP_EOL;
            $ind++;
        }
        echo "</textarea></div>";
    }
    else
    {
        $sql = "SELECT * FROM shops WHERE shopid = $shopid";
        $result = mysqli_query($link, $sql);
        if(mysqli_num_rows($result) == 0) {
            echo "</textarea></div><p>Такого шопа нет</p>";
            die();
        }
        echo "</textarea></div><p>Такого юзера нет</p>";
    }
    ?>
</div>
</body>
</html>
