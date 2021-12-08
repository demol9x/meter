<style>
    body .load-like-login {
        width: 290px;
        padding: 20px;
        margin-left: calc(50% - 145px);
    }
    .load-like {
        position: fixed;
        top: 0px;
        left: 0px;
        text-align: center;
        width: 100px;
        margin-left: calc(50% - 50px);
        height: 100px;
        padding-top: 27px;
        border-radius: 15px;
        margin-top: calc(50vh - 150px);
        z-index: 9999;
        background: #289300;
        display: none;
        color: #fff;
        font-size: 20px;
    }
</style>
<div class="load-like" id="load-like"></div>
<script type="text/javascript">

    function loadAjax(url, data, div) {
        div.html('<img style="padding:5px 10px;" src="/images/ajax-loader.gif" />');
        $.ajax({
            url: url,
            data: data,
            success: function (result) {
                div.html(result);
            }
        });
    }

    function loadAjaxPost(url, data, div) {
        div.html('<img style="padding:5px 10px;" src="/images/ajax-loader.gif" />');
        $.ajax({
            url: url,
            data: data,
            type: 'POST',
            success: function (result) {
                div.html(result);
            }
        });
    }
    function addLike(id, _this) {
        if(_this.attr('data-load') &&  _this.attr('data-load')== '0') {
            return false;
        }
        $('.wishlist i').attr('data-load', 0);
        _this.fadeOut(1500).fadeIn(1500);
        href = '<?= \yii\helpers\Url::to(['/wish/add-like']) ?>';
        $('#load-like').fadeIn(1000);
        loadAjax(href, {id : id}, $('#load-like'));
        _this.addClass('active');
        _this.attr('title', '<?= Yii::t('app', 'remove_like') ?>');
        _this.attr('onclick', 'removeLike('+id+', $(this))');

    }
    function removeLike(id, _this) {
        if(_this.attr('data-load') &&  _this.attr('data-load')== '0') {
            return false;
        }
        $('.wishlist>a').attr('data-load', 0);
        _this.fadeOut(1500).fadeIn(1500);
        href = '<?= \yii\helpers\Url::to(['/wish/remove-like']) ?>';
        $('#load-like').fadeIn(1000);
        loadAjax(href, {id : id}, $('#load-like'));
        _this.removeClass('active');
        _this.attr('title', '<?= Yii::t('app', 'add_like') ?>');
        _this.attr('onclick', 'addLike('+id+', $(this))');
    }
    function loginLike(_this) {
        if(_this.attr('data-load') &&  _this.attr('data-load')== '0') {
            return false;
        }
        $('.wishlist>a').attr('data-load', 0);
        $('#load-like').html('<p><?= Yii::t('app', 'need_login_to_like') ?></p>');
        $('#load-like').fadeIn(1000);
        setTimeout(function() {
            $('#load-like').fadeOut(1000);
            $('.wishlist>a').attr('data-load', 1);
        },2000);
        $('#load-like').addClass('load-like-login');
    }
    $(function () {
        $('#select_pro_option').change(function () {
            var sort = jQuery(this).find('option:selected');
            window.location.href = sort.data('url');
        });
    });
    function logine(_this) {
        $('#load-like').html('<p><?= Yii::t('app', 'Bạn cần đăng nhập để thực hiện chức năng này') ?></p>');
        $('#load-like').fadeIn(1000);
        setTimeout(function() {
            $('#load-like').fadeOut(1000);
        },2000);
        $('#load-like').addClass('load-like-login');
        return false;
    }

    $('.site51_profil_col3_locsanpham .locsanpham .pro_fitler .pro_env').click(function () {
        $(this).parent().toggleClass('hide_now');
    })
</script>
