<?php $this->view('admin/adminHeader', $data); ?>
<section class="main-content">
  <div class="wrapper">
    <div class="slider-images">
      <div class="heading">
        <h1>Slider images</h1>
        <a href="<?= ROOT ?>/admin/slider/add">
          <button type="button"><i class='bx bx-plus'></i>Add slide</button>
        </a>
      </div>
      <div class="slider-nav">
        <ul>
          <?php if (isset($rows)) : ?>
            <?php $index = 1 ?>
            <?php foreach ($rows as $key => $row) : ?>
              <li id="slider-<?= $key ?>">Slide <?= $index ?></li>
              <?php $index++ ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>

      </div>
      <div id="content">
        <?php if (isset($rows)) : ?>
          <?php $index = 1 ?>
          <?php foreach ($rows as $key => $row) : ?>
            <!-- SLIDER -->
            <form method="post" id="slider-<?= $key ?>" class="slider visible" enctype="multipart/form-data">
              <h3>Slider <?= $index ?></h3>
              <div class="slider-img-holder">
                <img id="slider-img-<?= $key ?>" src="<?= get_image(esc($row->image)) ?>" alt="">
                <input type="file" onchange="document.getElementById('slider-img-<?= $key ?>').src = window.URL.createObjectURL(this.files[0])" name="image">
                <small class="text-danger" id="js-slider-error-image-<?= $key ?>"></small>
              </div>
              <div class="input-holder">
                <label for="name">Name</label>
                <input type="text" name="title" placeholder="Slider name" value="<?= set_value("title", esc($row->title)) ?>">
                <small class="text-danger" id="js-slider-error-title-<?= $key ?>"></small>
              </div>
              <div class="input-holder">
                <label for="description">description</label>
                <textarea name="description" cols="30" rows="10"><?= set_value("title", esc($row->description)) ?></textarea>
                <small class="text-danger" id="js-slider-error-description-<?= $key ?>"></small>
              </div>
              <div class="input-holder">
                <label for="disabled">Active</label>
                <select name="disabled">
                  <option <?= set_select('disabled', '0', $row->disabled) ?> value="0">Yes</option>
                  <option <?= set_select('disabled', '1', $row->disabled) ?> value="1">No</option>
                </select>
              </div>
              <div>
                <button type="button" class="btn-danger" onclick="remove_slide(<?= $key ?>, <?= $index ?>)">Remove Slide</button>
              </div>
              <div class="btn-holder">
                <button type="button" onclick="save_image(event, <?= $key ?>)" class="btn-primary">Save</button>
                <a href="<?= ROOT ?>/admin/dashboard">
                  <button type="button" class="btn-secondary">Cancel</button>
                </a>
              </div>
            </form>
            <!-- END OF SLIDER -->
            <?php $index++ ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

  </div>

</section>

<script>
  let tab = localStorage.getItem("tab") ? localStorage.getItem("tab") : "slider-1";
  let uploading = false;

  let lis = document.querySelectorAll(".slider-nav > ul li");
  let sliders = document.querySelectorAll(".slider");
  let content = document.querySelector("#content");

  lis.forEach(item => {
    item.addEventListener("click", (e) => {
      let li = e.currentTarget;
      let id = li.getAttribute("id");
      set_tab(id);

      lis.forEach(x => x.classList.remove("active"));
      li.classList.add("active");

      sliders.forEach(slider => {
        if (slider.getAttribute("id") == id) {
          slider.classList.add("visible");
        } else {
          slider.classList.remove("visible");
        }
      });
    });
  });

  function remove_slide(id, pos) {
    if (confirm("Are you sure, that you want to delete this slide?!")) {
      let obj = {};
      obj.id = id;
      obj.action = "remove";

      set_tab(`slider-${pos - 1}`);
      send_slider(obj);
    }

  }

  function set_tab(tabName) {
    tab = tabName;
    localStorage.setItem("tab", tabName);
  }

  function show_tab(tabName) {
    lis.forEach(li => {
      if (li != undefined) {
        li.classList.remove("active")
        if (li.getAttribute("id") == tabName) li.classList.add("active");
      }
    });
    sliders.forEach((slider) => {
      if (slider != undefined) {
        slider.classList.remove("visible")
        if (slider.getAttribute("id") == tabName) slider.classList.add("visible");
      }
    });
  }

  function save_image(e, id) {

    if (uploading) {
      alert("Please wait to other image to complite uploading");
      return;
    }

    let form = e.currentTarget.form;
    let inputs = form.querySelectorAll("input, textarea, select");
    let obj = {}
    uploading = true

    for (let i = 0; i < inputs.length; i++) {
      const key = inputs[i].name;

      if (key == "image") {
        //validate image
        if (typeof inputs[i].files[0] == "object") {
          let image = inputs[i].files[0];
          obj[key] = image;
          let allowedExt = ['jpg', 'jpeg', 'png'];
          let ext = image.name.split(".").pop()

          if (!allowedExt.includes(ext.toLowerCase())) {
            alert("Only these file types are allowed in slider image: " + allowedExt.toString(","));
            uploading = false;
            return;
          }

        }
      } else {
        obj[key] = inputs[i].value;
      }
      //validate inputs
      // if (obj[key] == "") {
      //   alert("An " + key + " is required!");
      //   uploading = false;
      //   return;
      // }
    }
    obj.id = id;
    obj.action = "";

    send_slider(obj);
  }

  function send_slider(obj) {
    let xhr = new XMLHttpRequest();
    let form = new FormData();

    for (const key in obj) {
      form.append(key, obj[key]);
    }

    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          // OK
          uploading = false;
          handle_result_slider(xhr.responseText)
        } else {
          console.log("Status is not correct");
        }
      }
    }
    xhr.open("POST", "<?= ROOT ?>/admin/slider", false);
    xhr.send(form);
  }

  function handle_result_slider(result) {
    console.log(result);

    let obj = JSON.parse(result);
    if (typeof obj == "object") {
      if (typeof obj.errors == "object") {
        //display errors
        alert(obj.message);

        if (obj.errors) {
          display_errors_slider(obj);
        }
      } else {
        alert(obj.message);
        window.location.reload();
      }
    }

  }

  function display_errors_slider(obj) {
    for (key in obj.errors) {
      document.querySelector("#js-slider-error-" + key + "-" + obj.id).textContent = obj.errors[key];
    }
  }


  window.onload = function() {
    show_tab(tab);
  }
</script>
<?php $this->view('admin/adminFooter', $data); ?>