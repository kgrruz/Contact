<?php echo theme_view('header'); ?>

<?php echo theme_view('_sitenav'); ?>


  <div class="container-fluid pt-3">


        <div class="mb-3"><?php Template::block('sub_nav', ''); ?></div>



              <?php echo Template::message(); ?>

<?php echo show_painel_widgets('left_aside_admin'); ?>

  <?php echo isset($content) ? $content : Template::content(); ?>



</div>


<?php
    echo theme_view('footer');
    ?>
