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
                <h2><?=$lang['settings']?></h2><br>
                <span style="font-size: 23px"><?=$lang['password_chng']?></span><br>
                <form action="vendor/savepass.php" method="POST">
                    <input type="password" name="old_password" placeholder="<?=$lang['old_password']?>">
                    <input type="password" name="password" placeholder="<?=$lang['new_password']?>">
                    <input type="password" name="password_confirm" placeholder="<?=$lang['confirm_password']?>">
                    <button type="submit"><?=$lang['save']?></button>
                </form>
                <?php
                if ($_SESSION['message'])
                {
                    echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
                }
                unset($_SESSION['message']);
                ?>
                <!--<span style="font-size: 23px"><?=$lang['language']?></span><br>
                <form style="display: block" action="vendor/setlanguage.php" method="POST">
                    <select name="lang" id="language" selected ="2">
                        <option value="ru" <?php //echo $_SESSION['lang'] == 'ru' ? 'selected' : ''?>>Русский</option>
                        <option value="en" <?php //echo $_SESSION['lang'] == 'en' ? 'selected' : ''?>>English</option>
                        <option value="cz" <?php //echo $_SESSION['lang'] == 'cz' ? 'selected' : ''?>>Čeština</option>
                    </select>
                    <button type="submit"><?=$lang['save']?></button>
                </form>
                <span style="font-size: 23px"><?=$lang['country']?></span><br>
                <form style="display: block" action="vendor/setcountry.php" method="POST">
                    <select name="country" id="country" selected ="2">
                        <?php
                        $sql = "SELECT * FROM countryinfo";
                        $result = mysqli_query($link, $sql);
                        while($row = mysqli_fetch_array($result))
                        {
                            $r = strtoupper($_SESSION['user']['country']) == $row['identifier'] ? "selected" : "";
                            //echo '<option value="' . $row['name'] . "\" " . $r . ">" . $row['name'] . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit"><?=$lang['save']?></button>
                </form>!-->

            </div>
        </div>
    </div>
    <div class="footer">
        <?php createFooter();?>
    </div>
</div>
</body>
</html>
