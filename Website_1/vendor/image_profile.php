<?php

    session_start();
require_once '../app/include/database.php';

    $path = '../uploads/' . time() . $_FILES['avatar']['name'];
    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path)) {

    mysqli_query($link, "INSERT INTO `users`(`id`, `full_name`, `login`, `password`, `secret_name`, `avatar`, `type`) VALUES (null, null, null , null, null, '$path', null)");
}
?>
