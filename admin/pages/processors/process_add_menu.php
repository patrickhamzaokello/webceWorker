<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

$errors = [];
$data = [];

$target_dir  = '../assets/menu/';
$db_target_dir  = 'assets/menu/';

if (isset($_POST['order_action'])) {

  $order_action = $_POST['order_action'];

  
  if ($order_action == 1) {
    if (isset($_POST['banner_name'])&& isset($_POST['banner_number']) && isset($_POST['category_id'])&& isset($_POST['menu_descritption']) && isset($_POST['menu_ingredients'])) {

      $name = $_POST['banner_name'];
      $banner_number = $_POST['banner_number'];
      $category_id = $_POST['category_id'];
      $menu_descritption = $_POST['menu_descritption'];
      $menu_ingredients = $_POST['menu_ingredients'];


      // generating image name
      $formatedname = strip_tags($name);
      $formatedname = str_replace(" ", "_", $formatedname);

      $temp = explode(".", $_FILES["inputfile"]["name"]);

      // setting image new file name
      $postfix = '_' . date('YmdHis') . '_' . str_pad(rand(1, 10000), 5, '0', STR_PAD_LEFT);
      $newfilename = stripslashes($formatedname . '_menuItem') . $postfix . '.' . end($temp);

      $targetPath = $target_dir . basename($newfilename);
      $db_targetPath = $db_target_dir . basename($newfilename);

      if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $targetPath)) {
        $query = mysqli_query($con, "INSERT INTO `tblmenu`(`menu_name`, `price`, `description`, `menu_type_id`, `menu_image`, `backgroundImage`, `ingredients`)VALUES('$name',$banner_number,'$menu_descritption',$category_id,'$db_targetPath','$db_targetPath','$menu_ingredients')");

        $data['success'] = true;
        $data['message'] = 'Menu Item Added!';
      } else {
        $data['success'] = false;
        $data['message'] = 'Menu Item not Added';
      }
    } else {
      $data['success'] = false;
      $data['message'] = 'Menu Item not Added';
    }
  } elseif ($order_action == 2) {

    // if update btn is click
    if (isset($_POST['banner_id']) && isset($_POST['banner_name'])&& isset($_POST['banner_number']) && isset($_POST['category_id'])&& isset($_POST['menu_descritption']) && isset($_POST['menu_ingredients'])) {


      $name = $_POST['banner_name'];
      $banner_number = $_POST['banner_number'];
      $category_id = $_POST['category_id'];
      $menu_descritption = $_POST['menu_descritption'];
      $menu_ingredients = $_POST['menu_ingredients'];
      $banner_id = $_POST['banner_id'];


      $banneritems_sql = mysqli_query($con, "SELECT menu_image FROM tblmenu  WHERE  `menu_id` = $banner_id LIMIT 1");
      $row = mysqli_fetch_array($banneritems_sql);
      $b_image_path = $row['menu_image'];
      $whole_image_path = "../" . $b_image_path;

      // Use unlink() function to delete a file 
      if (!unlink($whole_image_path)) {
        $data['success'] = false;
        $data['message'] = 'Image can not be deleted due to an error';
      } else {

        // generating image name
        $formatedname = strip_tags($name);
        $formatedname = str_replace(" ", "_", $formatedname);

        $temp = explode(".", $_FILES["inputfile"]["name"]);
        $date = date('YmdHis');


        // setting image new file name
        $postfix = '_' . $date . '_' . str_pad(rand(1, 10000), 5, '0', STR_PAD_LEFT);
        $newfilename = stripslashes($formatedname . '_banner') . $postfix . '.' . end($temp);

        $targetPath = $target_dir . basename($newfilename);
        $db_targetPath = $db_target_dir . basename($newfilename);


        if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $targetPath)) {
          $query = mysqli_query($con,"UPDATE `tblmenu` SET `menu_name`= '$name', `price` = $banner_number, `description` = '$menu_descritption', `menu_type_id` = $category_id, `menu_image` = '$db_targetPath', `backgroundImage` = '$db_targetPath', `ingredients` = '$menu_ingredients', `modified` = '$date' WHERE  `menu_id` = $banner_id ");

          $data['success'] = true;
          $data['message'] = 'Menu Item Updated!';
        } else {
          $data['success'] = false;
          $data['message'] = 'Menu Item not Updated';
        }
      }
    } else {
      $data['success'] = false;
      $data['message'] = 'Menu Item not Updated';
    }
  } elseif ($order_action == 3) {

    //delete btn clicked

    if (isset($_POST['banner_id'])) {

      $banner_id = $_POST['banner_id'];

      $banneritems_sql = mysqli_query($con, "SELECT menu_image FROM tblmenu  WHERE  `menu_id` = $banner_id LIMIT 1");
      $row = mysqli_fetch_array($banneritems_sql);
      $b_image_path = $row['menu_image'];
      $whole_image_path = "../" . $b_image_path;

      // Use unlink() function to delete a file 
      if (!unlink($whole_image_path)) {
        $data['success'] = false;
        $data['message'] = 'Image can not be deleted due to an error';
      } else {
        $delete_order_sql = "DELETE FROM `tblmenu` WHERE  `menu_id` = $banner_id";

        mysqli_query($con, $delete_order_sql);

        $affected_rows = mysqli_affected_rows($con);

        if ($affected_rows >= 1) {
          $data['success'] = true;
          $data['message'] = $affected_rows . ' Menu Item Deleted! ';
        } else if ($affected_rows <= 0) {
          $data['success'] = false;
          $data['message'] = 'Menu Item with ID ' . $childname . ' Not Deleted';
        }
      }
    } else {
      $data['success'] = false;
      $data['message'] = 'Menu Item ID not Passed';
    }
  }
} else {
  $data['success'] = false;
  $data['message'] = 'Undetermined Function';
}


echo json_encode($data);


//getting current page url
function pathUrl($dir = __DIR__)
{

  $root = "";
  $dir = str_replace('\\', '/', realpath($dir));

  //HTTPS or HTTP
  $root .= !empty($_SERVER['HTTPS']) ? 'https' : 'http';

  //HOST
  $root .= '://' . $_SERVER['HTTP_HOST'];

  //ALIAS
  if (!empty($_SERVER['CONTEXT_PREFIX'])) {
    $root .= $_SERVER['CONTEXT_PREFIX'];
    $root .= substr($dir, strlen($_SERVER['CONTEXT_DOCUMENT_ROOT']));
  } else {
    $root .= substr($dir, strlen($_SERVER['DOCUMENT_ROOT']));
  }

  $root .= '/';

  return $root;
}
