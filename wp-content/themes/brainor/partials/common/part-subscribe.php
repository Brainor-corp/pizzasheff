<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 14.02.2019
 * Time: 12:58
 */
?>

<div class="container subscribe-container my-5 py-5">
    <div class="row mb-4">
        <div class="col-12 text-center text-white">
            <h3 class="font-weight-light">Оставайся на связи</h3>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 text-center text-white">
            <span class="font-weight-light">
                Подпишись на наши обновления и будь в курсе последних новостей, акций и специальных предложений
            </span>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col text-center">
            <?php echo do_shortcode('[mailpoet_form id="2"]') ?>
        </div>
    </div>
</div>