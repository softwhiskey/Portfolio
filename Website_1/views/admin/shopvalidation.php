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
    <title>Shop Validation</title>
    <link href="style.css" rel="stylesheet">
    <script src="../../js_ext/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="nav">
    <?php createNav(); ?>
</div>
<div class="main">
    <h1>Shop Validation</h1>
    <?php
    echo "<p>".$_SESSION['messag'] . "</p>";
    unset($_SESSION['messag']);
    echo "<form id='sbm' method='post' action='vendor/shopvalidate.php'><input hidden id='indx' name='indx' value=''>
    <input hidden id='typee' name='typee' value=''>
    <table>
        <thead>
            <tr>
                <td>ID</td><td>User Id</td><td>Shop Name</td><td>Shop Description</td><td>Image</td><td>Shop About</td>
           </tr>";
    $page = 1;
    if(!empty($_GET['page'])) $page = $_GET['page'];
    $page-=1;
    $limit = 20;
    $offset = $page * 20;
    $sql = "SELECT * FROM shopaccept LIMIT $limit OFFSET $offset";
    $result = mysqli_query($link, $sql);
    $ind = 0;
    while ($row = mysqli_fetch_array($result))
    {
        $index = $row['id'];
        $user_id = $row['user_id'];
        $shop_name = $row['shop_name'];
        $shop_desc = $row['shop_desc'];
        $shop_img = $row['shop_img'];
        $shop_about = $row['shop_about'];
        echo "<tr><td>$index</td><input hidden name='index[]' value='$index'>
            <td><input name='user_id[]' value='$user_id'></td><td><input name='shop_name[]' value='$shop_name'></td><td>
            <input name='shop_desc[]' value='$shop_desc'></td><td><input name='shop_img[]' value='$shop_img'><img width='300' height='300' 
            src='../../main/shop/verification/img/$shop_img' </td><td><input name='shop_about' value='$shop_about'>
             </td><td><input onclick='completeAndRedirect($ind, 1)'
             value='Accept' type='submit'></td><td><input onclick='completeAndRedirect($ind, 2)'
             value='Reject' type='submit'></td></tr>";
        $ind++;
    }
    echo ("</table></thead></form>");
    echo "<script>
              function completeAndRedirect(x, typee)
              {
                  x = parseInt(x);
                  $(\"#typee\").attr('value', typee);
                  $(\"#indx\").attr('value', x);
                  $(\"#sbm\").submit();         
              }
         </script>";
    ?>
</div>
</body>
</html>
