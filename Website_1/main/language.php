<?php
    session_start();
    require_once dirname(__FILE__) .'/../../app/include/database.php';

    if(!isset($_SESSION['lang']))
        $_SESSION['lang'] = "ru";
    else if (!isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang']))
    {
        if ($_GET['lang'] == "ru")
            $_SESSION['lang'] = "ru";
        else if ($_GET['lang'] == "en")
            $_SESSION['lang'] = "en";
        else if ($_GET['lang'] == "cz")
            $_SESSION['lang'] = "cz";
    }
    //include(dirname(__FILE__).'/c.php');
    require_once (dirname(__FILE__) .'/languages/' . $_SESSION['lang'] . ".php");
?>