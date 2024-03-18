<?php $this->view('includes/header', $data); ?>
<main>
  <center>
    <h1>Děkujeme Vám za objednávku!</h1>
      <p>Vaše obejednávky možete sledovat <a style="color: #0000EE; text-decoration: underline;" href="<?= ROOT ?>/orders">zde.</a></p>
  </center>
</main>
<?php $this->view('includes/footer', $data); ?>