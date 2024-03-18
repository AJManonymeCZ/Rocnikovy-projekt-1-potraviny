<?php $this->view('includes/header', $data); ?>

<!-- END OF NAVBAR -->
<main>
  <div class="login-container">
    <section class="login-wrapper">
      <div class="login-heading">
        <h1>Zaregistrovat se</h1>
        <p>
          Máte již účet?
          <span><a href="<?= ROOT ?>/login" class="text text-links">Přihlaste se</a></span>
        </p>
      </div>
      <form name="login" method="POST" class="login-form">
        <input type="hidden" id="g-token-signup" name="g-token" />
        <div class="input-control">
          <input type="firstname" name="firstname" id="firstname" class="input-field" value="<?= set_value('firstname') ?>" placeholder="Jméno" />
        </div>
        <?php if (!empty($errors['firstname'])) : ?>
          <small class="text-danger"><?= $errors['firstname'] ?></small>
        <?php endif; ?>
        <div class="input-control">
          <input type="lastname" name="lastname" id="lastname" class="input-field" value="<?= set_value('lastname') ?>" placeholder="Příjmení" />
        </div>
        <?php if (!empty($errors['lastname'])) : ?>
          <small class="text-danger"><?= $errors['lastname'] ?></small>
        <?php endif; ?>
        <div class="input-control">
          <input type="email" name="email" id="email" class="input-field" value="<?= set_value('email') ?>" placeholder="E-mail" />
        </div>
        <?php if (!empty($errors['email'])) : ?>
          <small class="text-danger"><?= $errors['email'] ?></small>
        <?php endif; ?>
        <div class="input-control">
          <input type="password" name="password" id="password" class="input-field" placeholder="Heslo" />
        </div>
        <?php if (!empty($errors['password'])) : ?>
          <small class="text-danger"><?= $errors['password'] ?></small>
        <?php endif; ?>
        <div class="input-control">
          <input type="password" name="confirm_password" id="confirm_password" class="input-field" placeholder="Heslo znovu" />
        </div>
        <?php if (!empty($errors['confirm_password'])) : ?>
          <small class="text-danger"><?= $errors['confirm_password'] ?></small>
        <?php endif; ?>
        <div class="terms">
          <input type="checkbox" name="terms" <?= set_checked('terms', 'on') ?> id="terms">
          <p>Souhlasím a příjmám <a href="<?= ROOT ?>/about">pravidla a podmínky.</a></p>
        </div>
        <?php if (!empty($errors['terms'])) : ?>
          <small class="text-danger"><?= $errors['terms'] ?></small>
        <?php endif; ?>
        <div class="flex input-control">
          <button type="submit" class="btn-submit">Registrovat se</button>
        </div>
      </form>
    </section>
  </div>
</main>
<!-- MAIN SECTION  -->


<?php $this->view('includes/footer', $data); ?>