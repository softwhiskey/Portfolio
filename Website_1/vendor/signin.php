<?php

    session_start();
    require_once '../app/include/database.php';
    
    $login = $_POST['login'];
    $password = md5($_POST['password']);
    $secret_name = $_POST['secret_name'];

    $check_user = mysqli_query($link, "SELECT * FROM `users` WHERE `login` = '$login'
 AND `password` = '$password' AND `secret_name` = '$secret_name'");
    if (mysqli_num_rows($check_user) > 0) {

        $user = mysqli_fetch_assoc($check_user);
        $_SESSION['user'] = [
            "id" => $user['id'],
            "login" => $user['login'],
        ];
        if(isset($_SESSION['user']))
        {
            $lang = mysqli_query($link, "SELECT * FROM `users` WHERE `login` = '$login'");
            $lang = mysqli_fetch_assoc($lang)['language'];
            $_SESSION['lang'] = $lang;
        }
        header('Location: ../main/index.php');

    } 
    else 
    {
        $_SESSION['message'] = 'Не верный логин или пароль';
        header('Location: ../login.php');
    }
?>
