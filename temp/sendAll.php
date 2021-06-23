<?php
	/**
	 * Created by PhpStorm.
	 * User: Luka
	 * Date: 17.11.2020
	 * Time: 11:05
	 */
	include 'configs/db.php';
	include 'actions/email.php';
	$users = getTable('users');
	header('Content-Type: application/json; charset=UTF-8');
	
	foreach ($users as $user)
	{
		$email = $user->email;
		$password = generatePassword(8);
		$hash = md5('kqcbj+J+vL9BRfeCVr39' . $user->passwd . '.2pH#)Vr.A2Rht6QlTV5');
		
		//$userfullname = mb_convert_case($user->name, MB_CASE_TITLE, "UTF-8");
		//$html = "<html><body><h3>Здравствуйте $userfullname!</h3><p>Вы были автоматически зарегистрированы в личном кабинете ломбарда \"Желудь\".</p><p>Для использования личного кабинета Вы должны использовать следующие данные:</p><ul><li>Логин: $email</li><li>Пароль: $password</li></ul><a href='https://kabinet.lombard-2020.ru/''>Перейти в личный кабинет</a></body></html>";
		//updatePassword($user->id,$hash);
		//usleep(200);
		//echo sendMail($email,"Регистрация в системе \"Желудь\"",$html).$email."<br/>";
	}