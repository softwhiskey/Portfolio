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
    <title>Users Manage</title>
    <link href="style.css" rel="stylesheet">
    <script src="../../js_ext/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="nav">
    <?php createNav(); ?>
</div>
<div class="main">
    <h1>Users Manage</h1>
    <?php
    echo "<p>".$_SESSION['messag'] . "</p>";
    unset($_SESSION['messag']);
    echo "<form id='sbm' method='post' action='vendor/changeusers.php'><input hidden id='indx' name='indx' value=''>
    <table>
        <thead>
            <tr>
                <td>ID</td><td>Login</td><td>Full Name</td><td>Satoshi</td><td>Ban</td>
           </tr>";
    $page = 1;
    if(!empty($_GET['page'])) $page = $_GET['page'];
    $page-=1;
    $limit = 20;
    $offset = $page * 20;
    $sql = "SELECT * FROM users LIMIT $limit OFFSET $offset";
    $result = mysqli_query($link, $sql);
    $ind = 0;
    while ($row = mysqli_fetch_array($result))
    {
        $index = $row['id'];
        $login = $row['login'];
        $full_name = $row['full_name'];
        $satoshi = $row['rub'];
        $banned = $row['banned'];
        echo "<tr><td>$index</td><input hidden name='index[]' value='$index'>
            <td><input name='login[]' value='$login'></td><td><input name='full_name[]' value='$full_name'></td><td><input name='rub[]'
             value='$satoshi'></td><td><input name='banned[]' value='$banned'></td><td><input onclick='completeAndRedirect($ind)' type='submit'></td></tr>";
        $ind++;
    }
    echo ("</table></thead></form>");
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
