<?php
include_once 'configs/config.php';
try
{
    $db_con = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpassword);
    $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_con->exec("set names utf8");
} catch (PDOException $e)
{
}
function selectRows($table, $columns, $where = null, $result_style = PDO::FETCH_OBJ, $return_single = false)
{
    global $db_con;
    $sql = "SELECT ";
    $sql .= $columns == '*' ? '*' : '`' . implode('`,`', $columns) . '`';
    $sql .= " FROM $table";
    $execute_parameters = [];
    if ($where != null)
    {
        $sql .= ' WHERE ';
        $first = true;
        foreach ($where as $key => $item)
        {
            if ($key == '=' || $key == '>' || $key == '<')
            {
                foreach ($item as $column => $value)
                {
                    if (!$first)
                    {
                        $sql .= ' AND ';
                    }
                    $sql .= "`$column`$key?";
                    $execute_parameters[] = $value;
                    $first = false;
                }
            }
        }
    }
    if ($return_single)
    {
        $sql .= ' LIMIT 1';
    }
    $request = $db_con->prepare($sql);
    $request->execute($execute_parameters);
    if ($return_single)
    {
        $result = $request->fetch($result_style);
    }
    else
    {
        $result = $request->fetchAll($result_style);
    }
    return $result;
}

$result = selectRows('users', ['id', 'import_id', 'login'], ['=' => ['has_card' => '1'], '>' => ['last_auth_time' => '2020-10-27 13:39:46']], PDO::FETCH_OBJ, false);
foreach ($result as $item)
{
    var_dump($item);
    echo "<br/>";
}

