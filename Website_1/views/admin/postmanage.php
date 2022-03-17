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
    echo "<form id='sbm' method='post' action='vendor/changepost.php'><input hidden id='indx' name='indx' value=''><input hidden id='indd' name='indd' value=''>
    <table>
        <thead>
            <tr>
                <td>ID</td><td>Title</td><td>Price</td><td>Remain</td><td>Content</td><td>Description</td><td>Category ID</td>
           </tr>";
    $page = 1;
    if(!empty($_GET['page'])) $page = $_GET['page'];
    $page-=1;
    $limit = 20;
    $offset = $page * 20;
    $sql = "SELECT * FROM posts LIMIT $limit OFFSET $offset";
    $result = mysqli_query($link, $sql);
    $ind = 0;
    while ($row = mysqli_fetch_array($result))
    {
        $index = $row['id'];
        $title = $row['title'];
        $price = $row['price'];
        $remain = $row['remain'];
        $content = $row['content'];
        $description = $row['description'];
        $category_id = $row['category_id'];
        echo "<tr><td>$index</td><input hidden name='index[]' value='$index'>
            <td><input name='title[]' value='$title'></td><td><input name='price[]' value='$price'></td><td><input name='remain[]' value='$remain'></td>
             <td><input name='content[]' value='$content'></td><td><input name='description[]' value='$description'></td>
             <td><input name='category_id[]' value='$category_id'></td>
             <td><input onclick='completeAndRedirect($ind)' type='submit'></td><td><input onclick='completeAndRedirect($ind, 1)' type='submit' value='Delete'></td></tr>";
        $ind++;
    }
    echo "</table></thead></form>";
    echo "<script>
              function completeAndRedirect(x, del)
              {
                  x = parseInt(x);
                  $(\"#indx\").attr('value', x);
                  if(del == 1) $(\"#indd\").attr('value', 1);
                  $(\"#sbm\").submit();         
              }
         </script>";
    ?>
</div>
</body>
</html>
