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
    <title><?=$lang['profile']?></title>
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
                <h2><?=$lang['profile']?></h2><br>
                <span>
                    <?php
                    $login = $_SESSION['user']['login'];
                    $query = mysqli_query($link,
                        "SELECT `register` FROM `users` WHERE `login` = '$login'");
                    $register = mysqli_fetch_assoc($query)['register'];
                    echo "Регистрация: " . $register;

                    ?>
                </span>
                <br>
                <span>
                    <?php
                    $query = mysqli_query($link,
                        "SELECT `transaction` FROM `users` WHERE `login` = '$login'");
                    $deals = mysqli_fetch_assoc($query)['transaction'];
                    echo "Сделок: " . $deals;
                    ?>
                </span>
                <?php
                $userid = $_SESSION['user']['id'];
                $sql = "SELECT * FROM shops WHERE owner = $userid";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) != 0)
                {
                    echo "<br><span><a style='color: #2196f3; text-decoration: none' href='shop/home'>Управление магазином</a></span>";
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
