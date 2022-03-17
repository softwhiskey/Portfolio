<?php
    function formatstr($str)
    {
        $str = trim($str);
        $str = stripslashes($str);
        $str = htmlspecialchars($str);
        return $str;
    }
    function IsNullOrEmptyString($str)
    {
        return (!isset($str) || trim($str) === '');
    }
    function notFound()
    {
        echo "<h2>Страница не найдена</h2>";
        die();
    }
    function stars($star)
    {
        if ($star == 0)
        {
            return "<span style='padding-top: 7px' class=\"fa fa-star fa-xs notchecked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>";
        }
        else if ($star == 1)
        {
            return "<span style='padding-top: 7px' class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>";
        }
        else if ($star == 2)
        {
            return "<span style='padding-top: 7px' class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>";
        }
        else if ($star == 3)
        {
            return "<span style='padding-top: 7px' class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>";
        }
        else if ($star == 4)
        {
            return "<span style='padding-top: 7px' class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs notchecked\"></span>";
        }
        else if ($star == 5)
        {
            return "<span style='padding-top: 7px' class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>
                            <span class=\"fa fa-star fa-xs checked\"></span>";
        }
    }
    function userHasShop($userid)
    {
        global $link;
        $sql = "SELECT * FROM shops WHERE owner = $userid";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) > 0)
        {
            $result = mysqli_fetch_assoc($result);
            return $result['shopid'];
        }
        else return false;
    }
?>