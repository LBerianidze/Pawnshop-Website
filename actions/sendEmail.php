<?php
/**
 * Created by PhpStorm.
 * User: Luka
 * Date: 23.10.2020
 * Time: 2:45
 */
require_once 'check_auth.php';
require_once 'email.php';
$text = $_REQUEST['email_text'];
$html = "<html><body><p>Пользователь $user->name отправил письмо:</p><ul><li>Почта пользователя: $user->email</li><li><b>Текст:</b> $text</li></ul></body></html>";
sendMail('zoloto-lk2020@mail.ru', "Письмо Желудю", $html);