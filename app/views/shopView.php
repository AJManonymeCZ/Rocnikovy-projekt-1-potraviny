<?php $this->view('includes/header', $data); ?>

<!-- SHOP SECTION -->
<div class="content-wrapper-shop">
  <aside class="sidebar">
    <div class="sidebar-inner">
      <div class="categories-wrapper">
        <div class="shop-dropdown active">
          <button type="button"><i class='bx bx-chevron-down'></i></button>
          <input type="text" id="searchBox" onclick="search.click(this)" oninput="search.input(this)" value="<?= isset($category_name) ? $category_name : 'Vyberte si kategorii' ?>" style="color: #fff" />
          <div class="option">
            <?php if (isset($categories)) : ?>
              <?php foreach ($categories as $key => $cat) : ?>
                <a href="<?= ROOT ?>/shop?category=<?= $cat->slug ?>">
                  <div><?= $cat->category; ?></div>
                </a>
              <?php endforeach; ?>
            <?php else : ?>
              <div>Žádne kategorie se nenašli!</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </aside>
  <main id="content" class="content">
    <div class="category-top">
      <h3><?= isset($category_name) ? $category_name : 'Nejvíce prodávané produkty' ?></h3>
    </div>
    <div class="category-content-wrapper">
      <div id="shop-products" class="product-container">

        <?php if (!empty($products)) : ?>
          <?php foreach ($products as $product) : ?>
            <!-- PRODUCT -->
            <div class="item">
              <a href="<?= ROOT ?>/product/<?= $product->slug ?>">
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
    </div>
  </main>
</div>
<!-- END OF SHOP SECTION -->


<?php $this->view('includes/footer', $data); ?>