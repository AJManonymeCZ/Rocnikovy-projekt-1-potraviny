<?php $this->view('admin/adminHeader', $data); ?>
<!-- MAIN CONTENT -->
<section>
  <!--  -->
  <div class="cards">
    <a href="<?= ROOT ?>/admin/users">
      <div class="card">
        <div class="card-content">
          <div class="number"><?= $users_count ?? 0 ?></div>
          <div class="card-name">Users</div>
        </div>
        <div class="icon">
          <i class="bx bx-user-check"></i>
        </div>
      </div>
    </a>
    <a href="<?= ROOT ?>/admin/categories">
      <div class="card">
        <div class="card-content">
          <div class="number"><?= $categories_count ?? 0 ?></div>
          <div class="card-name">Categories</div>
        </div>
        <div class="icon">
          <i class="bx bx-credit-card-alt"></i>
        </div>
      </div>
    </a>
    <a href="<?= ROOT ?>/admin/products">
      <div class="card">
        <div class="card-content">
          <div class="number"><?= $products_count ?></div>
          <div class="card-name">Products</div>
        </div>
        <div class="icon">
          <i class='bx bxl-product-hunt'></i>
        </div>
      </div>
    </a>
    <a href="<?= ROOT ?>/admin/orders">
      <div class="card">
        <div class="card-content">
          <div class="number"><?= $orders_count ?? 0 ?></div>
          <div class="card-name">Orders</div>
        </div>
        <div class="icon">
          <i class='bx bx-purchase-tag-alt'></i>
        </div>
      </div>
    </a>
  </div>

  <!-- TABLE -->
  <div class="tables">
    <div class="last-categories">
      <div class="heading">
        <h2>Last Categories</h2>
        <a href="<?= ROOT ?>/admin/categories" class="btn">View All</a>
      </div>
      <table class="categories">
        <thead>
          <td>ID</td>
          <td>Category name</td>
          <td>Active</td>
          <td>Slug</td>
          <td>Actions</td>
        </thead>
        <tbody>
          <?php if (!empty($categories)) : ?>
            <?php foreach ($categories as $cat) : ?>
              <tr>
                <td><?= esc($cat->id) ?></td>
                <td><?= esc($cat->category) ?></td>
                <td><?= esc($cat->disabled) ? "No" : "Yes" ?></td>
                <td><?= esc($cat->slug) ?></td>
                <td>
                  <div class="table-icon">
                    <!-- <a href="<?= ROOT ?>/admin/categories"><i class="bx bx-show"></i></a> -->
                    <a href="<?= ROOT ?>/admin/categories/edit/ <?= $cat->id ?>"><i class="bx bx-edit-alt"></i></a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="last-users">
      <div class="heading">
        <h2>Last users</h2>
        <a href="<?= ROOT ?>/admin/users" class="btn">View All</a>
      </div>
      <table class="users">
        <thead>
          <td>ID</td>
          <td>Photo</td>
          <td>Name</td>
          <td>Banned</td>
          <td>Actions</td>
        </thead>
        <tbody>
          <?php if (!empty($users)) : ?>
            <?php foreach ($users as $user) : ?>
              <tr>
                <td><?= $user->id ?></td>
                <td>
                  <div class="img-box-small">
                    <img src="<?= get_image($user->image) ?>" alt="user_image" />
                  </div>
                </td>
                <td><?= esc($user->firstname) ?> <?= esc($user->lastname) ?></td>
                <td><?= esc($user->banned ? "YES" : "NO") ?></td>
                <td>
                  <div class="table-icon">
                    <!-- <a href="<?= ROOT ?>/admin/users"><i class="bx bx-show"></i></a> -->
                    <a href="<?= ROOT ?>/admin/users/edit/<?= $user->id ?>"><i class="bx bx-edit-alt"></i></a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- END OF TABLE -->
</section>

<?php $this->view('admin/adminFooter', $data); ?>