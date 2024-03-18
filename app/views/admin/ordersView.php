<?php $this->view("admin/adminHeader"); ?>
<?php if (!empty($errors["id"])) : ?>
  <section class="main-content">
    <span>That order is not found</span>
  </section>
<?php elseif ($action == "view") : ?>
  <section class="main-content">
    <div class="table">
      <div class="last-categories">

        <div class="heading">
          <h2>Order</h2>
        </div>
        <table class="categories">
          <thead>
            <td>ID</td>
            <td>Email</td>
            <td>Firstname</td>
            <td>Lastname</td>
            <td>Order date</td>
            <td>Paid</td>
            <td>Total</td>
          </thead>
          <tbody>
            <?php if (!empty($row)) : ?>
              <tr>
                <td><?= $row[0]->id ?></td>
                <td><?= esc($row[0]->email) ?></td>
                <td><?= esc($row[0]->firstname) ?></td>
                <td><?= esc($row[0]->lastname) ?></td>
                <td><?= esc($row[0]->order_date) ?></td>
                <td><?= esc($row[0]->paid ? "Yes" : "No") ?></td>
                <td><?= esc($row[0]->order_amount) ?></td>
              </tr>
            <?php else : ?>
              <tr>
                <td colspan="5">
                  No records found!
                </td>

              </tr>
            <?php endif; ?>
          </tbody>
        </table>
        <div class="heading">
          <h2>Products in Order</h2>
        </div>
        <table class="categories">
          <thead>
            <td>ID</td>
            <td>Product name</td>
            <td>Qty</td>
            <td>Product price</td>
            <td>Product category</td>
          </thead>
          <tbody>

            <?php if (!empty($row)) : ?>
              <?php foreach ($row as $order_product) : ?>
                <tr>
                  <td><?= $order_product->product_id ?></td>
                  <td><?= esc($order_product->name) ?></td>
                  <td><?= esc($order_product->quantity) ?></td>
                  <td><?= esc($order_product->product_price) ?></td>
                  <td><?= esc($order_product->category) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="5">
                  No records found!
                </td>

              </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <div class="heading">
          <h2>Shipping Addres</h2>
        </div>
        <table class="categories">
          <thead>
            <td>ID</td>
            <td>Town</td>
            <td>Postcode</td>
            <td>Street</td>
            <td>Country</td>
          </thead>
          <tbody>

            <?php if (!empty($row_address)) : ?>
              <?php foreach ($row_address as $order_address) : ?>
                <tr>
                  <td><?= $order_address->id ?></td>
                  <td><?= esc($order_address->town) ?></td>
                  <td><?= esc($order_address->postcode) ?></td>
                  <td><?= esc($order_address->street) ?></td>
                  <td><?= esc($order_address->country) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="5">
                  No records found!
                </td>

              </tr>
            <?php endif; ?>
          </tbody>
        </table>
        <form id="order-checked" method="POST">
          <input type="hidden" name="checked" value="1">
        </form>
        <div class="btn-holder">
          <a href="<?= ROOT ?>/admin/orders">
            <button type="button" class="btn-secondary">Back</button>
          </a>
          <?php if (!empty($row)) : ?>
            <?php if ($row[0]->status != "doručeno") : ?>
              <button type="submit" form="order-checked" class="btn-primary">Označit jako doručené</button>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

  </section>
<?php else : ?>
  <section class="main-content">
    <div class="table">
      <div class="last-categories">
        <?php if (message()) : ?>
          <div class="alert">
            <?= message("", true) ?>
          </div>
        <?php endif; ?>
        <div class="heading">
          <h2>Orders</h2>
        </div>
        <table class="categories">
          <thead>
            <td>ID</td>
            <td>Email</td>
            <td>Order date</td>
            <td>Paid</td>
            <td>Paymet Method</td>
            <td>Status</td>
            <td>Actions</td>
          </thead>
          <tbody>

            <?php if (!empty($rows)) : ?>
              <?php foreach ($rows as $row) : ?>
                <tr>
                  <td><?= $row->id ?></td>
                  <td><?= esc($row->email) ?></td>
                  <td><?= esc($row->order_date) ?></td>
                  <td><?= esc($row->paid ? "Yes" : "No") ?></td>
                  <td><?= esc($row->payment_method) ?></td>
                  <td><?= esc($row->status) ?></td>
                  <td>
                    <div class="table-icon">
                      <a href="<?= ROOT ?>/admin/orders/view/<?= $row->id ?>"><i class="bx bx-show"></i></a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="5">
                  No records found!
                </td>

              </tr>
            <?php endif; ?>
          </tbody>
        </table>
        <?= $pager->display() ?>
      </div>
    </div>


  </section>
<?php endif; ?>

<?php $this->view("admin/adminFooter"); ?>