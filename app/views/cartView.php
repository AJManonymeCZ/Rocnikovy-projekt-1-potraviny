<?php $this->view('includes/header', $data); ?>

<!-- MAIN SECTION SHOPPING CART -->
<main>
  <div class="cart-container">
    <div class="cart-wrapper">
      <div class="heading">
        <h1>Váš košík</h1>
        <button onclick="cart.remove_all()" class="btn-danger">Vymazat vše</button>
      </div>
      <table id="cart" cellspacing="0">
        <thead>
          <tr>
            <th>Produkt</th>
            <th>Cena</th>
            <th>Množství</th>
          </tr>
        </thead>
        <tbody>

          <?php if (!empty($CART)) : ?>
            <?php foreach ($CART as $item) : ?>
              <!-- CART ITEM -->
              <tr data-id="<?= $item['row']->id ?>">
                <td><a href="<?= ROOT ?>/product/<?= $item['row']->slug ?>">
                    <div class="item">
                      <img src="<?= get_image(esc($item['row']->product_image ?? '')) ?>" alt="product_image" />
                      <span><?= esc($item['row']->name ?? '') ?></span>
                    </div>
                  </a>
                </td>
                <td>
                  <div class="price">
                    <span><?= esc($item['row']->price ?? '') ?> Kč</span>
                  </div>
                </td>
                <td>
                  <div class="qty">
                    <input id="cart_number_input" onchange="cart.changeQty(<?= $item['id'] ?>,this)" type="number" step="1" min="1" value="<?= esc($item['qty'] ?? '') ?>">
                    <span onclick="cart.remove(<?= $item['id'] ?>)"><i class='bx bx-x-circle'></i></span>
                  </div>
                </td>
              </tr>
              <!-- END OF CART ITEM -->
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="3">Žádné produkty v košíku.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
      <hr>
      <div class="cart-bottom">
        <div>
          <i class='bx bx-arrow-back'></i>
          <a href="<?= ROOT ?>/shop">Zpátky nakupovat</a>
        </div>
        <?php if (!empty($CART)) : ?>
          <div class="total">
            <h3>Total: &nbsp</h3>
            <span><?= number_format($total, 2, ".", " ") ?? 0 ?> Kč</span>
            <a href="<?= ROOT ?>/checkout">
              <button type="submit" class="btn-primary">Pokračovat</button>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>
<!-- END MAIN SECTION SHOPPING CART -->

<?php $this->view('includes/footer', $data); ?>