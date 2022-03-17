<?php
session_start();

if ($_SESSION['user'])
{
    header('Location: main/profile.php');
}
unset($_SESSION['captcha_keystring']);
include ('main/vendor/language.php');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <form action="vendor/signin.php" method="post">
        <label><?=$lang['login']?></label>
        <input type="text" name="login" placeholder="<?=$lang['login_enter']?>">
        <label><?=$lang['password']?></label>
        <input type="password" name="password" placeholder="<?=$lang['password_enter']?>">
        <label><?=$lang['secret']?></label>
        <input type="password" name="secret_name" placeholder="<?=$lang['secret_enter']?>">
        <button type="submit"><?=$lang['signin']?></button>
        <p>
            <?=$lang['noacc']?>? - <a href="views/register/register.php"><?=$lang['register']?></a>!
        <h4 style="float: right"><a href="main/vendor/setlanguage.php">
                <?php
                if($_SESSION['lang'] == "ru")
                    echo "EN";
                else echo "RU";?></a></h4>
        </p>
        <?php
            if ($_SESSION['message'])
            {
                echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
            }
            unset($_SESSION['message']);
        ?>
 </form>
</body>
</html>
