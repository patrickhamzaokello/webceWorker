<?php
$caseNew = array();

$case_new_sql = mysqli_query($con, "SELECT id FROM  appointments WHERE status = 0 ORDER BY `appointments`.`date-created` DESC ");

while ($row = mysqli_fetch_array($case_new_sql)) {

    array_push($caseNew, $row['id']);

}
