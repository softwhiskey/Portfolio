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
    <title>Home</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="nav">
        <?php createNav(); ?>
    </div>
    <div class="main">
        <h1>Home</h1>
        <p>Время на сервере: <?php echo date("d/m/y-H:i:s",time())?></p>
        <?php
        echo "<p>".$_SESSION['messag'] . "</p>";
        unset($_SESSION['messag']);
        echo "<form method='post' action='vendor/changextra.php'><table><thead><tr><td>ID</td><td>Identifier</td><td>Value</td></tr>";
        $sql = "SELECT * FROM extra";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_array($result))
        {
            $index = $row['id'];
            $identifier = $row['identifier'];
            $value = $row['value'];
            echo "<tr><td>$index</td></td><td>$identifier</td><td><input hidden name='index[]' value='$index'>
            <input name='value[]' value='$value'></td><td><input type='submit'></td></tr>";
            $index++;
        }
        echo ("</table></thead></form>");
        ?>
    </div>
</body>
</html>
