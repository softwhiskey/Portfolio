<?php
session_start();

include_once ('vendor/language.php');
include_once ('../app/include/api.php');
include_once('../app/include/database.php');
function createTopPanel()
{
    global $link;
    global $lang;
    $login = $_SESSION['user']['login'];
    //$query = mysqli_query($link,
    //"SELECT `satoshi` FROM `users` WHERE `login` = '$login'");
    //$balance = mysqli_fetch_assoc($query);
    $query = mysqli_query($link,
        "SELECT `rub` FROM `users` WHERE `login` = '$login'");
    $rows = mysqli_fetch_assoc($query);
    $satoshi = $rows['rub'];
    /*echo '<ul>
            <li><a><span></span>
                    <span></span>
                    <span></span>
                    <span></span>' . getBTCPrice() .'</a></li>
            <li>';*/
    echo '<ul><li>';
    echo '<a href="index.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>Стать продавцом</a></li>
            <li>';
    echo '<a href="profile.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span><i class="fas fa-user"></i>' . $login . '</a></li>
            <li>';
    echo '<a href="messages.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span><i class="fas fa-envelope"></i></i></a></li>
            <li>';
    echo '<a href="index.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>Помощь</a></li>
            <li>';
    echo '<a href="balance.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span><i class="fas fa-ruble-sign"></i>' . $satoshi.  '</a></li>
            <li>';
    echo '<a href="../vendor/logout.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span> <i class="fas fa-sign-out-alt"></i>' . $lang['quit']. '</a></li>
            <li></ul>';
}
function createFooter()
{
    return;
    echo "<div class=\"buyers\"><b>ПОКУПАТЕЛЯМ</b>
              <li>
                  <a href='toppanel.php'>Как сделать заказ?</a>
                  <a href='toppanel.php'>Оплата</a>
                  <a href='toppanel.php'>Полное руководство</a>
              </li>
         </div>";
}
?>