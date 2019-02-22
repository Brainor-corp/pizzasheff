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
                <div class="iv-embed">
                    <div class="iv-v" style="display:block;margin:0;padding:1px;border:0;background:#000;">
                        <iframe class="iv-i" style="display:block;margin:0;padding:0;border:0;margin: 0 auto;max-width:100%" src="https://open.ivideon.com/embed/v2/?server=100-OGbLpkoqrPhFL2KZhU9SVT&amp;camera=0&amp;width=840&amp;height=500&amp;lang=ru" width="840" height="500" frameborder="0" allowfullscreen>
                        </iframe>
                    </div>
                    <div class="iv-b" style="display:block;margin:0;padding:0;border:0;">
                        <div style="float:right;text-align:right;padding:0 0 10px;line-height:10px;">
                            <a class="iv-a" style="font:10px Verdana,sans-serif;color:inherit;opacity:.6;" href="https://www.ivideon.com/" target="_blank">Powered by Ivideon</a>
                        </div>
                        <div style="clear:both;height:0;overflow:hidden;"> </div>
                        <script src="https://open.ivideon.com/embed/v2/embedded.js"></script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
