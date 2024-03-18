<?php $this->view('includes/header', $data); ?>

<!-- MAIN SECTION -->
<?php if ($mode == 'enter_email') : ?>
  <main>
    <div class="login-container">
      <section class="login-wrapper">
        <?php if (message()) : ?>
          <div class="alert">
            <?= message("", true) ?>
          </div>
        <?php endif; ?>
        <div class="login-heading">
          <h1>Zapomenuté heslo</h1>
        </div>
        <form name="login" action="<?= ROOT ?>/login/forgot?mode=enter_email" method="POST" class="login-form">
          <div class="input-control">
            <input type="email" name="email" id="email" class="input-field" value="<?= set_value('email') ?>" placeholder="Zadejte vaši emailovou adresu" />
          </div>
          <?php if (!empty($errors['email'])) : ?>
            <small class="text-danger"><?= $errors['email'] ?></small>
          <?php endif; ?>
          <div class="flex input-control">
            <button type="submit" class="btn-submit">Další</button>
          </div>
        </form>
      </section>
    </div>
  </main>
<?php elseif ($mode == 'enter_code') : ?>
  <main>
    <div class="login-container">
      <section class="login-wrapper">
        <?php if (message()) : ?>
          <div class="alert">
            <?= message("", true) ?>
          </div>
        <?php endif; ?>
        <div class="login-heading">
          <h1>Zapomenuté heslo</h1>
          <h4>Zadejte kód, který Vám byl zaslán na email.</h4>
        </div>
        <form name="login" action="<?= ROOT ?>/login/forgot?mode=enter_code" method="POST" class="login-form">
          <div class="input-control">
            <input type="text" name="code" class="input-field" value="<?= set_value('email') ?>" placeholder="12345" />
          </div>
          <?php if (!empty($errors['code'])) : ?>
            <small class="text-danger"><?= $errors['code'] ?></small>
          <?php endif; ?>
          <div class="btn-holder">
            <a href="<?= ROOT ?>/login/forgot">
              <button type="button" class="btn-danger">Začít znova</button>
            </a>
            <button type="submit" class="btn-primary">Další</button>
          </div>
        </form>
      </section>
    </div>
  </main>
<?php elseif ($mode == 'enter_password') : ?>
  <main>
    <div class="login-container">
      <section class="login-wrapper">
        <?php if (message()) : ?>
          <div class="alert">
            <?= message("", true) ?>
          </div>
        <?php endif; ?>
        <div class="login-heading">
          <h1>Zapomenuté heslo</h1>
          <h4>Zadejte svoje nové heslo</h4>
        </div>
        <form name="login" action="<?= ROOT ?>/login/forgot?mode=enter_password" method="POST" class="login-form">
          <div class="input-control">
            <input type="password" name="password" class="input-field" value="<?= set_value('email') ?>" placeholder="Heslo" />
          </div>
          <div class="input-control">
            <input type="password" name="retype_password" class="input-field" value="<?= set_value('email') ?>" placeholder="Heslo znovu" />
          </div>
          <?php if (!empty($errors['password'])) : ?>
            <small class="text-danger"><?= $errors['password'] ?></small>
          <?php endif; ?>
          <div class="btn-holder">
            <a href="<?= ROOT ?>/login/forgot">
              <button type="button" class="btn-danger">Začít znova</button>
            </a>
            <button type="submit" class="btn-primary">Další</button>
          </div>
        </form>
      </section>
    </div>
  </main>
<?php endif; ?>
<!-- END OF MAIN SECTION -->

<?php $this->view('includes/footer', $data); ?>