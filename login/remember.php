<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/configs/db.php';
$hash = isset($_GET['hash']) ? $_GET['hash'] : '';
$pwdRequest = getUserRequest($hash);
if ($pwdRequest !== false && $pwdRequest->status == 1)
{
    $hash = $pwdRequest->request_hash;
}
else
{
    $pwdRequest = false;
    $hash = '';
}
$p = isset($_GET['p']) ? $_GET['p'] : -1;

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
                    if ($p == 1) echo 'Пароли не совпадают';
                    else if ($p == 2) echo 'Неверная ссылка';
                    echo '</span>';
                    ?>
                </div>
                <h1>Восстановление пароля</h1>
                <?php
                if ($pwdRequest != false)
                {
                    ?>
                    <form action="../actions/restore.php" method="post" class="col">
                        <label for="login" class="row input-login">
                            <i class="fa fa-user" aria-hidden="true"></i><span class="devider"></span><input type="password" placeholder="Новый пароль" id="newPassword" name="newPassword" required>
                        </label>
                        <label for="password" class="row input-login">
                            <i class="fa fa-unlock" aria-hidden="true"></i><span class="devider"></span><input type="password" placeholder="Повторите пароль" id="repeatPassword" name="repeatPassword" required></label>
                        <input type="text" id="hash" name="hash" value="<?php echo $hash ?>" hidden>
                        <button id="forgetButton" type="submit" style="margin-top: 5px">Изменить пароль</button>
                    </form>
                    <?php
                }
                else
                {
                    echo '<div class="auth-error f-20"><span>Неверная ссылка</span></div>';
                } ?>
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
