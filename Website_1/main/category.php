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
    <title><?=$lang['category']?></title>
    <link rel = "stylesheet" href="..\assets\css\style2.css">
    <link rel="stylesheet" href="..\assets\css\goods.css">
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
                <h2><?=$lang['category']?></h2>
                <?php
                $sql = "SELECT * FROM categories";
                $result = mysqli_query($link, $sql);
                $href = 1;
                while ($row = mysqli_fetch_array($result))
                {
                    $hreff = "goods.php?categoryid=" . $href . "&page=1";
                    echo "
                    <div onclick=\"location.href='$hreff';\" style=\"cursor: pointer;\" class=\"categorycell\">
                        <a href='$hreff'>" . $row['title'] . "</a>
                        <span>
                            <img style='padding-right: 5px' height=\"184px\" width=\"206px\" src=\"test.png\">
                        </span>
                    </div>";
                    //echo '<option value="' . $row['name'] . "\" " . $r . ">" . $row['name'] . "</option>";
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
