<?php
$caseNew = array();

$case_new_sql = mysqli_query($con, "SELECT id FROM  cases WHERE status = 1 ORDER BY `cases`.`datecreated` DESC ");

while ($row = mysqli_fetch_array($case_new_sql)) {

    array_push($caseNew, $row['id']);

}
