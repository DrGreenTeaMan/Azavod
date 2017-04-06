
<?php
/**
 * Created by PhpStorm.
 * User: ilaevsin
 * Date: 06.04.17
 * Time: 18:41
 */

require_once 'database.php';

$post = $_POST;

$sql = "SELECT SQL_CALC_FOUND_ROWS workers.*, files.file_path FROM workers LEFT JOIN files ON files.id = workers.photo_id WHERE 1";

if ($post['name']) {
    $sql .= " AND workers.surname LIKE '%" . $post['name'] . "%'";
}

if ($post['m_chek']) {
    $sql .= " AND workers.gender = 'male'";
}

if ($post['fem_chek']) {
    $sql .= " AND workers.gender = 'female'";
}

$sql .= " LIMIT " . $post['skip'] . ", " . $post['limit'];

$res = Database::multi($sql . "; SELECT FOUND_ROWS() as count;");
$data = $res[0];
$count = $res[1][0];

$resultData = array();

if ($post['age_from'] && $post['age_to']) {
    foreach ($data as $datum) {
        $age = Database::sqlQueryWithResult("SELECT TIMESTAMPDIFF(YEAR, '" . $datum['date_birthday'] . "', NOW())");
        foreach ($age[0] as $item) {
            if ($item >= $post['age_from'] && $item <= $post['age_to']) {
                $resultData[] = $datum;
            }
        }
    }
    echo json_encode(array('data' => $resultData));
    exit();
}

if ($post['age_from']) {
    foreach ($data as $datum) {
        $age = Database::sqlQueryWithResult("SELECT TIMESTAMPDIFF(YEAR, '" . $datum['date_birthday'] . "', NOW())");
        foreach ($age[0] as $item) {
            if ($item >= $post['age_from']) {
                $resultData[] = $datum;
            }
        }
    }
    echo json_encode(array('data' => $resultData));
    exit();
}

if ($post['age_to']) {
    foreach ($data as $datum) {
        $age = Database::sqlQueryWithResult("SELECT TIMESTAMPDIFF(YEAR, '" . $datum['date_birthday'] . "', NOW())");
        foreach ($age[0] as $item) {
            if ($item <= $post['age_to']) {
                $resultData[] = $datum;
            }
        }
    }
    echo json_encode(array('data' => $resultData));
    exit();
}

echo json_encode(array('data' => $data, 'count' => $count['count']));