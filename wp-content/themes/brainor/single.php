<?php
/**
 * Шаблон отдельной записи (single.php)
 * @package WordPress
 * @subpackage brainor
 */
get_header(); // подключаем header.php ?>
<section>
	<div class="container py-4">
		<div class="row">
			<div class="col-12 bg-white">
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); // старт цикла ?>
					<div class="row p-4">
                        <div class="col-12 p-2">
                            <?php
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
                            ?>
                            <hr>
                        </div>
                        <div class="col-md-4 col-12">
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="" class="img-fluid w-100">
                        </div>
                        <div class="col">
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php // контэйнер с классами и id ?>
                                <h1><?php the_title(); // заголовок поста ?></h1>
                                <?php the_content(); // контент ?>
                            </article>
                        </div>
                    </div>
				<?php endwhile; // конец цикла ?>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); // подключаем footer.php ?>
