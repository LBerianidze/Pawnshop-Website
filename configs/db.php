<?php
include_once 'config.php';
try
{
    $db_con = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpassword);
    $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_con->exec("set names utf8");
} catch (PDOException $e)
{
    file_put_contents('db_error.txt', date('Y-m-d H:i:s') . $e->getMessage() . $e->getTraceAsString());
}
function generatePassword($length = 8)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++)
    {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}

function getUser($login)
{
    global $db_con;
    $request = $db_con->prepare('select * from `users` where `login`=:param1');
    $request->execute(array('param1' => $login));
    $result = $request->fetch(PDO::FETCH_OBJ);
    return $result;
}

function getUserTickets($id)
{
    global $db_con;
    $request = $db_con->prepare('    SELECT * FROM `tickets` WHERE `user_id`=:param1');
    $request->execute(array('param1' => $id));
    $result = $request->fetchAll(PDO::FETCH_OBJ);
    return $result;
}

function getUserTicket($id, $ticketid)
{
    global $db_con;
    $request = $db_con->prepare('    SELECT * FROM `tickets` WHERE `user_id`=:param1 and `ticket_id`=:param2');
    $request->execute(array('param1' => $id, 'param2' => $ticketid));
    $result = $request->fetch(PDO::FETCH_OBJ);
    return $result;
}

