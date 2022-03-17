<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
<form action="" method="post">  
<div class="ing" style="text-align: center; ">
<p><img src="captcha/form.php?<?php echo session_name()?>=<?php echo session_id()?>" style:"width=70; height=50;">
</div>
<a><input type="text" name="keystring" style="display: block; margin: 0 auto;" size="5"><input type="submit" value="Войти" style="background-color: #1EA5A5; border: none; color: white;padding: 1px 25px; text-align: center; text-decoration: none; display: inline-block; font-size: 14px; display: block; margin: 7px auto; border-radius: 12px "></a>
</form>

<?php
if(count($_POST)>0)
{
        if (isset($_SESSION['captcha_keystring']) && strtolower($_SESSION['captcha_keystring']) == strtolower($_POST['keystring'])){
                header('Location: login.php');
        }
        else
        {
            header('Location: /');
        }
} 
unset($_SESSION['captcha_keystring']);
?>
