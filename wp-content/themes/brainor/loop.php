<?php
/**
 * Запись в цикле (loop.php)
 * @package WordPress
 * @subpackage brainor
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php // контэйнер с классами и id ?>
	<div class="row mb-3">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="col-sm-3 col-12">
				<a href="<?php the_permalink(); ?>" class="thumbnail">
                    <img src="<?php the_post_thumbnail_url(); ?>" alt="" class="img-fluid w-100">
				</a>
			</div>
		<?php } ?>
		<div class="col-sm-9 col-12">
            <h2><a class="text-dark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> <?php // заголовок поста и ссылка на его полное отображение (single.php) ?>
            <?php the_content(''); // пост превью, до more ?>
		</div>
	</div>
</article>