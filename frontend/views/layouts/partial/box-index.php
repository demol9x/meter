<div class="mz-expand box-index">
    <div class="mz-expand-stage">
        <div class="mz-expand-controls mz-fade mz-visible">
            <button title="Previous" class="mz-button mz-button-prev" style="display: none; visibility: hidden;"></button>
            <button title="Next" class="mz-button mz-button-next" style="display: none; visibility: hidden;"></button>
            <button title="Close" class="mz-button mz-button-close close-box-index"></button>
        </div>
        <div class="mz-image-stages">
            <div class="box">
                <img id="box-index" src="<?= \common\components\ClaHost::getImageHost().'/imgs/df.png' ?>" style="max-height: 100%; max-width: 100%;">
            </div>
        </div>
    </div>
    <div class="mz-expand-bg">
        <img src="<?= \common\components\ClaHost::getImageHost().'/imgs/df.png' ?>">
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.close-box-index').click(function() {
            $('.box-index').css('display', 'none');
        });
    })
</script>