function getTickets()
{
    global $db_con;
    $request = $db_con->prepare('SELECT * FROM `tickets`');
    $request->execute(array());
    $result = $request->fetchAll(PDO::FETCH_OBJ);
    return $result;
}
function getTable($table, $fields = '*')
{
    global $db_con;
    $request = $db_con->prepare("SELECT $fields FROM `$table`");
    $request->execute(array());
    $result = $request->fetchAll(PDO::FETCH_OBJ);
    return $result;
}
function truncateTable($table)
{
    global $db_con;
    $request = $db_con->prepare("truncate table `$table`");
    $request->execute();
}
function addUser($importid, $login, $passwd, $name, $email, $has_card, $privileges = 0)
{
    global $db_con;
    $request = $db_con->prepare('INSERT INTO `users`(`import_id`, `login`, `passwd`, `email`, `reg_time`, `privileges`,`name`,`has_card`)
                                          VALUES (:param1,:param2,:param3,:param4,:param5,:param6,:param7,:param8)');
    $request->execute(array(
        'param1' => $importid,
        'param2' => $login,
        'param3' => $passwd,
        'param4' => $email,
        'param5' => (new DateTime('now', new DateTimeZone('+5')))->format('Y-m-d h:i:s'),
        'param6' => $privileges,
        'param7' => $name,
        'param8' => $has_card,
    ));
    return true;
}

function addPayment($user_id, $ticket_id, $order_number, $token, $amount, $type, $info)
{
    global $db_con;
    $request = $db_con->prepare('INSERT INTO `payments`(`user_id`, `ticket_id`, `order_number`, `token`, `amount`, `create_date`,`type`,`info`)
                                          VALUES (:param1,:param2,:param3,:param4,:param5,:param6,:param7,:param8)');
    $request->execute(array(
        'param1' => $user_id,
        'param2' => $ticket_id,
        'param3' => $order_number,
        'param4' => $token,
        'param5' => $amount,
        'param6' => (new DateTime('now', new DateTimeZone('+5')))->format('Y-m-d H:i:s'),
        'param7' => $type,
        'param8' => $info
    ));
    return true;
}
function addInAllTickets($ticket_id, $user_id)
{
    global $db_con;
    $request = $db_con->prepare('INSERT INTO `all_tickets`(`ticket_id`, `add_date`,`user_id`) VALUES (:param1,:param2,:param3)');
    $request->execute(array(
        'param1' => $ticket_id,
        'param2' => (new DateTime('now', new DateTimeZone('+5')))->format('Y-m-d h:i:s'),
        'param3' => $user_id
    ));
    return true;
}
function addTicket($ticket_id, $user_id, $return_date, $realization_date, $loan_sum, $percent_sum, $selection_sum, $items, $last_operation_date)
{
    global $db_con;
    $request = $db_con->prepare('INSERT INTO `tickets`(`ticket_id`, `user_id`, `return_date`, `realization_date`, `loan_sum`, `percent_sum`, `available`, `items`,`last_operation_date`)
                                        VALUES (:param1,:param2,:param3,:param4,:param5,:param6,:param7,:param8,:param9)');
    $request->execute(array(
        'param1' => $ticket_id,
        'param2' => $user_id,
        'param3' => $return_date,
        'param4' => $realization_date,
        'param5' => $loan_sum,
        'param6' => $percent_sum,
        'param7' => $selection_sum,
        'param8' => $items,
        'param9' => $last_operation_date
    ));
    return true;
}

function getUserByImportID($importid)
{
    global $db_con;
    $request = $db_con->prepare('select * from `users` where `import_id`=:param1');
    $request->execute(array('param1' => $importid));
    $result = $request->fetch(PDO::FETCH_OBJ);
    return $result;
}

function getUserByEmail($email)
{
    global $db_con;
    $request = $db_con->prepare('select * from `users` where `email`=:param1');
    $request->execute(array('param1' => $email));
    $result = $request->fetch(PDO::FETCH_OBJ);
    return $result;
}

function addPasswordRememberRequest($userid, $hash)
{
    global $db_con;
    $request = $db_con->prepare('INSERT INTO `pwd_restore_requests`(`user_id`, `request_date`, `request_hash`, `status`) VALUES (:param1,:param2,:param3,:param4)');
    $request->execute(array(
        'param1' => $userid,
        'param2' => (new DateTime('now', new DateTimeZone('+5')))->format('Y-m-d h:i:s'),
        'param3' => $hash,
        'param4' => 0
    ));
    return $request->rowCount();
}
function updateTicket($ticket_id, $return_date, $realization_date, $loan_sum, $percent_sum, $available, $items, $last_operation_date, $payed)
{
    global $db_con;
    $request = $db_con->prepare('UPDATE `tickets` SET `return_date`=?, `realization_date`=?,`loan_sum`=?,`percent_sum`=?,`available`=?,`items`=?,`payed`=?,`last_operation_date`=? WHERE `ticket_id`=?');
    $request->execute(array($return_date, $realization_date, $loan_sum, $percent_sum, $available, $items, $payed, $last_operation_date, $ticket_id));
    return $request->rowCount();
}
function updateUsersRememberRequests($userid, $status)
{
    global $db_con;
    $request = $db_con->prepare('UPDATE `pwd_restore_requests` SET `status`=:param2 WHERE `user_id`=:param1');
    $request->execute(array('param1' => $userid, 'param2' => $status));
    return $request->rowCount();
}

function updateRememberRequestStatus($hash, $status)
{
    global $db_con;
    $request = $db_con->prepare('UPDATE `pwd_restore_requests` SET `status`=:param2 WHERE `request_hash`=:param1');
    $request->execute(array('param1' => $hash, 'param2' => $status));
    return $request->rowCount();
}

function getUserRequest($hash)
{
    global $db_con;
    $request = $db_con->prepare('select * from `pwd_restore_requests` where `request_hash`=:param1');
    $request->execute(array('param1' => $hash));
    $result = $request->fetch(PDO::FETCH_OBJ);
    return $result;
}

function updatePassword($userid, $password)
{
    global $db_con;
    $request = $db_con->prepare('UPDATE `users` SET `passwd`=:param2 WHERE `id`=:param1');
    $request->execute(array('param1' => $userid, 'param2' => $password));
    return $request->rowCount();
}
function getOrderById($payment_id)
{
    global $db_con;
    $request = $db_con->prepare('select * from `payments` where `order_number`=:param1 limit 1');
    $request->execute(array('param1' => $payment_id));
    $result = $request->fetch(PDO::FETCH_OBJ);
    return $result;
}
function universalUpdate($table, $params, $protect, $where = '1')
{
    global $db_con;
    $statement = "update `$table` set $1 where " . $where;
    $set = '';
    $protect = $protect ? "'" : '';
    foreach ($params as $key => $value)
    {
        $set .= "`$key`=$protect$value$protect,";
    }
    $statement = str_replace('$1', substr($set, 0, -1), $statement);
    $request = $db_con->prepare($statement);
    try
    {
        $result = $request->execute();
    } catch (PDOException $e)
    {
        var_dump($e);
    }
}
function selectAll($table, $fields, $where = '')
{
    global $db_con;
    $statement = "select $fields from `$table` " . $where;
    $request = $db_con->prepare($statement);
    try
    {
        $request->execute();
        return $request->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e)
    {
    }
}
function universalSelect($table, $where = '1')
{
    global $db_con;
    $statement = "select * from `$table` where " . $where;
    $request = $db_con->prepare($statement);
    try
    {
        $result = $request->execute();
        return $request->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e)
    {
    }
}