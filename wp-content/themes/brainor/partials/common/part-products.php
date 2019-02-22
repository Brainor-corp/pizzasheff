<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 14.02.2019
 * Time: 11:15
 */
?>

<?php
    $products = $template_args['products'];
?>

<div class="container products-container">
    <div class="row">
        <?php foreach($products as $product): ?>
            <?php
                hm_get_template_part( 'partials/common/part-product', [ 'product' => $product ] );
            ?>
        <?php endforeach; ?>
    </div>
</div>

