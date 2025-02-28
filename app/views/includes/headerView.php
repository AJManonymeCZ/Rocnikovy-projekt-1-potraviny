<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Link for icons  -->
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
  <!-- Link for styles  -->
  <link rel="stylesheet" href="<?= ROOT ?>/assets/css/style.css" />
  <title><?= APP_NAME ?> | <?= $title ?></title>
</head>

<body>
  <!-- NAVBAR -->
  <nav>
    <div class="navbar">
      <i class="bx bx-menu"></i>
      <div class="logo"><a href="<?= ROOT ?>"><img src="<?= ROOT ?>/assets/images/Potraviny_logo.png" alt="logo_image"></a></div>
      <div class="nav-links">
        <div class="sidebar-logo">
          <span class="logo-name"></span>
          <i class="bx bx-x"></i>
        </div>
        <ul class="links">
          <li><a href="<?= getPath() ?>/home"><?= LanguageFactory::getLocalized("navigation.home") ?></a></li>
          <li><a href="<?=  getPath() ?>/shop"><?= LanguageFactory::getLocalized("navigation.shop") ?></a></li>
          <li><a href="<?=  getPath() ?>/about"><?= LanguageFactory::getLocalized("navigation.about") ?></a></li>
          <li><a href="<?=  getPath() ?>/contact"><?= LanguageFactory::getLocalized("navigation.contact") ?></a></li>
          <?php if (!Auth::logged_in()) : ?>
            <li><a href="<?=  getPath() ?>/signup"><?= LanguageFactory::getLocalized("navigation.signup") ?></a></li>
            <li><a href="<?=  getPath() ?>/login"><?= LanguageFactory::getLocalized("navigation.login") ?></a></li>
          <?php else : ?>
            <li class="drop">
              <?php if (!empty(Auth::getImage())) : ?>
                <div class="profile1-img">
                  <img id="" src="<?= get_image(esc(Auth::getImage())); ?>" alt="profile image">
                </div>
              <?php endif; ?>
              <span style="max-width: 150px;">Hi, <?= esc(Auth::getFirstname()) ?><i class="bx bx-chevron-down arrow js-arrow"></i></span>
              <ul class="profile-sub-menu sub-menu">
                <li><i class='bx bx-edit-alt'></i><label class="profile-modal-trigger"><?= LanguageFactory::getLocalized("navigation.profile") ?></label></li>
                <li><i class='bx bx-dollar-circle'></i><a href="<?=  getPath() ?>/orders"><?= LanguageFactory::getLocalized("navigation.orders") ?></a></li>
                <?php if (Auth::is_admin()) : ?>
                  <li><i class='bx bxs-spreadsheet'></i><a href="<?=  getPath() ?>/admin/dashboard"><?= LanguageFactory::getLocalized("navigation.dashboard") ?></a></li>
                <?php endif; ?>
                <li><i class='bx bx-log-out-circle'></i><a href="<?=  getPath() ?>/logout"><?= LanguageFactory::getLocalized("navigation.logout") ?></a></li>
              </ul>
            </li>
          <?php endif; ?>
          <li>
            <a href="<?= ROOT ?>/cart"><?= LanguageFactory::getLocalized("navigation.cart") ?> <i class="bx bx-cart"></i><span class="cart-items">0</span></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- END OF NAVBAR -->

  <div class="alerts"></div>
  <?php if (Auth::logged_in()) : ?>
    <div class="profile-modal">
      <div class="profile-modal-content">
        <div class="modal-heading">
          <h2>Editace profilu</h2>
          <span class="close-modal close-modal-profile"><i class='bx bx-window-close'></i></span>
        </div>
        <div class="profile-form-wrapper">
          <form method="POST" enctype="multipart/form-data">
            <div class="profile-img">
              <img id="modal_img" src="<?= get_image(esc(Auth::getImage())); ?>" alt="profile image">
              <input onchange="document.getElementById('modal_img').src = window.URL.createObjectURL(this.files[0])" type="file" name="image" id="modal_img_input">
              <small class="text-danger" id="js-profile-error-image"></small>
            </div>
            <div class="input-holder">
              <div class="item">
                <label for="firstname">Jméno </label>
                <input type="text" name="firstname" value="<?= set_value(null, esc(Auth::getFirstname())) ?>">
                <small class="text-danger" id="js-profile-error-firstname"></small>
              </div>
              <div class="item">
                <label for="lastname">Příjmení </label>
                <input type="text" name="lastname" value="<?= set_value(null, esc(Auth::getLastname())) ?>">
                <small class="text-danger" id="js-profile-error-lastname"></small>
              </div>
              <div class="item">
                <label for="email">E-mail </label>
                <input type="text" name="email" value="<?= set_value(null, esc(Auth::getEmail())) ?>">
                <small class="text-danger" id="js-profile-error-email"></small>
              </div>
              <div class="item">
                <label for="gender">Pohlaví </label>
                <select name="gender">
                  <option value="">Select your gender</option>
                  <option <?= set_select(null, 'male', esc(Auth::getGender()) ?? "") ?> value="male">Muž</option>
                  <option <?= set_select(null, 'female', esc(Auth::getGender()) ?? "") ?> value="female">Žena</option>
                  <option <?= set_select(null, 'other', esc(Auth::getGender()) ?? "") ?> value="other">Jiné</option>
                </select>
                <small class="text-danger" id="js-profile-error-gender"></small>
              </div>
              <div class="item">
                <label for="country">Země</label>
                <select name="country">
                  <option value="">Vyberte si svoji zemi</option>
                  <option <?= set_select(null, 'czechia', esc(!empty(Auth::getAddress()[0]->country) ? Auth::getAddress()[0]->country : "")) ?> value="czechia">Česko</option>
                  <option <?= set_select(null, 'slovakia', esc(!empty(Auth::getAddress()[0]->country) ? Auth::getAddress()[0]->country : "")) ?> value="slovakia">Slovensko</option>
                </select>
                <small class="text-danger" id="js-profile-error-country"></small>
              </div>
              <div class="item">
                <label for="street">Ulice</label>
                <input type="text" name="street" value="<?= set_value(null, esc(!empty(Auth::getAddress()[0]->street) ? Auth::getAddress()[0]->street : "")) ?>">
                <small class="text-danger" id="js-profile-error-street"></small>
              </div>
              <div class="item">
                <label for="town">Město</label>
                <input type="text" name="town" value="<?= set_value(null, esc(!empty(Auth::getAddress()[0]->town) ? Auth::getAddress()[0]->town : "")) ?>">
                <small class="text-danger" id="js-profile-error-town"></small>
              </div>
              <div class="item">
                <label for="postcode">PSČ</label>
                <input type="text" name="postcode" value="<?= set_value(null, esc(!empty(Auth::getAddress()[0]->postcode) ? Auth::getAddress()[0]->postcode : "")) ?>">
                <small class="text-danger" id="js-profile-error-postcode"></small>
              </div>
              <h3>Změna hesla</h3>
              <div class="item">
                <label for="heslo">Nové heslo</label>
                <input type="password" name="password">
                <small class="text-danger" id="js-profile-error-password"></small>
              </div>
              <div class="item">
                <label for="heslo">Heslo znovu</label>
                <input type="password" name="retype_password">
                <small class="text-danger" id=""></small>
              </div>
            </div>
            <div id="profile-submit-button" class="profile-submit">
              <span class="btn-submit">Potvrdit</span>
            </div>
          </form>
        </div>
      </div>
    </div>

  <?php endif; ?>