<?php
	/**
	 * Created by PhpStorm.
	 * User: Luka
	 * Date: 26.10.2020
	 * Time: 22:26
	 */
	include_once $_SERVER['DOCUMENT_ROOT'] . '/configs/db.php';
	require_once 'email.php';
	if (!isset($_GET['key']))
	{
		exit("Отсутствует ключ в запросе");
	}
	$hash = $_GET['key'];
	$pwdRequest = getUserRequest($hash);
	if ($pwdRequest === false || $pwdRequest->status == 2)
	{
		exit("Запрос уже был активирован");
	}
	$user = universalSelect('users',"id='$pwdRequest->user_id'");
	universalUpdate('pwd_restore_requests', ['status' => 1], true, "request_hash='$hash'");
	$userfullname = mb_convert_case($user->name, MB_CASE_TITLE, "UTF-8");
	$html = "<html><body><p>Здравствуйте $userfullname!</p><p>От Вас был получен запрос на восстановление пароля</p>Нажмите на ссылку ниже для изменения пароля <a href='https://kabinet.lombard-2020.ru/login/remember.php?hash=$hash''>Активировать</a></body></html>";
	sendMail($user->email,"Запрос на восстановление пароля",$html);
	echo 'ok';
