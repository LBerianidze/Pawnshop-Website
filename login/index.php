<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/actions/check_auth.php';
$p = -1;
if (isset($_GET['p']))
{
    $p = $_GET['p'];
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE">

    <link rel="stylesheet" href="assets/styles/css/normalize.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/css/style.css">

    <!-- FAVICON -->

    <title>Жёлудь - ломбард</title>
</head>

<body>

<main class="main">
    <div class="wrapper col">
        <div class="form-card col">
            <div class="form-card__header col">
                <div class="form-card__header-logo row">
                    <img src="assets/img/logo-min.png" alt="logo">
                </div>
            </div>
            <div class="form-card__body col">
                <div class="auth-error">
                    <?php
                    echo '<span>';
                    if ($p == 1) echo 'Неверный логин или пароль';
                    else if ($p == 2) echo 'Запрос успешно отправлен';
                    echo '</span>';
                    ?>
                </div>
                <h1>Авторизация</h1>
                <form action="../actions/login.php" method="post" class="col">
                    <label for="login" class="row input-login">
                        <i class="fa fa-user" aria-hidden="true"></i><span class="devider"></span><input type="text" placeholder="Логин" id="login" name="login" required>
                    </label>
                    <label for="password" class="row input-login">
                        <i class="fa fa-unlock" aria-hidden="true"></i><span class="devider"></span><input type="password" placeholder="Пароль" id="password" name="password" required></label>
                    <label for="email" class="row input-email">
                        <i class="fa fa-envelope" aria-hidden="true"></i><span class="devider"></span><input type="email" placeholder="Ваш e-mail" id="email" name="email"></label>
                    <a class="form-link forget-link" id="forgetLink" onclick="forgetPass()">Забыли пароль?</a>
                    <input type="text" id="action" name="action" value="1" hidden>
                    <button id="forgetButton" type="submit">Войти</button>
                    <label class="poli row">
                        <input type="checkbox" name="accept" onchange="document.getElementById('mc-embedded-subscribe').disabled = !this.checked" required> Я ознакомлен(-а) с <a href="/dokument/politika-PD.pdf" target="_blank">Политикой конфиденциальности</a> и Даю <a href="/dokument/Soglasie-na-obrabotku-PD.pdf" target="_blank">согласие на обработку персональных данных</a>
                    </label>
                    <a class="form-link remember-link" id="rememberLink" onclick="rememberPass()">Вспомнили пароль?</a>
                </form>
            </div>
        </div>

    </div>
</main>

<script src="assets/scripts/main.js"></script>
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(71357380, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/71357380" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
</body>

</html>
