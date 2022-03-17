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
    <title><?=$lang['settings']?></title>
    <link rel = "stylesheet" href="..\assets\css\style2.css">
    <link rel = "stylesheet" href="..\assets\css\goods.css">
    <link rel = "stylesheet" href="..\assets\css\shop.css">
    <script src="../js_ext/icons.js" crossorigin="anonymous"></script>
    <script src="../js_ext/jquery-3.6.0.min.js"></script>
</head>
<body id="contentBody" >
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
                <h2>Создать магазин<?php //=$lang['favourite']?></h2>
                <div class="shopcreateinputs">
                    <form method="POST" action="vendor/createshop.php" enctype="multipart/form-data">
                        <p style="color: #6970ff"><?php echo $_SESSION['message'];
                            unset($_SESSION['message']);
                            $sql = "SELECT price FROM prices WHERE id = 1";
                            $result = mysqli_query($link, $sql);
                            $result = mysqli_fetch_assoc($result);
                            $spcreateprice = intval($result['price']);?></p><br>
                        <label>Название магазина:</label>
                        <input name="shopname"><br>
                        <label>Описание магазина:</label>
                        <textarea id="chatborder"name="shopdesc"></textarea><br>
                        <label>Категории продаваемых товаров:</label>
                        <textarea id="chatborder" name="about"></textarea><br>
                        <script>
                            function activateButton(element)
                            {

                                if (element.checked)
                                {
                                    document.getElementById("submitbtn").disabled = false;
                                }
                                else
                                {
                                    document.getElementById("submitbtn").disabled = true;
                                }

                            }
                        </script>
                        <p>Аватар магазина:</p>
                        <input type="file" id="selectedFile" style="display: none;" name="image" />
                        <input type="button" class="custom-file-upload" value="Upload File" onclick="document.getElementById('selectedFile').click();" />
                        <p><input style="margin-top: 20px" required type="checkbox" name="terms" id="terms" onchange="activateButton(this)">  Я соглашаюсь с <a href="help.php">
                                <u>условиями и положениями</u></a></p>
                        <button id="submitbtn" disabled type="submit">Создать магазин (цена создания: <?php echo $spcreateprice ?> рублей)</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <?php createFooter();?>
    </div>
</div>
</body>
</html>
