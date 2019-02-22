<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 22.02.2019
 * Time: 11:06
 */
?>

<!-- Обратная связь -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Обратная связь</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo do_shortcode('[contact-form-7 id="32" title="Обратная связь"]') ?>
            </div>
        </div>
    </div>
</div>
