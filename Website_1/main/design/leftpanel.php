<?php
define('MyConst', TRUE);
if(!defined('MyConst')) {
    die('Direct access not permitted');
}
include_once ('vendor/language.php');
include_once('../app/include/database.php');
$sql = "SELECT * FROM categories";
$result = mysqli_query($link, $sql);
$href = 1;
//$list = "";
//while ($row = mysqli_fetch_array($result))
//{
    //$hreff = "goods.php?categoryid=" . $href . "&page=1";
    //$list .= "<li><a href='$hreff'><span></span>
                    //<span></span>
                    //<span></span>
                    //<span></span>" . $row['title'] . "</a></li>";
    //$href++;
//}
$left_panel = '<div id="leftboard"><ul>
                   <li>
                       <a href="index.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                          
                               <i class="fas fa-home"></i>
                        </a><span class="ltext">'.$lang['home'].'</span>
                  </li>
                  <li>
                       <a href="shop.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                               <i class="fas fa-store"></i>
                       </a><span class="ltext">'.$lang['shops'].'</span>
                  </li>
                  <li>
                      <a href="category.php"><span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                               <i class="fas fa-bars"></i>
                      </a>  <span class="ltext">'.$lang['category'].'</span>
                  </li>
                <!--<li>
                    <a href="category.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                        <i class="fas fa-shopping-cart"></i>
                    </a><span class="ltext">Категории</span>
                </li>!-->
                <li>
                    <a href="favourite.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                       <i class="fas fa-star"></i>
                    </a><span class="ltext">'.$lang['favourite'].'</span>
                </li>
                <li>
                    <a href="services.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                        <i class="fas fa-comments-dollar"></i>
                    </a><span class="ltext">'.$lang['services'].'</span>
                </li>
                <li>
                    <a href="vacancy.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                        <i class="fas fa-hand-holding-usd"></i>
                    </a><span class="ltext">'.$lang['vacancy'].'</span>
                </li>
                <li>
                    <a href="messages.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                        <i class="fas fa-comment-dots"></i></i>
                    </a><span class="ltext">'.$lang['msg'].'</span>
                </li>
                <li>
                    <a href="balance.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                        <i class="fas fa-wallet"></i>
                    </a><span class="ltext">'.$lang['balance'].'</span>
                </li>
                <li>
                    <a href="orders.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                        <i class="fas fa-shopping-basket"></i>
                    </a><span class="ltext">'.$lang['orders'].'</span>
                </li>
                <li>
                    <a href="profile.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                        <i class="fas fa-id-card"></i>
                    </a><span class="ltext">'.$lang['profile'].'</span>
                </li>
                <li>
                    <a href="settings.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                        <i class="fas fa-tools"></i>
                    </a><span class="ltext">'.$lang['settings'].'</span>
                </li>
                <li>
                    <a href="help.php"><span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                        <i class="fas fa-question"></i>
                    </a><span class="ltext">'.$lang['help'].'</span>
                </li></div>';
?>