<?php
/**
 * Created by PhpStorm.
 * User: ilaevsin
 * Date: 06.04.17
 * Time: 22:16
 */

require_once 'database.php';

$photo_id = Database::sqlQueryWithResult("SELECT photo_id FROM AZavod.workers WHERE id = ". $_GET['id']);
Database::sqlQuery("DELETE FROM workers WHERE id = " . $_GET['id']);
Database::sqlQuery("DELETE FROM files WHERE id = " . $photo_id[0]['photo_id']);
header("Location: /");