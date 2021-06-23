<?php
	/**
	 * Created by PhpStorm.
	 * User: Luka
	 * Date: 06.11.2020
	 * Time: 13:07
	 */
	require_once $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php';
	function sendMail($to,$title, $email_html_content)
	{
		$host = "smtp.beget.com";
		$username = "support@lombard-2020.ru";
		$password = "6rvY&wNi";
		$port = "2525";
		$email_from = "support@lombard-2020.ru";
		$email_address = "support0@lombard-2020.ru";
		
		$headers = array('From' => $email_from, 'To' => $to, 'Reply-To' => $email_address);
		$smtp = Mail::factory('smtp', array(
			'host'     => $host,
			'port'     => $port,
			'auth'     => true,
			'username' => $username,
			'password' => $password
		));
		$mime = new Mail_mime("\r\n");
		$mime->setHTMLBody($email_html_content);
		$headers = $mime->headers($headers);
		$headers['Content-Type'] = 'text/html; charset=UTF-8';
		$headers['Subject'] = $title;
		$mail = $smtp->send($to, $headers, $mime->get());
		
		if (PEAR::isError($mail))
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}