<?php
/**
 * Шаблон рубрики (category.php)
 * @package WordPress
 * @subpackage brainor
 */
get_header(); // подключаем header.php ?> 
<section>
	<div class="container p-4">
		<div class="row">
			<div class="col-12 bg-white">
				<div class="row p-4">
                    <div class="col-12 p-2">
                        <a class="text-dark" href="/">Главная / </a>
                        <a class="text-dark" href="#"><?php single_cat_title(); // название категории ?></a>
                    </div>
                    <div class="col-12">
                        <?php if (have_posts()) : while (have_posts()) : the_post(); // если посты есть - запускаем цикл wp ?>
                            <?php get_template_part('loop'); // для отображения каждой записи берем шаблон loop.php ?>
                        <?php endwhile; // конец цикла
                        else: echo '<p>Нет записей.</p>'; endif; // если записей нет, напишим "простите" ?>
                        <?php pagination(); // пагинация, функция нах-ся в function.php ?>
                    </div>
                </div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); // подключаем footer.php ?>