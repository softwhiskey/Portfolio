<?php

    $link = mysqli_connect('localhost', 'admin', 'testpass', 'site');

    if (!$link) {
        die('Ошибка с соединением базы данных');
    }

