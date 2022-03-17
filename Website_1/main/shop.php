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
    <title><?=$lang['shop']?></title>
    <link rel = "stylesheet" href="..\assets\css\style2.css">
    <link rel="stylesheet" href="..\assets\css\goods.css">
    <script src="../js_ext/icons.js" crossorigin="anonymous"></script>
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
                <h2>Магазины</h2>
                <?php
                $sql = "SELECT * FROM shops";
                $result = mysqli_query($link, $sql);
                //$href = 1;
                while ($row = mysqli_fetch_array($result))
                {
                    $href = $row['shopid'];
                    $hreff = "mhome.php?id=" . $href . "&page=1";
                    $img = $row['img'];
                    echo "
                    <div onclick=\"location.href='$hreff';\" style=\"cursor: pointer;height: 300px\" class=\"categorycell\">
                        <img style='padding-top: 5px;' height=\"190px\" width=\"190px\" src=\"shop/img/$img\">
                        <span class='shopname'><i style='padding-top: 25px; padding-bottom: 15px' class=\"fas fa-store-alt\"></i>
                            <a href='$hreff'>" . $row['name'] . "</a><br><span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>
                        </span>
                    </div>";
                    $href++;
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
