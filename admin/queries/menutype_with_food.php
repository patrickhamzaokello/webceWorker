<?php

$menuTypesIds_withfood = array();
$menuTypes_withfood_sql = mysqli_query($con, "SELECT DISTINCT(`menu_type_id`) as id FROM `tblmenu` ORDER BY  `tblmenu`.`menu_type_id` ASC ");

while ($row = mysqli_fetch_array($menuTypes_withfood_sql)) {

    array_push($menuTypesIds_withfood, $row['id']);

}



