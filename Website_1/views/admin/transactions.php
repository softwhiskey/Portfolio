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
    <title>Transactions</title>
    <link href="style.css" rel="stylesheet">
    <script src="../../js_ext/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="nav">
    <?php createNav(); ?>
</div>
<div class="main">
    <h1>Transactions</h1>
    <?php
    echo "<p>".$_SESSION['messag'] . "</p>";
    unset($_SESSION['messag']);
    ?>
    <?php
    echo "<table><thead><tr><td>User Id</td><td>Shop Id</td><td>Post ID</td><td>Post Name</td><td>Price</td><td>Date</td><td>Status</td></tr>";
    $page = 1;
    if(!empty($_GET['page'])) $page = $_GET['page'];
    $page-=1;
    $limit = 20;
    $offset = $page * 20;
    $sql = "SELECT * FROM orders LIMIT $limit OFFSET $offset";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_array($result))
    {
        $user_id = $row['user_id'];
        $shop_id = $row['shop_id'];
        $post_id = $row['post_id'];
        $price = convertToBTCFromSatoshi($row['price']);
        $post_name = $row['post_name'];
        $date = $row['date'];
        $status = $row['status'];
        echo "<tr><td>$user_id</td><td>$shop_id</td><td>$post_id</td><td>$post_name</td><td>$price</td><td>$date</td><td>$status</td></tr>";
    }
    echo ("</table></thead></form>");
    ?>
</div>
</body>
</html>
