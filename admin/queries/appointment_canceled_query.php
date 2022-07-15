<?php
$appoint_new = array();

$appoint_new_new_sql = mysqli_query($con, "SELECT id FROM  appointments WHERE status = 3 ORDER BY `appointments`.`date-created` DESC ");

while ($row = mysqli_fetch_array($appoint_new_new_sql)) {

    array_push($appoint_new, $row['id']);

}
