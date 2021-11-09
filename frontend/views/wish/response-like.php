<script type="text/javascript">
    setTimeout(function(){ 
        $('#load-like').fadeOut(1000, function() {});
        $('.wishlist>a').attr('data-load', 1);
    }, 2000);
</script>
<?php if($repspone == 1) { ?>
     <style type="text/css">
        body .load-like {
            width: 290px;
            margin-left: calc(50% - 145px);
            height: 100px;
            padding-top: 27px;
            margin-top: calc(50vh - 150px);
            padding: 20px;
        }
    </style>
    <p><?= Yii::t('app', 'add_like_success') ?></p>
<?php } else if($repspone == 0) { ?>
    <style type="text/css">
        body .load-like {
            width: 290px;
            margin-left: calc(50% - 145px);
            height: 100px;
            padding-top: 27px;
            margin-top: calc(50vh - 150px);
            padding: 20px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.wishlist>.active').removeClass('active');
        });
    </script>
    <p><?= Yii::t('app', 'need_login_to_like') ?></p>
<?php } else if($repspone == -1){ ?>
    <style type="text/css">
        body .load-like {
            width: 290px;
            margin-left: calc(50% - 145px);
            height: 100px;
            padding-top: 27px;
            margin-top: calc(50vh - 150px);
            padding: 20px;
        }
    </style>
    <p><?= Yii::t('app', 'system_is_avl') ?></p>
<?php } else if($repspone == 2){ ?>
    <style type="text/css">
        body .load-like {
            width: 290px;
            margin-left: calc(50% - 145px);
            height: 100px;
            padding-top: 27px;
            margin-top: calc(50vh - 150px);
            padding: 20px;
        }
    </style>
    <p><?= Yii::t('app', 'remove_like_success') ?></p>
<?php } ?>
