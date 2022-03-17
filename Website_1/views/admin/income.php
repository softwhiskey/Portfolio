<?php
session_start();
if (!$_SESSION['admin']) {
    header('Location: ../../login.php');
}
require_once ("vendor/design/createnav.php");
require_once ("../../app/include/database.php");
require_once ("../../app/include/api.php");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Income</title>
    <link href="style.css" rel="stylesheet">
    <script src="../../js_ext/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="nav">
    <?php createNav(); ?>
</div>
<div class="main">
    <h1>Income</h1>
    <?php
    echo "<p>".$_SESSION['messag'] . "</p>";
    unset($_SESSION['messag']);
    ?>
    <?php
    echo "<table><thead><tr><td>Type</td><td>Income</td></tr>";
    $sql = "SELECT * FROM income";
    $result = mysqli_query($link, $sql);
    $buyingincome = 0;
    $shopcreateincome = 0;
    while ($row = mysqli_fetch_array($result))
    {
        if ($row['type'] == 'order') $buyingincome += intval($row['satoshi']);
        else if ($row['type'] == 'shopcreate') $shopcreateincome += intval($row['satoshi']);
    }
    $total = $buyingincome + $shopcreateincome;
    echo "<tr><td>Покупки</td><td>$buyingincome рублей</td></tr>
        <tr><td>Создание шопа</td><td>$shopcreateincome рублей</td></tr>
        <tr><td>Total</td><td>$total рублей</td></tr>";
    echo ("</table></thead></form>");
    ?>
</div>
</body>
</html>
