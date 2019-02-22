<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 22.02.2019
 * Time: 11:06
 */
?>

<!-- Live видео -->
<div class="modal fade" id="liveModal" tabindex="-1" role="dialog" aria-labelledby="liveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="liveModalLabel">Live</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo get_option('live'); ?>
            </div>
        </div>
    </div>
</div>
