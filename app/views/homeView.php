<?php $this->view('includes/header', $data); ?>
<!-- HERO/SLIDER SECTION -->
<section class="slider">


  <?php foreach ($sliders as $slide) : ?>
    <!-- SLIDE -->
    <div class="slide fade">
      <img src="<?= get_image(esc($slide->image)) ?>" alt="<?= esc($slide->title) ?>" />
      <div class="product">
        <h1 class="product-title"><?= esc($slide->title) ?></h1>
        <div class="product-desc">
          <p><?= esc($slide->description) ?></p>
        </div>
      </div>
    </div>
    <!-- END OF SLIDE -->
  <?php endforeach; ?>


  <div class="move-buttons">
    <button class="prev">❮</button>
    <button class="next">❯</button>
  </div>

  <div class="dots"></div>
</section>
<!-- END OF HERO/SLIDER SECTION -->

<!-- MAIN SECTION -->
<main class="products">
  <div class="products-title">
    <h1>Nejvíce prohlížené produkty</h1>
  </div>
  <div class="product-container">
    <?php foreach ($most_viewed_products as $product) : ?>
      <!-- PRODUCT -->
      <div class="item">
        <a href="<?= ROOT ?>/product/<?= $product->slug ?>">
          <img src="<?= get_image(esc($product->product_image)) ?>" alt="<?= esc($product->name) ?>" class="photo" />
        </a>
        <div class="item-info">
          <div class="item-header">
            <span class="category"><?= esc($product->category_name) ?></span>
            <h4 class="title"><?= esc($product->name) ?></h4>
          </div>
          <div class="item-body">
            <div class="price"><?= esc($product->price) ?> Kč</div>
            <button type="button" class="item-btn" onclick="cart.add(<?= $product->id ?>)">Přidat do košíku</button>
          </div>
        </div>
      </div>
      <!-- END OF PRODUCT -->
    <?php endforeach; ?>
  </div>
  <div class="products-title">
    <h1>Nedávno přidané produkty</h1>
  </div>
  <div class="product-container">
    <?php foreach ($latest_products as $product) : ?>
      <!-- PRODUCT -->
      <div class="item">
        <a href="<?= ROOT ?>/product/<?= esc($product->slug) ?>">
          <img src="<?= get_image(esc($product->product_image)) ?>" alt="<?= esc($product->name) ?>" class="photo" />
        </a>
        <div class="item-info">
          <div class="item-header">
            <span class="category"><?= esc($product->category_name) ?></span>
            <h4 class="title"><?= esc($product->name) ?></h4>
          </div>
          <div class="item-body">
            <div class="price"><?= esc($product->price) ?> Kč</div>
            <button type="button" class="item-btn" onclick="cart.add(<?= $product->id ?>)">Přidat do košíku</button>
          </div>
        </div>
      </div>
      <!-- END OF PRODUCT -->
    <?php endforeach; ?>
  </div>
</main>
<!-- MAIN SECTION -->

<!-- SCRIPT SECTION -->
<script type="text/javascript">
  let numberOfDots = <?= $dots ?>;
</script>
<script type="text/javascript" src="<?= ROOT ?>/assets/js/script.js"></script>
<!-- END OF SCRIPT SECTION -->

<?php $this->view('includes/footer') ?>