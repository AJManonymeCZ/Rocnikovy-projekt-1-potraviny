<?php $this->view('admin/adminHeader', $data); ?>
<section class="main-content">
  <?php if (!empty($errors["id"])) : ?>
    <span><?= $errors["id"] ?></span>
  <?php elseif ($action == "add") : ?>
    <div class="wrapper">
      <div class="section">
        <h1>New Product</h1>
        <form method="POST" enctype="multipart/form-data">
          <div class="input-holder">
            <label for="name">Image</label>
            <div class="img-box-large">
              <img id="product_add_image" src="<?= get_image('') ?>" alt="product image">
            </div>
            <input type="file" onchange="document.getElementById('product_add_image').src = window.URL.createObjectURL(this.files[0])" name="product_image">
          </div>
          <?php if (!empty($errors['product_image'])) : ?>
            <small class="text-danger"><?= $errors['product_image'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Product name" value="<?= set_value("name") ?>">
          </div>
          <?php if (!empty($errors['name'])) : ?>
            <small class="text-danger"><?= $errors['name'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="description">Description</label>
            <textarea name="description" id="" cols="30" rows="10"><?= set_value("description") ?></textarea>
          </div>
          <?php if (!empty($errors['description'])) : ?>
            <small class="text-danger"><?= $errors['description'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="price">Price</label>
            <input type="number" name="price" min="1" step="0.01" value="<?= set_value("price") ?>">
          </div>
          <?php if (!empty($errors['price'])) : ?>
            <small class="text-danger"><?= $errors['price'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="category_id">Category</label>
            <select name="category_id">
              <option value="">Select category</option>
              <?php foreach ($categories as $cat) : ?>
                <option <?= set_select("category_id", $cat->id) ?> value="<?= $cat->id ?>"><?= esc($cat->category) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <?php if (!empty($errors['category_id'])) : ?>
            <small class="text-danger"><?= $errors['category_id'] ?></small>
          <?php endif; ?>
          <div class="btn-holder">
            <button type="submit" class="btn-primary">Save</button>
            <a href="<?= ROOT ?>/admin/products">
              <button type="button" class="btn-secondary">Calcel</button>
            </a>
          </div>
        </form>
      </div>
    </div>
  <?php elseif ($action == "edit") : ?>
    <div class="wrapper">
      <div class="section">
        <h1>Edit Product</h1>
        <form method="POST" enctype="multipart/form-data">
          <div class="input-holder">
            <label for="name">Image</label>
            <div class="img-box-large">
              <img id="product_add_image" src="<?= get_image(esc($row->product_image) ?? '') ?>" alt="product image">
            </div>
            <input type="file" onchange="document.getElementById('product_add_image').src = window.URL.createObjectURL(this.files[0])" name="product_image">
          </div>
          <?php if (!empty($errors['product_image'])) : ?>
            <small class="text-danger"><?= $errors['product_image'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Product name" value="<?= set_value("name", esc($row->name)) ?>">
          </div>
          <?php if (!empty($errors['name'])) : ?>
            <small class="text-danger"><?= $errors['name'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="description">Description</label>
            <textarea name="description" id="" cols="30" rows="10"><?= set_value("description", esc($row->description)) ?></textarea>
          </div>
          <?php if (!empty($errors['description'])) : ?>
            <small class="text-danger"><?= $errors['description'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="price">Price</label>
            <input type="number" name="price" min="1" step="0.01" value="<?= set_value("price", esc($row->price)) ?>">
          </div>
          <?php if (!empty($errors['price'])) : ?>
            <small class="text-danger"><?= $errors['price'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="category_id">Category</label>
            <select name="category_id">
              <option value="">Select category</option>
              <?php foreach ($categories as $cat) : ?>
                <option <?= set_select("category_id", $cat->id, $row->category_id) ?> value="<?= $cat->id ?>"><?= esc($cat->category) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <?php if (!empty($errors['category_id'])) : ?>
            <small class="text-danger"><?= $errors['category_id'] ?></small>
          <?php endif; ?>
          <div class="btn-holder">
            <button type="submit" class="btn-primary">Edit</button>
            <a href="<?= ROOT ?>/admin/products">
              <button type="button" class="btn-secondary">Calcel</button>
            </a>
          </div>
        </form>
      </div>
    </div>
  <?php elseif ($action == "delete") : ?>
    <div class="wrapper">
      <div class="section">
        <h1>Delete Product</h1>
        <div class="alert-danger">Are you sure, you want to delete this item ?</div>
        <form method="POST" enctype="multipart/form-data">
          <div class="input-holder">
            <label for="name">Image</label>
            <div class="img-box-large">
              <img id="product_add_image" src="<?= get_image(esc($row->product_image) ?? '') ?>" alt="product image">
            </div>
          </div>
          <div class="input-holder">
            <label for="name">Name</label>
            <input disabled type="text" name="name" placeholder="Product name" value="<?= set_value("name", esc($row->name)) ?>">
          </div>
          <div class="input-holder">
            <label for="description">Description</label>
            <textarea disabled name="description" id="" cols="30" rows="10"><?= set_value("description", esc($row->description)) ?></textarea>
          </div>
          <div class="input-holder">
            <label for="price">Price</label>
            <input disabled type="number" name="price" min="1" step="0.01" value="<?= set_value("price", esc($row->price)) ?>">
          </div>
          <div class="input-holder">
            <label for="category_id">Category</label>
            <select disabled name="category_id">
              <option value="">Select category</option>
              <?php foreach ($categories as $cat) : ?>
                <option <?= set_select("category_id", $cat->id, $row->category_id) ?> value="<?= $cat->id ?>"><?= esc($cat->category) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="btn-holder">
            <button type="submit" class="btn-secondary">Delete</button>
            <a href="<?= ROOT ?>/admin/products">
              <button type="button" class="btn-secondary">Calcel</button>
            </a>
          </div>
        </form>
      </div>
    </div>
  <?php else : ?>
    <div class="table">
      <div>
        <?php if (message()) : ?>
          <div class="alert">
            <?= message("", true) ?>
          </div>
        <?php endif; ?>
        <div class="heading">
          <h2>Products</h2>
          <a href="<?= ROOT ?>/admin/products/add" class="btn"><i class='bx bx-plus'></i>New Product</a>
        </div>
        <table>
          <thead>
            <td>ID</td>
            <td>Image</td>
            <td>Name</td>
            <td>Price</td>
            <td>Date</td>
            <td>Category</td>
            <td>slug</td>
            <td>Actions</td>
          </thead>
          <tbody>

            <?php if ($rows) : ?>
              <?php foreach ($rows as $row) : ?>
                <tr>
                  <td><?= $row->id ?></td>
                  <td>
                    <div class="img-box-small">
                      <img src="<?= get_image(esc($row->product_image)) ?>" alt="user_image" />
                    </div>
                  </td>
                  <td><?= esc($row->name) ?></td>
                  <td><?= esc($row->price) ?></td>
                  <td><?= esc($row->date) ?></td>
                  <td><?= esc($row->category_name) ?></td>
                  <td><?= esc($row->slug) ?></td>
                  <td>
                    <div class="table-icon">
                      <a href="<?= ROOT ?>/admin/products/edit/<?= $row->id ?>"><i class="bx bx-edit-alt"></i></a>
                      <a href="<?= ROOT ?>/admin/products/delete/<?= $row->id ?>"><i class='bx bxs-trash'></i></a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="7">
                  No records found!
                </td>

              </tr>
            <?php endif; ?>
          </tbody>
        </table>
        <?php $pager->display() ?>
      </div>
    </div>
  <?php endif; ?>
</section>
<?php $this->view('admin/adminFooter', $data); ?>