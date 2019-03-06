<?php
/**
 * Created by PhpStorm.
 * User: sumerk
 * Date: 18.02.2019
 * Time: 12:35
 */
?>

<?php
$orderby = 'name';
$order = 'asc';
$hide_empty = false ;
$cat_args = array(
    'orderby'    => $orderby,
    'order'      => $order,
    'hide_empty' => $hide_empty,
);

$product_categories = get_terms( 'product_cat', $cat_args );
?>
<?php foreach ($product_categories as $key => $category): ?>
    <?php if($category->name === 'Uncategorized'): continue; endif ?>
    <li class="list-item mr-2 mb-2">
        <a href="<?php echo get_term_link($category) ?>"><stong style="font-weight: 600"><?php echo $category->name ?></stong></a>
    </li>
<?php endforeach ?>

<?php //echo do_shortcode('[menu menu="header-product-menu"]'); ?>
