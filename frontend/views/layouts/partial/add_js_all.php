
<div class="load-like" id="load-like"></div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.scroll-top-btn').click(function () {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });
    });
    $(document).ready(function(){
        $('.open-popup-link').magnificPopup({
            type:'inline',
            midClick: true
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
    initMap();
</script>
<?= $this->render('alert'); ?>
