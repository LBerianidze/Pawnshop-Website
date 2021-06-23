<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/actions/check_auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<link rel="stylesheet" type="text/css" href="../pay/assets/styles/css/style.css"/>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/styles/css/style.css">

	<!-- FAVICON -->

	<title>Настройки</title>
</head>

<body>

<?php include '../assets/header.php' ?>

<main class="main">
	<div class="container">
		<div class="settings-item-container">
			<span class="settings-item-header">Смена пароля</span>
			<div class="settings-item-content">
				<form action="/actions/change_password.php" method="post">
					<div class="input-container">
						<label for="old-password">Старый пароль</label>
						<input type="password" name="old-password" id="old-password">
					</div>
					<span class="hint-span">Пароль должен быть длиной от 8 до 16 символов. Допустимые символы: a-z, A-Z, цифры</span>
					<div class="input-container">
						<label for="new-password">Новый пароль</label>
						<input type="password" name="new-password" id="new-password">
					</div>
					<div class="input-container">
						<label for="repeat-password">Повторите пароль</label>
						<input type="password" name="repeat-password" id="repeat-password">
					</div>
					<div class="input-container">
						<input type="submit" value="Изменить">
					</div>
					<span class="error">
						<?
							if(isset($_REQUEST['err']))
							{
								$error = $_REQUEST['err'];
								switch ($error)
								{
									case 1:
										echo 'Неверно введен старый пароль';
										break;
									case 2:
										echo 'Неверно введен повторный пароль';
										break;
									case 3:
										echo 'Пароль должен быть от 8 до 16 символов';
										break;
								}
							}
						?>
					</span>
					<span class="success">
						<?
							if(isset($_REQUEST['err']))
							{
								$error = $_REQUEST['err'];
								switch ($error)
								{
									case 4:
										echo 'Пароль успешно изменен';
										break;
								}
							}
						?>
					</span>
				</form>
			</div>
		</div>
		<!--<div class="settings-item-container">
			<span class="settings-item-header">Изменение номера телефона</span>
			<div class="settings-item-content">
				<form action="/actions/change_number.php" method="post">
					<div class="input-container">
						<label for="phone">Номер телефона</label>
						<input type="text" name="phone" id="phone" value="<?/*=$user->phone_number*/?>">
					</div>
					<div class="input-container">
						<input type="submit" value="Изменить">
					</div>
					<span class="error">
						<?/*
							if(isset($_REQUEST['err']))
							{
								$error = $_REQUEST['err'];
								switch ($error)
								{
									case 5:
										echo 'Неверная длина телефона';
										break;
								}
							}
						*/?>
					</span>
					<span class="success">
						<?/*
							if(isset($_REQUEST['err']))
							{
								$error = $_REQUEST['err'];
								switch ($error)
								{
									case 6:
										echo 'Телефон успешно изменен';
										break;
								}
							}
						*/?>
					</span>
				</form>
			</div>
		</div>-->
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
