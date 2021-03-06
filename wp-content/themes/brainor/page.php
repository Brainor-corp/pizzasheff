<?php
/**
 * Шаблон обычной страницы (page.php)
 * @package WordPress
 * @subpackage brainor
 */
get_header(); // подключаем header.php ?>
    <section>
        <div class="container py-4">
            <div class="row">
                <?php if ( have_posts() ) while ( have_posts() ) : the_post(); // старт цикла ?>
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php // контэйнер с классами и id ?>
                        <h1 class="text-white"><?php the_title(); // заголовок поста ?></h1>
                    </div>
                <div class="row">
                    <div class="col-12">
                        <?php the_content(); // контент ?>
                    </div>
                </div>
                <?php endwhile; // конец цикла ?>
            </div>
        </div>
</section>
<?php get_footer(); // подключаем footer.php ?>