<?php
$bannerIds = array();

$banneritems_sql = mysqli_query($con, "SELECT id FROM tblbanner  ORDER BY `tblbanner`.`datecreated` DESC ");

while ($row = mysqli_fetch_array($banneritems_sql)) {

    array_push($bannerIds, $row['id']);

}
