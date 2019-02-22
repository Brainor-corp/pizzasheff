<?php
/**
 * Шаблон отдельной записи (single.php)
 * @package WordPress
 * @subpackage brainor
 */
get_header(); // подключаем header.php ?>

<?php
    $isProduct = isset($product); // Страница продукта немного отличается от прочих single-страниц
?>
<section>
	<div class="container py-4">
		<div class="row">
			<div class="col-12 bg-white">
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); // старт цикла ?>
					<div class="row p-md-4">
                        <div class="col-12 p-2">
                            <?php
                                if(!$isProduct) {
                                    $categories = get_the_category();
                                    $separator = ' / ';
                                    $output = '<a class="text-dark" href="/">Главная</a> / ';
                                    if ( ! empty( $categories ) ) {
                                        foreach( $categories as $category ) {
                                            $output .= '<a class="text-dark" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
                                        }
                                        echo $output;
                                    }
                                    echo '<a class="text-dark" href="#">' . the_title() . '</a>';
                                }
                            ?>
                            <hr>
                        </div>
                        <?php if(!$isProduct && !empty(get_the_post_thumbnail_url())): ?>
                            <div class="col-md-4 col-12">
                                <img src="<?php the_post_thumbnail_url(); ?>" alt="" class="img-fluid w-100">
                            </div>
                        <?php endif; ?>
                        <div class="col">
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php // контэйнер с классами и id ?>
                                <h1 class="text-orange"><?php the_title(); // заголовок поста ?></h1>
                                <?php the_content(); // контент ?>
                            </article>
                        </div>
                    </div>
				<?php endwhile; // конец цикла ?>
			</div>
            <?php if($isProduct): ?>
                <div class="col-12">
                    <?php
                    /**
                     * Hook: woocommerce_after_single_product_summary.
                     *
                     * @hooked woocommerce_output_product_data_tabs - 10
                     * @hooked woocommerce_upsell_display - 15
                     * @hooked woocommerce_output_related_products - 20
                     */
                    do_action( 'woocommerce_after_single_product_summary' );
                    ?>
                </div>
            <?php endif; ?>
		</div>
	</div>
</section>
<?php get_footer(); // подключаем footer.php ?>
