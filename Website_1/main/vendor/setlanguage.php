<?php
session_start();
require_once '../../app/include/database.php';
if (isset($_POST['lang']) || empty($_POST['lang']))
{
    if ($_SESSION['lang'] == "ru")
        $_SESSION['lang'] = "en";
    else if($_SESSION['lang'] == "en")
        $_SESSION['lang'] = "ru";
}
// ----------------------------------------------------------------------
// todo database update setlanguage.php
// ----------------------------------------------------------------------
if ($_POST['lang'] == "ru")
    $_SESSION['lang'] = "ru";
else if ($_POST['lang'] == "en")
    $_SESSION['lang'] = "en";
else if ($_POST['lang'] == "cz")
    $_SESSION['lang'] = "cz";
$login = $_SESSION['user']['login'];
$language = $_SESSION['lang'];
$sql = mysqli_query($link, "UPDATE `users` SET `language` = '$language' 
        WHERE `login` = '$login'");
header('Location: ../settings.php');
?>