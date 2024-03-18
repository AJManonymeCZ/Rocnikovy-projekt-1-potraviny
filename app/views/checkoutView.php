<?php $this->view('includes/header', $data); ?>

<!-- SECTION CHECKOUT -->
<main>
  <div class="checkout-container">
    <div class="checkout-wrapper">
      <div class="heading">
        <h1>Pokladna</h1>
        <div>
          <i class="bx bx-arrow-back"></i>
          <a href="<?= ROOT ?>/cart">Zpátky do košíku</a>
        </div>
      </div>
      <div class="checkout-content">
        <form method="POST" id="checkout-details">
          <h3>
            Zadejte podrobnosti objednávky</h3>
          <div class="user-details">
            <div class="input-holder">
              <label for="firstname">Jméno</label>
              <input type="text" name="firstname" placeholder="Vladislav" value="<?= esc(set_value('firstname', Auth::getFirstname())) ?>" required>
              <?php if (!empty($errors['firstname'])) : ?>
                <small class="text-danger"><?= $errors['firstname'] ?></small>
              <?php endif; ?>
            </div>
            <div class="input-holder">
              <label for="lastname">Přímení</label>
              <input type="text" name="lastname" placeholder="Potůčka" value="<?= esc(set_value('lastname', Auth::getLastname())) ?>" required>
              <?php if (!empty($errors['lastname'])) : ?>
                <small class="text-danger"><?= $errors['lastname'] ?></small>
              <?php endif; ?>
            </div>
            <div class="input-holder">
              <label for="email">E-mail</label>
              <input type="email" name="email" placeholder="priklad@priklad.com" value="<?= esc(set_value('email', Auth::getEmail())) ?>" required>
              <?php if (!empty($errors['email'])) : ?>
                <small class="text-danger"><?= $errors['email'] ?></small>
              <?php endif; ?>
            </div>
            <div class=" input-holder">
              <label for="street">Ulice</label>
              <input type="text" name="street" placeholder="Ulice 336" value="<?= esc(set_value('street', Auth::getAddress()[0]->street ?? '')) ?>" required>
              <?php if (!empty($errors['street'])) : ?>
                <small class="text-danger"><?= $errors['street'] ?></small>
              <?php endif; ?>
            </div>
            <div class="input-holder">
              <label for="town">Město</label>
              <input type="text" name="town" placeholder="Praha" value="<?= esc(set_value('town', Auth::getAddress()[0]->town ?? '')) ?>" required>
              <?php if (!empty($errors['town'])) : ?>
                <small class="text-danger"><?= $errors['town'] ?></small>
              <?php endif; ?>
            </div>
            <div class="input-holder">
              <label for="postcode">PSČ</label>
              <input type="text" name="postcode" placeholder="5555 06" value="<?= esc(set_value('postcode', Auth::getAddress()[0]->postcode ?? '')) ?>" required>
              <?php if (!empty($errors['postcode'])) : ?>
                <small class="text-danger"><?= $errors['postcode'] ?></small>
              <?php endif; ?>
            </div>
            <div class="input-holder">
              <label for="country">Země</label>
              <select name="country" required>
                <option value="">Vyberte si zemi</option>
                <option <?= esc(set_select('country', 'czechia', Auth::getAddress()[0]->country ?? '')) ?> value="czechia">Česko</option>
                <option <?= esc(set_select('country', 'slovakia', Auth::getAddress()[0]->country ?? '')) ?> value="slovakia">Slovensko</option>
              </select>
              <?php if (!empty($errors['country'])) : ?>
                <small class="text-danger"><?= $errors['country'] ?></small>
              <?php endif; ?>
            </div>

            <div class="checkbox-holder">
              <label for="payment_method">Kartou</label>
              <input type="radio" name="payment_method" id="card_input" <?= set_checked('payment_method', 'card') ?> value="card" required>
            </div>
            <div class="checkbox-holder">
              <label for="payment_method">PayPal</label>
              <input type="radio" name="payment_method" id="paypal_input" <?= set_checked('payment_method', 'paypal') ?> value="paypal">
            </div>
          </div>
          <?php if (!empty($errors['payment_method'])) : ?>
            <small class="text-danger"><?= $errors['payment_method'] ?></small>
          <?php endif; ?>
          <?php if (!empty($errors['error_amount'])) : ?>
            <small class="text-danger"><?= $errors['error_amount'] ?></small>
          <?php endif; ?>
        </form>
        <div class="items-in-cart">
          <h3>Vaše produkty</h3>
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Jméno produktu</th>
                <th>Množství</th>
                <th>Cena</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($CART)) : ?>
                <?php foreach ($CART as $key => $product) : ?>
                  <tr>
                    <td><?= $num = $key + 1 ?></td>
                    <td><?= $product['row']->name ?></td>
                    <td><?= $product['qty'] ?></td>
                    <td><?= number_format($product['row']->price * $product['qty'], 2, '.', ' ') ?> Kč</td>
                  </tr>
                <?php endforeach; ?>
                <tr>
                  <td></td>
                  <td></td>
                  <td><b>Celkem:</b></td>
                  <td><b><?= number_format($total, 2, ".", " ") ?? 0 ?> Kč</b></td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>

        </div>
      </div>
      <div class="btn-holder">
        <button type="submit" class="btn-primary" form="checkout-details">Pokračovat</button>
      </div>
    </div>
  </div>
</main>
<!-- END OF MAIN SECTION CHECKOUT -->


<?php $this->view('includes/footer', $data); ?>