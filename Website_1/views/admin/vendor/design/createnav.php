<?php
function createNav()
{
    echo "<ul>
                <a href=\"index.php\"><li>Home</li></a>
                <a href=\"prices.php\"><li>Prices</li></a>
                <a href=\"usersmanage.php?page=1\"><li>Users Manage</li></a>
                <a href=\"shopvalidation.php\"><li>Shop Validation</li></a>
                <a href=\"income.php\"><li>Income</li></a>
                <a href=\"transactions.php?page=1\"><li>Transactions</li></a>
                <a href=\"userdm.php\"><li>User DM</li></a>
                <a href=\"shopmanage.php?page=1\"><li>Shop Manage</li></a>
                <a href=\"postmanage.php?page=1\"><li>Post Manage</li></a>
                <a href=\"admindm.php?page=1\"><li>Admin DM</li></a>
                <a href=\"withdraw.php\"><li>Withdraw</li></a>
                <a href=\"#\"><li>Logout</li></a>
            </ul>";
}
?>