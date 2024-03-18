<?php $this->view('includes/header', $data); ?>

<!-- MAIN SECTION -->
<main>
  <div class="login-container">
    <section class="login-wrapper">
      <?php if (message()) : ?>
        <div class="alert">
          <?= message("", true) ?>
        </div>
      <?php endif; ?>
      <div class="login-heading">
        <h1>Přihlásit se</h1>
        <p>
          Nový uživatel?
          <span><a href="<?= ROOT ?>/signup" class="text text-links">Vytvořte si účet</a></span>
        </p>
      </div>
      <form name="login" method="POST" class="login-form">

        <div class="input-control">
          <input type="email" name="email" id="email" class="input-field" value="<?= set_value('email') ?>" placeholder="E-mail" />
        </div>
        <div class="input-control">
          <input type="password" name="password" id="password" class="input-field" placeholder="Heslo" />
        </div>
        <div class="terms">
          <span><a href="<?= ROOT ?>/login/forgot" class="text text-links">Zapomněl/a jste heslo?</a></span>
        </div>
        <?php if (!empty($errors['email'])) : ?>
          <small class="text-danger"><?= $errors['email'] ?></small>
        <?php endif; ?>
        <div class="flex input-control">
          <button type="submit" class="btn-submit">Přihlásit se</button>
        </div>
      </form>
    </section>
  </div>
</main>
<!-- END OF MAIN SECTION -->

<!--  -->



<?php $this->view('includes/footer', $data); ?>