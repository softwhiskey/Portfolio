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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$lang['services']?></title>
    <link rel = "stylesheet" href="..\assets\css\style.css">
    <script src="../js_ext/icons.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="wrapper">
    <div class="content">
        <hr>
        <h1>Кирилydra</h1>
        <div class="topnav">
            <?php createTopPanel(); ?>
        </div>
        <hr>
        <div class="left_navig">
            <?=$left_panel?>
        </div>
        <div class="main">
            <h2><?=$lang['services']?></h2>
        </div>
    </div>
    <div class="footer">
        <?php createFooter();?>
    </div>
</div>
</body>
</html>
