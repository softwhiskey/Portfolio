<?php

    session_start();
    require_once '../app/include/database.php';

    $full_name = $_POST['full_name'];    
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $secret_name = $_POST['secret_name'];
    if(empty($full_name))
    {
        $_SESSION['message'] = 'Введите имя пользователя';
        header('Location: ../views/register/register.php');
        die();
    }
    else if (empty($login))
    {
        $_SESSION['message'] = 'Введите логин';
        header('Location: ../views/register/register.php');
        die();
    }
    else if ( empty($password_confirm))
    {
        $_SESSION['message'] = 'Пароли не совпадают';
        header('Location: ../views/register/register.php');
        die();
    }
    else if (empty($secret_name))
    {
        $_SESSION['message'] = 'Введите секретное слово';
        header('Location: ../views/register/register.php');
        die();
    }
    //тут проверка на длину полей
    if (strlen($full_name) < 8 || strlen($login) > 20)
    {
        $_SESSION['message'] = 'Длина имени пользователи должна быть не менее 8 символов и не более 20 символов';
        header('Location: ../views/register/register.php');
        die();
    }
    else if (strlen($login) < 8 || strlen($login) > 20)
    {
        $_SESSION['message'] = 'Длина логина должна быть не менее 8 символов и не более 20 символов';
        header('Location: ../views/register/register.php');
        die();
    }
    else if (strlen($password) < 8 || strlen($password) > 32)
    {
        $_SESSION['message'] = 'Длина пароля должна быть не менее 8 символов и не более 32 символов';
        header('Location: ../views/register/register.php');
        die();
    }
    else if (strlen($secret_name) < 8 || strlen($secret_name) > 20)
    {
        $_SESSION['message'] = 'Длина секретного слова должна быть не менее 4 символов и не более 20 символов';
        header('Location: ../views/register/register.php');
        die();
    }

    if ($password === $password_confirm)
    {
        $query="SELECT login FROM users WHERE login = '$login'";
        $results = mysqli_query($link, $query)
            or die(mysqli_error());

        if (mysqli_num_rows($results)>0)
        {
            $_SESSION['message'] = 'Логин занят';
            header('Location: ../views/register/register.php');
            die();
        }
        $password = md5($password);
        //btc address
        mysqli_query($link, "INSERT INTO `users` (`id`, `full_name`, `login`, `password`, `secret_name`, `rub`,
      `language`, `register`, `transaction`, `banned`) 
        VALUES (DEFAULT, '$full_name', '$login', '$password', '$secret_name', 0, 'ru', DEFAULT, 0, 0);");
        $_SESSION['message'] = 'Регистрация прошла успешно!';
        header('Location: ../login.php');
    }
    else
    {
        $_SESSION['message'] = 'Пароли не совпадают';
        header('Location: ../views/register/register.php');
    }

?>
