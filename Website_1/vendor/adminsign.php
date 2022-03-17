<?php

    session_start();
    require_once '../app/include/database.php';
    
    $login = htmlspecialchars(mysqli_real_escape_string($link, $_POST['login']));
    $password = md5($_POST['password']);
    $hash = md5($_POST['hash']);

    $check_user = mysqli_query($link, "SELECT * FROM `admin` WHERE `login` = '$login' AND `password` = '$password' AND `hash` = '$hash'");
    if (mysqli_num_rows($check_user) > 0)
    {

        $user = mysqli_fetch_assoc($check_user);

        $_SESSION['admin'] = [
            "id" => $user['id'],
            "login" => $user['login']
        ];
        header('Location: ../views/admin/index.php');
    }
    else
    {
        header('Location: ../admin.php');
    }
?>
 
