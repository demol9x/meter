<div class="col-md-12">
    <div class="header">
        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
            <b>Màu sắc</b>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
            <b>Kích cỡ</b>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
            <b>Tình trạng</b>
        </div>
    </div>
    <div class="wrap-item-configurable">
        <?php if ($configurables) { ?>
            <?= $this->render('_old_item_configurable', ['configurables' => $configurables]) ?>
        <?php } else { ?>
            <?= $this->render('_new_item_configurable') ?>
        <?php } ?>
    </div>
    <div class="col-xs-12" style="margin-bottom: 50px">
        <button type="button" class="btn btn-success add-more-configurable">Thêm màu sắc, kích cỡ</button>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.add-more-configurable').click(function () {
            var stt = $('.wrap-item-configurable .item').length;
            stt++;
            var html = '<div class="item">';

            html += '<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">';
            html += '<input type="text" name="ProductConfigurable[' + stt + '][color]" class="form-control">';
            html += '</div>';

            html += '<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">';
            html += '<input type="text" name="ProductConfigurable[' + stt + '][size]" class="form-control">';
            html += '</div>';

            html += '<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">';
            html += '<select name="ProductConfigurable[' + stt + '][out_of_stock]" class="form-control">';
            html += '<option value="0">Còn hàng</option>';
            html += '<option value="1">Hết hàng</option>';
            html += '</select>';
            html += '</div>';

            html += '</div>';
            
            $('.wrap-item-configurable').append(html);
        });
    });

</script>