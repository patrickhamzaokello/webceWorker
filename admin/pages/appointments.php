<?php
require("../config.php");
$db = new Database();
$con = $db->getConnString();

require('../session.php');
require('../queries/statsquery.php');
require('../queries/appointment_query.php');
require('../queries/appointment_new_query.php');
require('../queries/appointment_prep_query.php');
require('../queries/appointment_delivered_query.php');
require("../queries/classes/Appointment.php");

?>



<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com -->
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="assets/z_favicon.png">

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="../css/main.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


  <!----===== Boxicons CSS ===== -->
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

  <title>Appointments</title>

</head>

<body>
  <nav class="sidebar">
    <header>
      <div class="image-text">
        <span class="image">
          <img src="assets/famlink.png" alt="">
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

        <li class="search-box" style="display: none;">
          <i class='bx bx-search icon'></i>
          <input type="text" placeholder="Search...">
        </li>

        <ul class="menu-links">
          <li class="nav-link ">
            <a href="../index">
              <i class='bx bx-home-alt icon'></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="cases">
              <i class='bx bx-bar-chart-alt-2 icon'></i>
              <span class="text nav-text">Cases</span>
            </a>
          </li>

          <li class="nav-link active">
            <a href="appointments">
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
          <a href="../logout.php">
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
            <h3 class="sectionlable">Appointments</h3>
            <h6 class="sectionlable">Manage all Appointments</h6>
          </div>


          <div class="orderfilter">


            <a href="#">
              <div class="filterorder filter_active">New <span class="noti circle"><?= $total_new_appointment_stat ?></span></div>
            </a>


            <a href="preparing_order.php">
              <div class="filterorder">Approved <span class="noti circlenotactive"><?= $total_approved_appointment_stat ?></span></div>
            </a>


            <a href="delivered_order.php">
              <div class="filterorder">Canceled <span class="noti circlenotactive"><?= $total_cancel_appointment_stat ?></span></div>
            </a>


          </div>



          <div class="appointmentdiv">


            <?php if ($appointmentNew) : ?>

              <div class="childrencontainer">


                <?php
                foreach ($appointmentNew as $row) :
                ?>

                  <?php
                  $order = new Appointment($con, $row);
                  ?>

                  <div class="product-card">
                    <h4 class="orderID" style="display: none;"><?= $order->getId() ?></h4>

                    <p class="artistlable">Order No <span class="ordervalue"> ZD416F<?= $order->getId()  ?> </span></p>
                    <p class="artistlable">Date Added <span class="ordervalue"><?= $order->getDateCreated()  ?> </span></p>
                    <div class="addresslayout">

                    </div>
                    <p class="artistlable">Tag <span class="ordervalue"><?= $order->getUserid()  ?> </span> <span class="artistlable">Status <span class="ordervalue smalltag"><?= $order->getStatus()  ?></span> </span></p>


                    <input type="hidden" name="artistid" value="<?= $order->getId() ?>">

                    <div class="product-card__actions">
                      <a href="case_detail.php?id=<?= $order->getId() ?>" class="btn btn-primary my-2  sponsorbutton">View Details</a>
                    </div>
                  </div>

                <?php endforeach ?>

              </div>


            <?php else :  ?>
              No Appointments Left
            <?php endif ?>



          </div>


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

  <script src="../js/process_order_detail.js"></script>

</body>

</html>