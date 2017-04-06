<?php
/**
 * Created by PhpStorm.
 * User: ilaevsin
 * Date: 03.04.17
 * Time: 21:29
 */

require_once 'config.php';

class Database
{
    public static function sqlQueryWithResult($sql)
    {

        $connect = mysqli_connect(HOST, USER, PASSWORD, DB, PORT) or die("Error " . mysqli_connect_error());

        $request = mysqli_query($connect, $sql) or die("Error in selecting " . mysqli_error($connect));

        $dataArray = array();

        while ($row = mysqli_fetch_assoc($request)) {

            $dataArray[] = $row;
        }

        mysqli_close($connect);

        return $dataArray;
    }

    public static function sqlQuery($sql)
    {

        $connect = mysqli_connect(HOST, USER, PASSWORD, DB, PORT) or die("Error " . mysqli_connect_error());

        $request = mysqli_query($connect, $sql) or die("Error in selecting " . mysqli_error($connect));

        $last_id = mysqli_insert_id($connect);

        mysqli_close($connect);

        return $last_id;
    }

    public static function multi($sql) {
        $mysqli = new mysqli(HOST, USER, PASSWORD, DB, PORT);
        $data = array();

        if ($mysqli->connect_errno) {
            echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        if (!$mysqli->multi_query($sql)) {
            echo "Не удалось выполнить мультизапрос: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        do {
            if ($res = $mysqli->store_result()) {
                $data[] = $res->fetch_all(MYSQLI_ASSOC);
            }
        } while ($mysqli->more_results() && $mysqli->next_result());
        return $data;
    }
}

?>