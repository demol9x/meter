
<div class="load-like" id="load-like"></div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.scroll-top-btn').click(function () {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });
    });

    function addLike(id, _this) {
        if(_this.attr('data-load') &&  _this.attr('data-load')== '0') {
            return false;
        }
        $('.wishlist>a').attr('data-load', 0);
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
    function loginShop(_this) {
        if(_this.attr('data-load') &&  _this.attr('data-load')== '0') {
            return false;
        }
        $('.wishlist>a').attr('data-load', 0);
        $('#load-like').html('<p>Bạn cần đăng nhập tài khoản nhà môi giới để thực hiện chức năng này</p>');
        $('#load-like').fadeIn(1000);
        setTimeout(function() {
            $('#load-like').fadeOut(1000);
            $('.wishlist>a').attr('data-load', 1);
        },3000);
        $('#load-like').addClass('load-like-login load-shop-login');
    }
</script>
<?= $this->render('alert'); ?>
