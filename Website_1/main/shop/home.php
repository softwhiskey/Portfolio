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
    <script src="../js_ext/icons.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="toppanel" id="shine">
        <h1 class="titlee">Главная</h1>
    </div>
    <div class="main">
        <div class="left_navig">
            <div id="leftboard">
                <?php createLeft();?>
            </div>
        </div>
        <div class="pcontent">
            <h2>Информация для продавцов</h2>
        </div>
    </div>
</body>
</html>

