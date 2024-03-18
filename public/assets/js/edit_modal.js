//modal
const modalTrigger = document.querySelector(".profile-modal-trigger");
const modalClose = document.querySelector(".close-modal-profile");
const modal = document.querySelector(".profile-modal");

if (modalTrigger != undefined) {
  modalTrigger.onclick = function () {
    modal.style.display = "block";
    document.body.classList.add("modal-open");
  };

  modalClose.onclick = function () {
    modal.style.display = "none";
    document.body.classList.remove("modal-open");
  };

  //EDIT PROFILE VALIDATION
  const allowedGenders = ["male", "female", "other"];
  const allowedCoutries = ["czechia", "slovakia"];
  const allowedImagesTypes = ["jpeg", "jpg", "png"];
  const profileSubmitBtn = document.getElementById("profile-submit-button");

  profileSubmitBtn.addEventListener("click", (e) => {
    let form = e.currentTarget.parentElement;
    //console.log(form);
    let inputs = form.querySelectorAll("input, select");
    //console.log(inputs);
    //object for sending
    let obj = {};

    for (let i = 0; i < inputs.length; i++) {
      let key = inputs[i].name;
      //console.log(key);
      if (key == "image") {
        if (typeof inputs[i].files[0] == "object") {
          obj[key] = inputs[i].files[0];
          // validate image
          //let ext = obj[key].name.split(".").pop();
          // if (!allowedImagesTypes.includes(ext.toLowerCase())) {
          //   alert(
          //     "Only these file types are allowed in profile image: " +
          //       allowedImagesTypes.toString(",")
          //   );
          //   return;
          // }
        }
      } else {
        obj[key] = inputs[i].value;
        // if (obj[key] == "") {
        //   alert(key + " je poviný!");
        //   return;
        // }
      }
    }
    //console.log(obj);

    send_data(obj);
  });

  // ajax for profile :D

  function send_data(obj) {
    //create a form that will be send to controller
    let form = new FormData();
    for (key in obj) {
      form.append(key, obj[key]);
    }

    // ajax
    let ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
      if (ajax.readyState == 4) {
        if (ajax.status == 200) {
          //OK
          handle_reslut(ajax.responseText);
        } else {
          console.log("Ajax status is not corret.");
        }
      }
    };

    ajax.open("post", ROOT + "/editprofile", false);
    ajax.send(form);
  }

  function handle_reslut(result) {
    console.log(result);

    let obj = JSON.parse(result);
    if (typeof obj == "object") {
      if (typeof obj.errors == "object") {
        //display errors
        display_errors_profile(obj.errors);
      } else {
        alert(obj.message);
        window.location.reload();
      }
    }
  }

  function display_errors_profile(err) {
    for (key in err) {
      document.querySelector("#js-profile-error-" + key).innerHTML = err[key];
    }
  }
}
