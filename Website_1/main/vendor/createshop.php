<?php
session_start();
if (!$_SESSION['user'])
{
    header('Location: ../login.php');
}
require_once '../../app/include/database.php';
require_once ('../../app/include/api.php');
require_once ('../../app/include/sec.php');
$shopname = strip_tags(mysqli_real_escape_string($link, $_POST['shopname']));
$shopdesc = strip_tags(mysqli_real_escape_string($link, $_POST['shopdesc']));
$about = strip_tags(mysqli_real_escape_string($link, $_POST['about']));
if (!IsNullOrEmptyString($shopdesc) and !IsNullOrEmptyString($shopname) and !IsNullOrEmptyString($about))
{
    $errors= array();
    if (isset($_FILES['image']))
    {
        $uploads_dir = '../shop/verification/img/';
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $tmp = explode('.', $_FILES['image']['name']);
        $file_ext=strtolower(end($tmp));

        $extensions= array("jpeg","jpg","png");

        if (in_array($file_ext, $extensions) === false)
        {
            $errors[]="Файл с данным расширением не поддерживается. Выберите jpeg/jpg/png";
        }

        if ($file_size > 2097152)
        {
            $errors[]='Файл не может превышать 2МБ';
        }

        if (empty($errors))
        {
            $sql = "SELECT * FROM shops WHERE name = \"$shopname\"";
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) == 0)
            {
                $userid = $_SESSION['user']['id'];
                $sql = "SELECT * FROM shops WHERE owner = $userid";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) == 0)
                {
                    $sql = "SELECT * FROM shopaccept WHERE user_id = $userid";
                    $result = mysqli_query($link, $sql);
                    if (mysqli_num_rows($result) == 0)
                    {
                        $sql = "SELECT satoshi FROM users WHERE id = $userid";
                        $result = mysqli_query($link, $sql);
                        $result = mysqli_fetch_assoc($result);
                        $satoshi = intval($result['rub']);
                        $sql = "SELECT price FROM prices WHERE id = 1";
                        $result = mysqli_query($link, $sql);
                        $result = mysqli_fetch_assoc($result);
                        $spcreateprice = intval($result['price']);
                        if ($satoshi >= $spcreateprice)
                        {
                            $satoshi -= $spcreateprice;
                            $sql = "UPDATE users SET satoshi = $satoshi WHERE id = $userid";
                            if (mysqli_query($link, $sql))
                            {
                                $newfilename = round(microtime(true)) . rand(111, 999) . '.' . end($tmp);
                                move_uploaded_file($file_tmp, $uploads_dir . $newfilename);
                                $sql = "INSERT INTO shopaccept VALUES (DEFAULT, $userid, \"$shopname\", \"$shopdesc\", \"$newfilename\", \"$about\")";
                                mysqli_query($link, $sql);
                                $sql = "SELECT value FROM extra WHERE identifier = 'adminshop'";
                                $result = mysqli_query($link, $sql);
                                $result = mysqli_fetch_assoc($result);
                                $adminshopid = $result['value'];
                                //$_SESSION['message'] = $adminshopid;
                                $adminshopid = intval($adminshopid);
                                $sql = "INSERT INTO messages VALUES (DEFAULT, $userid, $adminshopid, \"Вы подали заявку на создание магазина. Ожидайте ответ администрации.\",
                                DEFAULT, 0)";
                                mysqli_query($link, $sql);
                                $sql = "INSERT INTO income VALUES(DEFAULT, $spcreateprice, 'order')";
                                mysqli_query($link, $sql);
                                $_SESSION['message'] = 'Успешно';
                            }
                        }
                        else
                        {
                            $_SESSION['message'] = 'У вас недостаточно денег для создания магазина. Пополните счет и повторите операцию';
                        }
                    }
                    else
                    {
                        $_SESSION['message'] = 'Ваша заявка находится на рассмотрении';
                    }
                }
                else
                {
                    $_SESSION['message'] = 'У вас уже есть магазин';
                }
            }
            else
            {
                $_SESSION['message'] = 'Магазин с таким названием уже существует';
            }
        }
        else
        {
            $_SESSION['message'] = $errors;
        }
    }
    else
    {
        $errors[] = "Выберите аватар магазина";
        $_SESSION['message'] = $errors;
    }
}
else
{
    $_SESSION['message'] = 'Заполните все поля';
}
header("Location: ../createshop.php");
?>