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
    <title><?=$lang['balance']?></title>
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
                <h2><?=$lang['balance']?></h2><br>
                <span><?=$lang['balancew']?>:
                        <?php
                        $login = $_SESSION['user']['login'];
                        $query = mysqli_query($link,
                            "SELECT `rub` FROM `users` WHERE `login` = '$login'");
                        $address = mysqli_fetch_assoc($query);
                        $balance = $address['rub'];
                        print $balance.  " рублей";
                        ?>
                        <br><br>
                    </span>
            </div>
        </div>
    </div>
    <div class="footer">
        <?php createFooter();?>
    </div>
</div>
</body>
</html>
