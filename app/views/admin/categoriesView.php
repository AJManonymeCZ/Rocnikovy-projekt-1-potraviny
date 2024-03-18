<?php $this->view('admin/adminHeader', $data); ?>
<section class="main-content">
  <?php if (!empty($errors["id"])) : ?>
    <span><?= $errors["id"] ?></span>
  <?php elseif ($action == "add") : ?>
    <div class="wrapper">
      <div class="section">
        <h1>New Category</h1>
        <form method="POST">
          <div class="input-holder">
            <label for="name">Name</label>
            <input type="text" name="category" placeholder="Category name">
          </div>
          <?php if (!empty($errors['name'])) : ?>
            <small class="text-danger"><?= $errors['name'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="disabled">Active</label>
            <select name="disabled">
              <option value="0">Yes</option>
              <option value="1">No</option>
            </select>
          </div>
          <?php if (!empty($errors['disabled'])) : ?>
            <small class="text-danger"><?= $errors['disabled'] ?></small>
          <?php endif; ?>
          <div class="btn-holder">
            <button type="submit" class="btn-primary">Save</button>
            <a href="<?= ROOT ?>/admin/categories">
              <button type="button" class="btn-secondary">Calcel</button>
            </a>
          </div>
        </form>
      </div>
    </div>
  <?php elseif ($action == "edit") : ?>
    <div class="wrapper">
      <div class="section">
        <h1>Edit Category</h1>
        <form method="POST">
          <div class="input-holder">
            <label for="name">Name</label>
            <input type="text" name="category" placeholder="Category name" value="<?= set_value('name', esc($row->category)) ?>">
          </div>
          <?php if (!empty($errors['name'])) : ?>
            <small class="text-danger"><?= $errors['name'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="disabled">Active</label>
            <select name="disabled">
              <option <?= set_select('disabled', '0', $row->disabled) ?> value="0">Yes</option>
              <option <?= set_select('disabled', '1', $row->disabled) ?> value="1">No</option>
            </select>
          </div>
          <?php if (!empty($errors['disabled'])) : ?>
            <small class="text-danger"><?= $errors['disabled'] ?></small>
          <?php endif; ?>
          <div class="btn-holder">
            <button type="submit" class="btn-primary">Edit</button>
            <a href="<?= ROOT ?>/admin/categories">
              <button type="button" class="btn-secondary">Calcel</button>
            </a>
          </div>
        </form>
      </div>
    </div>
  <?php elseif ($action == "delete") : ?>
    <div class="wrapper">
      <div class="section">
        <h1>Delete Category</h1>
        <div class="alert-danger">
          Are you sure you want to delete this category?!
        </div>
        <form method="POST">
          <div class="input-holder">
            <label for="name">Name</label>
            <input type="text" name="category" placeholder="Category name" value="<?= set_value('name', esc($row->category)) ?>" disabled>
          </div>
          <?php if (!empty($errors['name'])) : ?>
            <small class="text-danger"><?= $errors['name'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="disabled">Active</label>
            <select name="disabled" disabled>
              <option <?= set_select('disabled', '0', $row->disabled) ?> value="0">Yes</option>
              <option <?= set_select('disabled', '1', $row->disabled) ?> value="1">No</option>
            </select>
          </div>
          <?php if (!empty($errors['disabled'])) : ?>
            <small class="text-danger"><?= $errors['disabled'] ?></small>
          <?php endif; ?>
          <div class="btn-holder">
            <button type="submit" class="btn-danger">Delete</button>
            <a href="<?= ROOT ?>/admin/categories">
              <button type="button" class="btn-secondary">Calcel</button>
            </a>
          </div>
        </form>
      </div>
    </div>
  <?php else : ?>

    <div class="table">
      <div class="last-categories">
        <?php if (message()) : ?>
          <div class="alert">
            <?= message("", true) ?>
          </div>
        <?php endif; ?>
        <div class="heading">
          <h2>Categories</h2>
          <a href="<?= ROOT ?>/admin/categories/add" class="btn"><i class='bx bx-plus'></i>New Category</a>
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

            <?php if ($rows) : ?>
              <?php foreach ($rows as $row) : ?>
                <tr>
                  <td><?= $row->id ?></td>
                  <td><?= esc($row->category) ?></td>
                  <td><?= esc($row->disabled ? "No" : "Yes") ?></td>
                  <td><?= esc($row->slug) ?></td>
                  <td>
                    <div class="table-icon">
                      <a href="<?= ROOT ?>/admin/categories/edit/<?= $row->id ?>"><i class="bx bx-edit-alt"></i></a>
                      <a href="<?= ROOT ?>/admin/categories/delete/<?= $row->id ?>"><i class='bx bxs-trash'></i></a>
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
  <?php endif; ?>
</section>


<?php $this->view('admin/adminFooter', $data); ?>