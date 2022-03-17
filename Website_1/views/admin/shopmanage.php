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
    <title>Shop Manage</title>
    <link href="style.css" rel="stylesheet">
    <script src="../../js_ext/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="nav">
    <?php createNav(); ?>
</div>
<div class="main">
    <h1>Shop Manage</h1>
    <?php
    echo "<p>".$_SESSION['messag'] . "</p>";
    unset($_SESSION['messag']);
    echo "<form id='sbm' method='post' action='vendor/changeshop.php'><input hidden id='indx' name='indx' value=''>
    <table>
        <thead>
            <tr>
                <td>ID</td><td>Name</td><td>Owner ID</td><td>Image</td><td>Deals</td><td>Satoshi</td><td>About</td>
           </tr>";
    $page = 1;
    if(!empty($_GET['page'])) $page = $_GET['page'];
    $page-=1;
    $limit = 20;
    $offset = $page * 20;
    $sql = "SELECT * FROM shops LIMIT $limit OFFSET $offset";
    $result = mysqli_query($link, $sql);
    $ind = 0;
    while ($row = mysqli_fetch_array($result))
    {
        $index = $row['shopid'];
        $name = $row['name'];
        $owner = $row['owner'];
        $img = $row['img'];
        $deals = $row['deals'];
        $satoshi = $row['satoshi'];
        $about = $row['about'];
        echo "<tr><td>$index</td><input hidden name='index[]' value='$index'>
            <td><input name='name[]' value='$name'></td><td><input name='owner[]' value='$owner'></td><td><input name='img[]'
             value='$img'></td><td><input name='deals[]' value='$deals'></td><td><input name='satoshi[]' value='$satoshi'></td>
             <td><input name='about[]' value='$about'></td>
             <td><input onclick='completeAndRedirect($ind)' type='submit'></td></tr>";
        $ind++;
    }
    echo "</table></thead></form>";
    echo "<script>
              function completeAndRedirect(x)
              {
                  x = parseInt(x);
                  $(\"#indx\").attr('value', x);
                  $(\"#sbm\").submit();         
              }
         </script>";
    ?>
</div>
</body>
</html>
