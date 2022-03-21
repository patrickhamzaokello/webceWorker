const approveOrderBtn = document.querySelectorAll(".approvebutton_parent");
const cancelORderBTn = document.querySelectorAll(".cancebutton_parent");
const childinputname = document.querySelector("#childnameinput");
const order_status_id = document.querySelector("#order_status_id");
const sponsorshipform = document.querySelector(".sponserdiv");
const loaderdiv = document.querySelector(".loaderdiv");

const deleteorder_info = document.querySelector(".deleteorder");
const approveorderform_info = document.querySelector(".approveorderform");

const displaySetting = sponsorshipform.style.display;
const loaderdiv_displaySetting = loaderdiv.style.display;

const btnloader = document.querySelector("#btnloader");

// order action 1- delete, 2 - update
var order_action;

approveOrderBtn.forEach((productCard) => {
  const childNamegot = productCard.querySelector(".order_id_input").value;
  const order_status_id_got =
    productCard.querySelector(".order_status_id").value;

  // Make whole card clickable, but only if event target is NOT a specific card action inside <div Functions="product-card__actions">.
  productCard.addEventListener("click", (e) => {
    if (e.target.closest(".product-card__actions") === null) {
      if (displaySetting == "block") {
        sponsorshipform.style.display = "none";
      } else {
        sponsorshipform.style.display = "grid";
        deleteorder_info.style.display = "none";
        approveorderform_info.style.display = "block";
      }

      childinputname.value = childNamegot;
      order_status_id.value = order_status_id_got;
      order_action = 2;
    }
  });
});

cancelORderBTn.forEach((cancelbtn) => {
  const childNamegot = cancelbtn.querySelector(".order_id_input").value;
  const order_status_id_got = cancelbtn.querySelector(".order_status_id").value;

  // Make whole card clickable, but only if event target is NOT a specific card action inside <div Functions="product-card__actions">.
  cancelbtn.addEventListener("click", (e) => {
    if (e.target.closest(".product-card__actions") === null) {
      if (displaySetting == "block") {
        sponsorshipform.style.display = "none";
        deleteorder_info.style.display = "none";
      } else {
        sponsorshipform.style.display = "grid";
        deleteorder_info.style.display = "block";
        approveorderform_info.style.display = "none";
      }

      childinputname.value = childNamegot;
      order_status_id.value = order_status_id_got;

      order_action = 1;
    }
  });
});

$(document).ready(function () {
  $("form").submit(function (event) {
    var formData = {
      childname: $("#childnameinput").val(),
      orderstatus: $("#order_status_id").val(),
      order_action: order_action,
    };

    if (loaderdiv_displaySetting == "block") {
      loaderdiv.style.display = "none";
    } else {
      loaderdiv.style.display = "grid";
    }

    $.ajax({
      type: "POST",
      url: "processors/process_approve_order.php",
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      if (!data.success) {
        $(".sponsormessagediv").html(
          '<div Functions="alert alert-error">' + data.message + "</div>"
        );
        setTimeout(function () {
          $(".sponsormessagediv").html("");
          sponsorshipform.style.display = "none";
          loaderdiv.style.display = "none";
        }, 3000);
      } else {
        $(".sponsormessagediv").html(
          '<div Functions="alert alert-success">' + data.message + "</div>"
        );
        setTimeout(function () {
          $(".sponsormessagediv").html("");
          sponsorshipform.style.display = "none";
          loaderdiv.style.display = "none";
        }, 3000);

        document.getElementById("approveform").reset();
        window.location.href = "allorders.php";
      }
    });

    event.preventDefault();
  });

  $("form").su;
});

function cancelsponsohip() {
  sponsorshipform.style.display = "none";
}
