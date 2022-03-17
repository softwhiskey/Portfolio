<?php
session_start();
include ("../../app/include/database.php");
if ($_POST['country'] == "Russia")
    $_SESSION['user']['country'] = "RU";
else if ($_POST['country'] == "Ukraine")
    $_SESSION['user']['country'] = "UA";
else if ($_POST['country'] == "Belarus")
    $_SESSION['user']['country'] = "BY";
$tmp = $_POST['country'];
$query = mysqli_query($link,
    "SELECT `id` FROM `countryinfo` WHERE `name` = '$tmp'");
$country_id = mysqli_fetch_assoc($query)['id'];
$login = $_SESSION['user']['login'];
$sql = mysqli_query($link, "UPDATE `users` SET `country` = '$country_id' 
        WHERE `login` = '$login'");
header('Location: ../settings.php');
?>