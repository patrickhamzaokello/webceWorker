<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
  <link rel="icon" type="image/x-icon" href="assets/z_favicon.png">

  <link rel="stylesheet" href="../css/main.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <title>Banners</title>
</head>
<?php
require("../config.php");
$db = new Database();
$con = $db->getConnString();

require('../session.php');
require('../queries/statsquery.php');
require('../queries/banner_queries.php');
require("../queries/classes/Banners.php");

require('../queries/menutype_with_food.php');
require("../queries/classes/MenuType.php");



?>

<body>
  <header>
    <nav>

      <div class="currentpage">
        <p>
          <span><a href="../index">Admin /</a></span>
          <a href="../index"><?= $login_session ?></a>
        </p>
      </div>

      <div class="menu">
        <div class="menuitem">
          <a href="../index">App Banners</a>
        </div>
      </div>

      <a href="../logout.php">
        <div class="useraccount">Exit</div>
      </a></div>
    </nav>
  </header>
  <main>
    <div class="sidepanel">
      <div class="about">
        <div class="title">
          <img src="assets/zodongologo.png" alt="">
        </div>
      </div>
      <div class="sidemenu">
        <a href="../index" class="menu">
          <p>Dashboard</p>
        </a>
        <a href="allorders" class="menu">
          <p>All Orders</p>
        </a>
        <a href="menuitems" class="menu">
          <p>Menu</p>
        </a>
        <a href="categories" class="menu">
          <p>Categories</p>
        </a>
        <a href="banners" class="menu active">
          <p>Banners</p>
        </a>
      </div>

    </div>
    </div>
    <div class="mainpanel">

      <div class="createnew">
        <a class="createnewbtn">Add New Banner</a>
      </div>


      <div class="elements">

        <div class="activities">

          <?php if ($bannerIds) : ?>

            <div class="menuitemscontatiner">


              <?php
              foreach ($bannerIds as $row) :
              ?>

                <?php
                $menu = new Banners($con, $row);
                ?>

                <div class="MenuItemCard">

                  <img src="<?= $menu->getImageUrl()  ?>" alt="">

                  <div class="menuitemcarddetail">


                    <div class="menuitemactionbutton">
                      <div class="cancebutton_parent">
                        <input class="cardID" type="hidden" name="orderID" value="<?= $menu->getId() ?>">
                        <button class="cancelbutton">Delete</button>
                      </div>
                      <div class="approvebutton_parent">
                        <input class="cardID" type="hidden" name="orderID" value="<?= $menu->getId() ?>">
                        <button class="approvebutton">Update</button>
                      </div>

                    </div>

                    <h1><?= $menu->getName()  ?></h1>
                    <p class="">Category: <?= $menu->getCategory_id()  ?></p>
                    <p class="description">Display Position: <?= $menu->getDisplay_order() ?></p>
                    <p class="date"><span>Date Created </span><?= $menu->getDatecreated() ?></p>
                    <p class="date"><span>Last Update </span><?= $menu->getDatemodified() ?></p>

                  </div>

                </div>

              <?php endforeach ?>

            </div>


          <?php else :  ?>
            No Banners Available on the app
          <?php endif ?>



        </div>

      </div>

      <div class="sponserdiv">
        <div class="sponsorshipform">
          <div class="sponsormessagediv">

          </div>
          <form id="approveform" action="" method="POST" enctype="multipart/form-data">

            <div class="form-group">
              <input id="bannername" type="hidden" name="childname" class="form-control" placeholder="order_id" disabled>
            </div>

            <div class="approveorderform">
              <h1>Banner Details</h1>
              <p>Provide New Banner Details</p>

              <div id="error"></div>

              <div class="form-group">
                <input type="text" id="name" name="name" class="form-control" placeholder="Banner Name">
              </div>
              <div class="form-group">
                <?php if ($menuTypesIds_withfood) : ?>
                  <select id="category" name="Category" class="form-control">

                    <?php
                    foreach ($menuTypesIds_withfood as $row) :
                    ?>

                      <?php
                      $menu_type = new MenuType($con, $row);
                      ?>

                      <option value="0">
                        Choose Banner Category
                      </option>

                      <option value="  <?= $menu_type->getId()  ?>">
                        <?= $menu_type->getName()  ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                <?php else :  ?>
                  <select name="Category" class="form-control">
                    <option value="0">
                      No categories found
                    </option>
                  </select>
                <?php endif ?>
              </div>
              <div class="form-group">
                <input type="number" id="number" name="display_order" class="form-control" placeholder="Display Order">
              </div>
              <div class="form-group">
                <input id="file-input-createplaylist" name="file-input-name" class="form-control" type='file' accept="image/*" />
              </div>

              <div class="form-group">
                <input type="submit" value="Approve" style="width: 100% !important;" class="sponsorchildnowbtn">
              </div>
              <div class="form-group">
                <button type="reset" id="cancelbtn" style="background: #fff;border: 1px solid #000;padding: 10px 20px;width: 100%;color: #000; border-radius: 5px;" onclick="cancelsponsohip()">Cancel </button>
              </div>
            </div>

            <div class="deleteorder" style="display: none;">
              <h1>Delete Banner</h1>
              <p>This action can not be reversed when done! </p>


              <div class="form-group">
                <input type="submit" value="Delete" style="width: 100% !important;" class="sponsorchildnowbtn">
              </div>
              <div class="form-group">
                <button type="reset" id="cancelbtn" style="background: #fff;border: 1px solid #000;padding: 10px 20px;width: 100%;color: #000; border-radius: 5px;" onclick="cancelsponsohip()">Cancel </button>
              </div>
            </div>


          </form>

        </div>
      </div>

      <!--        loader-->
      <div class="loaderdiv">
        <div class="loader-container">
          <div class="dot dot-1"></div>
          <div class="dot dot-2"></div>
          <div class="dot dot-3"></div>
          <div class="dot dot-4"></div>
        </div>
      </div>
    </div>
  </main>

  <script src="../js/process_banners.js"></script>



</body>


</html>