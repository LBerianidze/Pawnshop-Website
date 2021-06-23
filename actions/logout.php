<?php
$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
setcookie('usr', '', time() - 1, '/', $domain, false);
header('Location: /login/index.php');