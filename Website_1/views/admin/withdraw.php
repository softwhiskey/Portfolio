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
    <title>Withdraw</title>
    <link href="style.css" rel="stylesheet">
    <script src="../../js_ext/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="nav">
    <?php createNav(); ?>
</div>
<div class="main">
    <h1>Withdraw</h1>
    <?php
    echo "<p>".$_SESSION['messag'] . "</p>";
    unset($_SESSION['messag']);
    ?>
</div>
</body>
</html>
