<?php $this->view('includes/header', $data); ?>

<!-- MAIN SECTION  -->
<main>
  <div class="contact-container">
    <div class="contact-wrapper">
      <div class="contact-heading">
        <h1>GET IN TOUCH</h1>
        <label for="phone">Telefon</label>
        <div class="phone"><i class="bx bx-phone"></i> +420 777 888 999</div>
        <label for="email">E-mail</label>
        <div class="email"><i class="bx bx-envelope"></i> bestEhsop@gmail.com</div>
        <label for="address">Adresa</label>
        <div class="address">
          <i class="bx bx-map"></i> Jiřího Potůčka 259, 530 09
          Pardubice II
        </div>
      </div>
      <?php if (message()) : ?>
        <div class="alert">
          <?= message("", true) ?>
        </div>
      <?php endif; ?>
      <div class="content">
        <form method="post">
          <div class="input-control-container">
            <div class="input-control-wrapper">
              <div class="input-control">
                <input type="hidden" name="g-token" id="g-token-contact">
                <input type="text" name="name" id="name" class="input-field" value="<?= esc(set_value("name")) ?>" placeholder="Vaše jméno" required />
              </div>
              <?php if (!empty($errors["name"])) : ?>
                <small class="text-danger"><?= $errors['name'] ?></small>
              <?php endif; ?>
              <div class="input-control">
                <input type="email" name="email" id="email" class="input-field" value="<?= esc(set_value("email")) ?>" placeholder="Váš E-mail" required />
              </div>
              <?php if (!empty($errors["email"])) : ?>
                <small class="text-danger"><?= $errors['email'] ?></small>
              <?php endif; ?>
            </div>
            <div>
              <textarea name="description" id="" cols="45" rows="8" placeholder="Vaše zpráva..." required><?= esc(set_value("description")) ?></textarea>
            </div>
            <?php if (!empty($errors["description"])) : ?>
              <small class="text-danger"><?= $errors['description'] ?></small>
            <?php endif; ?>
          </div>
          <div class="input-control">
            <button type="submit" class="btn-submit">Poslat</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>
<!-- END OF MAIN SECTION  -->

<?php $this->view('includes/footer', $data); ?>