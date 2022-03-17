<?php
    session_start();
    if (!$_SESSION['user'])
    {
        header('Location: ../login.php');
    }
    require_once '../../app/include/database.php';
    require_once ('../../app/include/sec.php');
    $m = strip_tags(mysqli_real_escape_string($link, $_POST['msg']));
    //$g = formatstr($_POST['s']);
    $g = mysqli_real_escape_string($link, $_POST['s']);

    $m = htmlspecialchars($m);
    if (!IsNullOrEmptyString($m) and !IsNullOrEmptyString($g))
    {
        $sql = "SELECT * FROM shops WHERE shopid = $g";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) == 0)
        {
            header("Location: ../messages.php");
        }
        $usrid = $_SESSION['user']['id'];
        //$dtt = date('m-d-Y h:i:s', time());
        $sql = "INSERT INTO `messages` (`id`, `user_id`, `shop_id`, `content`, `time`,
        `type`) 
        VALUES (DEFAULT, $usrid, $g, '$m', DEFAULT, 1)";
        mysqli_query($link, $sql);
        if ($sql)
        {
            $_SESSION['message'] = 'Сообщение отправлено';
        }
    }
    else
    {
        $_SESSION['message'] = 'Введите сообщение';
    }

    header("Location: ../message.php?id=". $g);
?>