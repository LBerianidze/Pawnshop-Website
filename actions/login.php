<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/configs/db.php';
	require_once 'email.php';
	$action = $_REQUEST['action'];
	if ($action == '1')
	{
		$login = $_REQUEST['login'];
		$password = $_REQUEST['password'];
		$user = getUser($login);
		if ($user !== false)
		{
			$password = md5('kqcbj+J+vL9BRfeCVr39' . $password . '.2pH#)Vr.A2Rht6QlTV5');
			if ($password == $user->passwd)
			{
				$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
				setcookie('usr', "$login&$password", time() + 3600, '/', $domain, false);
				header('Location: /applications/', true);
			}
			else
			{
				header('Location: /login/?p=1', true);
			}
		}
		else
		{
			header('Location: /login/?p=1', true);
		}
	}
	else if ($action == '2')
	{
		$admin_email = universalSelect('settings', 'param=\'admin_email\'')->value;
		$verify = universalSelect('settings', 'param=\'remember_verify\'')->value;
		$email = $_REQUEST['email'];
		$user = getUserByEmail($email);
		if ($user !== false)
		{
			$hash = md5('X.juY@WUgGbr#7snc2D5' . time() . $user->id . '.A_79/SjhQ)i-2Ll.3Ko');
			$us_phone = ($user->phone_number == null ? 'Не указан' : $user->phone_number);
			
			updateUsersRememberRequests($user->id, '-1');
			addPasswordRememberRequest($user->id, $hash);
			if ($verify == 1)
			{
				$html = "<html><body><p>Пользователь $user->name отправил запрос на восстановление пароля:</p><ul><li>Почта для связи: $user->email</li><li>Телефон для связи: $us_phone</li><li>Нажмите для активации запроса: <a href=\"https://kabinet.lombard-2020.ru/actions/activate_request.php?key=$hash\">Активировать</a></li></ul></body></html>";
				sendMail($admin_email, "Запрос на восстановление пароля", $html);
			}
			else
			{
				$html = "<html><body><p>Вы запросили восстановление пароля на сайте личного кабинета ломбарда \"Желудь\"</p>Для сброса пароля пожалуйста перейдите по ссылке: <a href=\"https://kabinet.lombard-2020.ru/login/remember.php?hash=$hash\">Активировать</a></body></html>";
				sendMail($user->email, "Запрос на восстановление пароля", $html);
				universalUpdate('pwd_restore_requests', ['status' => 1], true, "`request_hash`='$hash'");
			}
			header('Location: /login/?p=2', true);
		}
	}
