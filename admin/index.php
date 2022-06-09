<?php
// keep the same order
require("config.php");
$db = new Database();
$con = $db->getConnString();

require('session.php');

require('queries/statsquery.php');
require('queries/case_new_query.php');
require "queries/classes/User.php";
require "queries/classes/Cases.php";



?>

<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com -->
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="pages/assets/z_favicon.png">

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


  <!----===== Boxicons CSS ===== -->
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

  <title>Famlink</title>

</head>

<body>
  <nav class="sidebar">
    <header>
      <div class="image-text">
        <span class="image">
          <img src="pages/assets/famlink.png" alt="">
        </span>

        <div class="text logo-text">
          <span class="name">Famlink</span>
          <span class="profession">CEWOCHR ADMIN</span>
        </div>
      </div>

      <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
      <div class="menu">

        <!-- <li class="search-box">
          <i class='bx bx-search icon'></i>
          <input type="text" placeholder="Search...">
        </li> -->

        <ul class="menu-links">
          <li class="nav-link active">
            <a href="index">
              <i class='bx bx-home-alt icon'></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="#">
              <i class='bx bx-bar-chart-alt-2 icon'></i>
              <span class="text nav-text">Reports</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="pages/appointments">
              <i class='bx bx-bell icon'></i>
              <span class="text nav-text">Appointments</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="#">
              <i class='bx bx-pie-chart-alt icon'></i>
              <span class="text nav-text">Analytics</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="#">
              <i class='bx bx-heart icon'></i>
              <span class="text nav-text">Likes</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="#">
              <i class='bx bx-wallet icon'></i>
              <span class="text nav-text">Wallets</span>
            </a>
          </li>

        </ul>
      </div>

      <div class="bottom-content">
        <li class="">
          <a href="logout.php">
            <i class='bx bx-log-out icon'></i>
            <span class="text nav-text">Logout</span>
          </a>
        </li>

        <li class="mode">
          <div class="sun-moon">
            <i class='bx bx-moon icon moon'></i>
            <i class='bx bx-sun icon sun'></i>
          </div>
          <span class="mode-text text">Dark mode</span>

          <div class="toggle-switch">
            <span class="switch"></span>
          </div>
        </li>

      </div>
    </div>

  </nav>

  <section class="home">
    <div class="mainpanel">
      <div class="elements">
        <div class="activities">
          <div class="sectionheading">
            <h3 class="sectionlable">Dashboard</h3>
            <h6 class="sectionlable">Summary</h6>
          </div>
          <div class="statistics">
            <div class="card" style="background:#1845b8">
              <div class="illustration">
                <img src="images/fontisto_shopping-basket.svg" alt="" />
              </div>
              <div class="stats">
                <p class="label" style="color: #fff">New Cases</p>
                <p class="number" style="color: #fff"><?= $total_newCases  ?></p>
              </div>
            </div>

            <div class="card">
              <div class="illustration">
                <img src="images/bxs_food-menu.svg" alt="" />
              </div>
              <div class="stats">
                <p class="label">Appointments</p>
                <p class="number"><?= $total_new_appointment_stat ?></p>
              </div>

            </div>
            <div class="card">
              <div class="illustration">
                <img src="images/bx_category.svg" alt="" />
              </div>
              <div class="stats">
                <p class="label">Managed Cases</p>
                <p class="number"><?= $total_handledCases ?></p>
              </div>

            </div>
            <div class="card">
              <div class="illustration">
                <img src="images/carbon_user-multiple.svg" alt="" />
              </div>
              <div class="stats">
                <p class="label">Users</p>
                <p class="number"><?= $total_user_stat ?></p>
              </div>

            </div>
          </div>

          <div class="sectionheading">
            <h3 class="sectionlable">Cases</h3>
            <h6 class="sectionlable">All New Reported Cases</h6>
          </div>

          <?php if ($caseNew) : ?>

            <div class="childrencontainer">


              <?php
              foreach ($caseNew as $row) :
              ?>


                <?php
                $order = new Cases($con, $row);
                ?>

                <div class="product-card">

                  <div class="imagecontainer">
                    <img src="<?= $order->getPicture() ?>" alt="">
                    <div class="imgtext">
                      <h5 class="casetitle"><?= $order->getReportedbyUser() ?></h5>
                      <p class="case_info"><?= $order->getDatecreated() ?> </p>
                    </div>
                  </div>

                  <div class="casedescription">
                    <h1><?= $order->getTitle() ?></h1>
                    <p><?= $order->getDescription() ?> </p>
                    <p><span class="categoryid">Tag: <?= $order->getCategoryId() ?></span> <span class="case_location">Address: <?= $order->getLocation() ?> </span> </p>

                  </div>


                  <input type="hidden" name="artistid" value="<?= $order->getId() ?>">

                  <div class="product-card__actions">
                    <a href="pages/order_detail.php?id=<?= $order->getId() ?>" class="btn btn-primary my-2  sponsorbutton">View Details</a>
                  </div>
                </div>

              <?php endforeach ?>

            </div>


          <?php else :  ?>
            No Orders Left
          <?php endif ?>



        </div>

      </div>
    </div>

  </section>

  <script>
    const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle"),
      searchBtn = body.querySelector(".search-box"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");


    toggle.addEventListener("click", () => {
      sidebar.classList.toggle("close");
    })

    searchBtn.addEventListener("click", () => {
      sidebar.classList.remove("close");
    })

    modeSwitch.addEventListener("click", () => {
      body.classList.toggle("dark");

      if (body.classList.contains("dark")) {
        modeText.innerText = "Light mode";
      } else {
        modeText.innerText = "Dark mode";

      }
    });
  </script>

</body>

</html>