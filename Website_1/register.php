<?php
    session_start();
    if ($_SESSION['user']) {
        header('Location: ../profile/profile.php');
    }
    include ('../../main/vendor/language.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <script src="../../js_ext/jquery-3.6.0.min.js"></script>
    <script src="../../js_ext/vbnrfg.js"></script>
</head>
<body>

    <!-- Форма регистрации -->
    <form action="../../vendor/signup.php" method="post">
        <label><?=$lang['fullname']?></label>
        <input id="full_name" type="text" name="full_name" placeholder="<?=$lang['fullname_enter']?>">
        <p id="full-name-text"></p>
        <label><?=$lang['login']?></label>
        <input id="login" type="text" name="login" placeholder="<?=$lang['login_enter']?>">
        <p id="login-text"></p>
        <label><?=$lang['password']?></label>
        <input id="password" type="password" name="password" placeholder="<?=$lang['password_enter']?>">
        <meter min= "0" max="4" value= "0" id="password-strength-meter"></meter>
        <p id="password-strength-text"></p>
        <label><?=$lang['confirm_password']?></label>
        <input id="password_confirm" type="password" name="password_confirm" placeholder="<?=$lang['confirm_password']?>">
        <p id="msg"></p>
        <label><?=$lang['secret']?></label>
        <input id="secret_name" type="password" name="secret_name" placeholder="<?=$lang['secret_enter']?>">
        <p id="secret-name-text"></p>
        <button id="submitbtn" disabled type="submit"><?=$lang['registerr']?></button>
        <script>
            var t1 = false;
            var t2 = false;
            var t3 = false;
            var t4 = false;
            var t5 = false;
            var strength = {
                0: "Очень слабый",
                1: "Слабый",
                2: "Средний",
                3: "Хороший",
                4: "Очень хороший"
            }
            /*0: \"Worst",
                1: \"Bad\",
                2: \"Weak\",
                3: \"Good\",
                4: \"Strong\"*/
            var password = document.getElementById('password');
            var meter = document.getElementById('password-strength-meter');
            var text = document.getElementById('password-strength-text');

            password.addEventListener('input', function() {
                var val = password.value;
                var result = zxcvbn(val);

                meter.value = result.score;
                if (meter.value > 2) t1 = true;
                else t1 = false;
                if (val !== "")
                {
                    text.innerHTML = "Сила пароля: " + strength[result.score];
                }
                else
                {
                    text.innerHTML = "";
                }
            });
            function checkpsw()
            {
                if ($("#password").val() != $("#password_confirm").val())
                {
                    t2 = false;
                    $("#msg").html("Пароли не совпадают").css("color","red");
                }
                else
                {
                    t2 = true;
                    $("#msg").html("Пароли совпадают").css("color","green");
                }
            }
            function checklength(type)
            {
                if ($("#full_name").val().length > 20 || $("#full_name").val().length < 8)
                {
                    if(type == 1)
                    {
                        t3 = false;
                        $("#full-name-text").html("Длина имени пользователя должна быть не менее 8 символов и не более 20 символов").css("color", "red");
                    }
                }
                else
                {
                    t3 = true;
                    $("#full-name-text").html("");
                }
                if ($("#login").val().length > 20 || $("#login").val().length < 8)
                {
                    if(type == 2)
                    {
                        t4 = false;
                        $("#login-text").html("Длина логина должна быть не менее 8 символов и не более 20 символов").css("color", "red")
                    }
                }
                else
                {
                    t4 = true;
                    $("#login-text").html("");
                }
                if ($("#secret_name").val().length > 20 || $("#secret_name").val().length < 8)
                {
                    if(type == 3)
                    {
                        t5 = false;
                        $("#secret-name-text").html("Длина секретного слова должна быть не менее 8 символов и не более 20 символов").css("color", "red");
                    }
                }
                else
                {
                    t5 = true;
                    $("#secret-name-text").html("");
                }
            }
            $(document).ready(function() {
                $("#password_confirm").keyup(function () {
                    checkpsw();
                });
                $("#password").keyup(function () {
                    checkpsw();
                });
                $("#full_name").keyup(function () {
                    checklength(1);
                });
                $("#login").keyup(function () {
                    checklength(2);
                });
                $("#secret_name").keyup(function () {
                    checklength(3);
                });
                $(document).keyup( function(event) {
                    if (t1 && t2 && t3 && t4 && t5)
                    {
                        $("#submitbtn").prop("disabled", false);
                    }
                    else $("#submitbtn").prop("disabled", true);
                });
            });
        </script>
        <p>
            <?=$lang['haveacc']?> - <a href="../../login.php"><?=$lang['auth']?></a>!
        </p>
        <?php
            if ($_SESSION['message']) {
                echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
            }
            unset($_SESSION['message']);
        ?>
    </form>
</body>
</html>
