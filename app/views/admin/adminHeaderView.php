<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Link for icons  -->
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
  <!-- Link for styles  -->
  <link rel="stylesheet" href="<?= ROOT ?>/assets/css/dashboard.css" />
  <title><?= APP_NAME ?> | <?= $title ?? "Orders" ?></title>
</head>

<body>
  <div class="contaier">
    <div class="sidebar">
      <ul>
        <li>
          <a href="#">
            <i class=""></i>
            <div class="title">Tabs</div>
          </a>
        </li>
        <li>
          <a href="<?= ROOT ?>/admin/dashboard">
            <i class="bx bx-grid-alt"></i>
            <div class="title">Dashboard</div>
          </a>
        </li>
        <li>
          <a href="<?= ROOT ?>/admin/categories">
            <i class="bx bx-category-alt"></i>
            <div class="title">Categories</div>
          </a>
        </li>
        <li>
          <a href="<?= ROOT ?>/admin/products">
            <i class="bx bxl-product-hunt"></i>
            <div class="title">Products</div>
          </a>
        </li>
        <li>
          <a href="<?= ROOT ?>/admin/orders">
            <i class='bx bx-purchase-tag-alt'></i>
            <div class="title">Orders</div>
          </a>
        </li>
        <li>
          <a href="<?= ROOT ?>/admin/users">
            <i class="bx bx-user-circle"></i>
            <div class="title">Users</div>
          </a>
        </li>
        <li>
          <a href="<?= ROOT ?>/admin/slider">
            <i class='bx bx-images'></i>
            <div class="title">Slider Images</div>
          </a>
        </li>
        <li>
          <a href="<?= ROOT ?>/home">
            <i class="bx bx-home"></i>
            <div class="title">Home</div>
          </a>
        </li>
      </ul>
    </div>
    <div class="main">
      <div class="top-bar">
        <div class="user">
          <img src="<?= esc(get_image(Auth::getImage())) ?>" alt="user" />
        </div>
        <div class="info">
          <span><?= esc(ucfirst(substr(Auth::getFirstname(), 0, 1))) ?>. <?= esc(Auth::getLastname()) ?></span>
          <div class="user-settings">
            <ul>
              <li class="profile-modal-trigger"><i class="bx bxs-cog"></i><a>Profile</a></li>
              <li>
                <i class="bx bxs-log-out-circle"></i><a href="<?= ROOT ?>/logout">Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="profile-modal">
        <div class="profile-modal-content">
          <div class="modal-heading">
            <h2>Edit profile</h2>
            <span class="close-modal close-modal-profile"><i class='bx bx-window-close'></i></span>
          </div>
          <div class="profile-form-wrapper">
            <form method="POST" enctype="multipart/form-data">
              <div class="profile-img">
                <img id="modal_img" src="<?= esc(get_image(Auth::getImage())); ?>" alt="profile image">
                <input onchange="document.getElementById('modal_img').src = window.URL.createObjectURL(this.files[0])" type="file" name="image" id="image">
              </div>
              <div class="input-holder">
                <div class="item">
                  <label for="firstname">Firstname </label>
                  <input type="text" name="firstname" value="<?= esc(set_value(null, Auth::getFirstname())) ?>">
                  <small class="text-danger" id="js-profile-error-firstname"></small>
                </div>
                <div class="item">
                  <label for="lastname">Lastname </label>
                  <input type="text" name="lastname" value="<?= esc(set_value(null, Auth::getLastname())) ?>">
                  <small class="text-danger" id="js-profile-error-lastname"></small>
                </div>
                <div class="item">
                  <label for="email">Email </label>
                  <input type="text" name="email" value="<?= esc(set_value(null, Auth::getEmail())) ?>">
                  <small class="text-danger" id="js-profile-error-email"></small>
                </div>
                <div class="item">
                  <label for="gender">Gender </label>
                  <select name="gender">
                    <option value="null">Select your gender</option>
                    <option <?= set_select(null, 'male', esc(Auth::getGender()) ?? "") ?> value="male">Male</option>
                    <option <?= set_select(null, 'female', esc(Auth::getGender()) ?? "") ?> value="female">Female</option>
                    <option <?= set_select(null, 'other', esc(Auth::getGender()) ?? "") ?> value="other">Other</option>
                  </select>
                  <small class="text-danger" id="js-profile-error-gender"></small>
                </div>
                <div class="item">
                  <label for="country">Country</label>
                  <select name="country">
                    <option value="null">Select your country</option>
                    <option <?= set_select(null, 'czechia', esc(Auth::getAddress()[0]->country) ?? "") ?> value="czechia">Czechia</option>
                    <option <?= set_select(null, 'slovakia', esc(Auth::getAddress()[0]->country) ?? "") ?> value="slovakia">Slovakia</option>
                  </select>
                  <small class="text-danger" id="js-profile-error-country"></small>
                </div>
                <div class="item">
                  <label for="street">Street and home number</label>
                  <input type="text" name="street" value="<?= set_value(null, esc(Auth::getAddress()[0]->street) ?? "") ?>">
                  <small class="text-danger" id="js-profile-error-street"></small>
                </div>
                <div class="item">
                  <label for="town">Town</label>
                  <input type="text" name="town" value="<?= set_value(null, esc(Auth::getAddress()[0]->town) ?? "") ?>">
                  <small class="text-danger" id="js-profile-error-town"></small>
                </div>
                <div class="item">
                  <label for="postcode">Postcode</label>
                  <input type="text" name="postcode" value="<?= set_value(null, esc(Auth::getAddress()[0]->postcode) ?? "") ?>">
                  <small class="text-danger" id="js-profile-error-postcode"></small>
                </div>
              </div>
              <div id="profile-submit-button" class="profile-submit">
                <span class="btn-submit">Submit</span>
              </div>
            </form>
          </div>
        </div>
      </div>