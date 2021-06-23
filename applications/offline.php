<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/actions/check_auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- FAVICON -->

	<title>Сайт недоступен</title>
	<style>
		.not_available {
			margin: auto;
			font-size: 35px;
			color: white;
			display: table-cell;
			text-align: center;
			vertical-align: middle;
		}

		@media only screen and (max-width: 768px) {
			.not_available {
				font-size: 20px;
			}
		}

		html,
		body {
			height: 100%;
			width: 100%;
			overflow-x: hidden;
			overflow-y: hidden;
			display: table;
			margin: 0px;
		}

		body {
			background: scroll url(assets/img/bg-min.jpg) center/cover no-repeat;
		}
	</style>
</head>

<body>
<a class="not_available" href="/applications">Сайт будет доступен через несколько минут</a>
</body>
</html>
