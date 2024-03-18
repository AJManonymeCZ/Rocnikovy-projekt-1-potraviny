<?php $this->view('admin/adminHeader', $data); ?>

<section class="main-content">
  <?php if (!empty($errors["id"])) : ?>
    <span><?= $errors["id"] ?></span>
  <?php elseif ($action == "edit") : ?>
    <div class="wrapper">
      <div class="section">
        <h1>Edit User</h1>
        <form method="POST" enctype="multipart/form-data">
          <div class="input-holder">
            <div class="img-box-large">
              <img id="user_img" src="<?= get_image(esc($row->image)) ?>" alt="user_image" />
            </div>
            <input type="file" name="image" onchange="document.getElementById('user_img').src = window.URL.createObjectURL(this.files[0])">
          </div>
          <div class="input-holder">
            <label for="name">Firstname</label>
            <input type="text" name="firstname" placeholder="Firstname" value="<?= set_value('firstname', esc($row->firstname)) ?>">
          </div>
          <?php if (!empty($errors['firstname'])) : ?>
            <small class="text-danger"><?= $errors['firstname'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="name">Lastname</label>
            <input type="text" name="lastname" placeholder="Lastname" value="<?= set_value('lastname', esc($row->lastname)) ?>">
          </div>
          <?php if (!empty($errors['lastname'])) : ?>
            <small class="text-danger"><?= $errors['lastname'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="name">Email</label>
            <input type="text" name="email" placeholder="email" value="<?= set_value('email', esc($row->email)) ?>">
          </div>
          <?php if (!empty($errors['email'])) : ?>
            <small class="text-danger"><?= $errors['email'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="gender">Gender</label>
            <select name="gender">
              <option <?= set_select("gender", "male", $row->gender) ?> value="male">Male</option>
              <option <?= set_select("gender", "female", $row->gender) ?> value="female">Female</option>
            </select>
          </div>
          <?php if (!empty($errors['gender'])) : ?>
            <small class="text-danger"><?= $errors['gender'] ?></small>
          <?php endif; ?>
          <div class="input-holder">
            <label for="banned">Banned</label>
            <select name="banned">
              <option <?php if ($row->banned == "1") echo " selected " ?> value="1">Ban</option>
              <option <?php if ($row->banned == "0") echo " selected " ?> value="0">Unban</option>
            </select>
          </div>
          <div class="btn-holder">
            <button type="submit" class="btn-primary">Edit</button>
            <a href="<?= ROOT ?>/admin/users">
              <button type="button" class="btn-secondary">Calcel</button>
            </a>
          </div>
        </form>
      </div>
    </div>
  <?php elseif ($action == "delete") : ?>
    <div class="wrapper">
      <div class="section">
        <h1>Delete User</h1>
        <div class="alert-danger">
          Are you sure you want to delete this user?!
        </div>
        <form method="POST">
          <div class="input-holder">
            <div class="img-box-large">
              <img src="<?= get_image(esc($row->image)) ?>" alt="user_image" />
            </div>
          </div>
          <div class="input-holder">
            <label for="name">Firstname</label>
            <input type="text" name="firstname" placeholder="Firstname" disabled value="<?= set_value('firstname', esc($row->firstname)) ?>">
          </div>
          <div class="input-holder">
            <label for="name">Lastname</label>
            <input type="text" name="lastname" placeholder="Lastname" disabled value="<?= set_value('lastname', esc($row->lastname)) ?>">
          </div>
          <div class="input-holder">
            <label for="name">Email</label>
            <input type="text" name="email" placeholder="email" disabled value="<?= set_value('email', $row->email) ?>">
          </div>
          <div class="input-holder">
            <label for="gender">Gender</label>
            <select disabled name="gender">
              <option <?= set_select("gender", "male", esc($row->gender)) ?> value="male">Male</option>
              <option <?= set_select("gender", "female", esc($row->gender)) ?> value="female">Female</option>
            </select>
          </div>
          <div class="input-holder">
            <label for="banned">Banned</label>
            <select disabled name="banned">
              <option value="1">True</option>
              <option selected value="0">False</option>
            </select>
          </div>
          <div class="btn-holder">
            <button type="submit" class="btn-danger">Delete</button>
            <a href="<?= ROOT ?>/admin/users">
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
          <h2>Users</h2>
        </div>
        <table>
          <thead>
            <td>ID</td>
            <td>Photo</td>
            <td>Name</td>
            <td>Email</td>
            <td>Gender</td>
            <td>Date</td>
            <td>Verified</td>
            <td>Banned</td>
            <td>Actions</td>
          </thead>
          <tbody>
            <?php if ($rows) : ?>
              <?php foreach ($rows as $row) : ?>
                <tr>
                  <td><?= $row->id ?></td>
                  <td>
                    <div class="img-box-small">
                      <img src="<?= get_image($row->image) ?>" alt="user_image" />
                    </div>
                  </td>
                  <td><?= esc($row->firstname) ?> <?= esc($row->lastname) ?></td>
                  <td><?= esc($row->email) ?> </td>
                  <td><?= esc($row->gender) ?></td>
                  <td><?= esc($row->date) ?></td>
                  <td><?= esc($row->status ? "YES" : "NO") ?></td>
                  <td><?= esc($row->banned ? "YES" : "NO") ?></td>
                  <td>
                    <div class="table-icon">
                      <a href="<?= ROOT ?>/admin/users/edit/<?= $row->id ?>"><i class="bx bx-edit-alt"></i></a>
                      <a href="<?= ROOT ?>/admin/users/delete/<?= $row->id ?>"><i class='bx bxs-trash'></i></a>
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