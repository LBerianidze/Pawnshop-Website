<?php
	/**
	 * Created by PhpStorm.
	 * User: Luka
	 * Date: 23.10.2020
	 * Time: 2:45
	 */
	include_once 'check_auth.php';
	$phone = $_REQUEST['phone'];
	if(strlen($phone < 9 || strlen($phone>15)))
	{
		header('location: /settings?err=5');
	}
	universalUpdate('users', ['phone_number' => $phone], true, "`import_id`='$user_import_id'");
	header('location: /settings?err=6');
	exit();
