<?php $this->view('includes/header', $data); ?>
<!-- ORDER MODAL -->
<div class="order-modal">

</div>
<!-- END OF ORDER MODAL -->

<!-- MAIN SECTION ORDERS -->
<main>
  <div class="cart-container">
    <div class="cart-wrapper">
      <div class="heading">
        <h1>Váše objednávky</h1>
        <div>
          <i class='bx bx-arrow-back'></i>
          <a href="<?= ROOT ?>/shop">Zpátky nakupovat</a>
        </div>
      </div>
      <div>

        <table cellspacing="0" id="js-orders" class="orders">
          <thead>
            <tr>
              <th>ID</th>
              <th>Datum</th>
              <th>Metoda placení</th>
              <th>Status</th>
              <th>Celkem</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($orders)) : ?>
              <?php foreach ($orders as $order) : ?>
                <tr onclick="order.show(<?= $order->id ?>)">
                  <td><?= esc($order->id) ?></td>
                  <td><?= esc(date("Y m d", strtotime($order->order_date))) ?></td>
                  <td><?= esc($order->payment_method) ?></td>
                  <td><?= esc($order->status) ?></td>
                  <td><?= esc($order->amount) ?> Kč</td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="5">Zatím nemáte žádné objednávky.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <?php $pager->display() ?>

      </div>
    </div>
  </div>
</main>
<!-- END MAIN SECTION ORDERS -->

<?php $this->view('includes/footer', $data); ?>