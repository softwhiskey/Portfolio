<?php
session_start();
if (!$_SESSION['admin']) {
    header('Location: ../../login.php');
}
require_once ("vendor/design/createnav.php");
require_once ("../../app/include/database.php");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Prices</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="nav">
    <?php createNav(); ?>
</div>
<div class="main">
    <h1>Prices</h1>
    <?php
    echo "<p>".$_SESSION['messag'] . "</p>";
    unset($_SESSION['messag']);
    echo "<form method='post' action='vendor/changeprices.php'><table><thead><tr><td>ID</td><td>Price</td><td>Comment</td></tr>";
    $sql = "SELECT * FROM prices";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_array($result))
    {
        $index = $row['id'];
        $price = $row['price'];
        $comment = $row['comment'];
        echo "<tr><td>$index</td></td><td><input hidden name='index[]' value='$index'>
            <input name='price[]' value='$price'></td><td><input type='submit'></td><td>$comment</td></tr>";
        $index++;
    }
    echo ("</table></thead></form>");
    ?>
</div>
</body>
</html>
