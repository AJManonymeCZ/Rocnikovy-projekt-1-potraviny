<?php $this->view('includes/header', $data); ?>

<!-- MAIN PRODUCT SECTION -->
<main>
  <div id="fullpage">
    <span class="fullpage-close"><i class='bx bx-x-circle'></i></span>
  </div>
  <?php if (isset($product)) : ?>
    <div class="product-holder">
      <div id="img-box" class="product-image-box">
        <img src="<?= get_image($product->product_image) ?>" alt="product" />
      </div>
      <div class="product-info">
        <div class="product-heading">
          <h1><?= esc($product->name) ?></h1>
          <h5><?= esc($product->category_name) ?></h5>
        </div>
        <div class="product-body">
          <div class="price"><?= esc($product->price) ?> Kč</div>
        </div>
          <div class="qty-input">
              <button class="qty-count qty-count--minus" onclick="minisQ(event)" data-action="minus" type="button">-</button>
              <input class="product-qty" type="number" name="product-qty" min="1" max="10" value="1">
              <button class="qty-count qty-count--add" onclick="addQ(event)" data-action="add" type="button">+</button>
          </div>
        <div class="btn-holder">
          <button class="item-btn" onclick="cart.add(<?= $product->id ?>, event)">Add to cart</button>
        </div>
      </div>
      <div class="product-description">
        <h2>Popis produktu</h2>
        <p>
          <?= esc($product->description) ?>
        </p>
      </div>
    </div>

  <section class="comments" >
      <div style="display: none" class="comment-html-holder"></div>
      <hr>
      <div class="comments-title">
          <h1>Komentáře</h1>
      </div>
          <div id="comments-holder" class="comments-container">
              <?php if(!empty($comments)): $a = false?>
                      <?php foreach ($comments as $comment): ?>
                          <div class="comment" data-id="<?= $comment->id ?>" style="width: 100%">
                              <div class="header">
                                  <div class="img-holder">
                                      <img src="<?= get_image(esc($comment->image)) ?>" alt="">
                                  </div>
                                  <div class="user-details">
                                      <p><?= esc(ucfirst($comment->firstname)) ?> <?= esc(ucfirst($comment->lastname)) ?></p>
                                      <span><?= esc($comment->diff_date) ?></span>
                                  </div>
                                    <?php if(Auth::logged_in()): ?>
                                        <div class="actions">
                                            <?php if($comment->is_mine): ?>
                                                <div class="edit-delete">
                                                    <span onclick="comments.editComment(<?= $comment->id ?>)"><i class='bx bx-edit-alt'></i></span>
                                                    <span onclick="comments.deleteComment(<?= $comment->id ?>)"><i class='bx bx-message-alt-x' ></i></span>
                                                </div>
                                            <?php endif; ?>
                                            <div class="replay-to"><span onclick="comments.collectData(event,<?= $comment->product_id ?>, <?= $comment->id ?>)" ><br> <i class='bx bx-share'></i></span></div>
                                        </div>
                                    <?php endif; ?>
                              </div>
                              <div class="content">
                                  <p><?= esc($comment->content) ?></p>
                              </div>
                          </div>

                            <?php echo(display_under_comment($comment)); ?>
                      <?php endforeach; ?>

              <?php else: $a = true?>
                    <?php if(!Auth::logged_in()): ?>
                        <p class="text-center mb">Ješte nikdo nenpsal komentář o tomto produktu, přihlašte se a buďte první kdo okomentuje tento produkt.</p>
                    <?php endif; ?>
              <?php endif; ?>
          </div>
      <?php if(!Auth::logged_in()): ?>
          <?php if(!$a): ?>
            <p class="text-center mb" >Pro psaní komentářů musíte být přihlášeni.</p>
          <?php endif; ?>
      <?php else : ?>
          <div class="leave-comment">
              <div class="header">
                  <div class="img-holder">
                      <img src="<?= get_image(Auth::getImage()) ?>" alt="">
                  </div>
                  <div class="user-details">
                      <p><?= ucfirst(Auth::getFirstname()) ?> <?= ucfirst(Auth::getLastname()) ?></p>
                  </div>
              </div>
              <div class="message">
                  <textarea rows="10" placeholder="Váš komentář..."></textarea>
              </div>
              <div class="add-comment">
                  <button onclick="comments.collectData(event, <?= $product->id ?>)">Přídat komentář</button>
              </div>
          </div>
      <?php endif; ?>
  </section>

    <section class="products">
      <hr />
      <div class="products-title">
        <h1>Nejprodávanější produkty</h1>
      </div>
      <div class="product-container">
        <?php if (!empty($products)) : ?>
          <?php foreach ($products as $product) : ?>
            <!-- PRODUCT -->
            <div class="item">
              <a href="<?= ROOT ?>/product/<?= $product->product_slug ?>">
                <img src="<?= get_image(esc($product->product_image)) ?>" alt="<?= esc($product->name) ?>" class="photo" />
              </a>
              <div class="item-info">
                <div class="item-header">
                  <span class="category"><?= esc($product->category) ?></span>
                  <h4 class="title"><?= esc($product->name) ?></h4>
                </div>
                <div class="item-body">
                  <div class="price"><?= esc($product->price) ?> Kč</div>
                  <button type="button" class="item-btn" onclick="cart.add(<?= $product->id ?>)">
                    Přidat do košíku</button>
                </div>
              </div>
            </div>
            <!-- END OF PRODUCT -->
          <?php endforeach; ?>
        <?php else : ?>
          <span>Žádne prokdukty se nenašly!</span>
        <?php endif; ?>
      </div>
    </section>
  <?php else : ?>
    No record found!
  <?php endif; ?>
</main>
<!-- END OF MAIN PRODUCT SECTION -->
<script src="<?= ROOT ?>/assets/js/fullpage.js"></script>
<?php $this->view('includes/footer', $data); ?>