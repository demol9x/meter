
<?php if($repspone == 1) { ?>
    <script type="text/javascript">
        setTimeout(function(){ 
            $('#load-like').fadeOut(1000, function() {});
            $('.new-remove-order').removeClass('new-remove-order');
        }, 2000);
    </script>
    <style type="text/css">
        body .load-like {
            width: 290px;
            margin-left: calc(50% - 145px);
            height: 80px;
            padding-top: 27px;
            margin-top: calc(50vh - 150px);
            padding: 20px;
        }
    </style>
    <p><?= $msg ?></p>
    <?php if(isset($url_back)) { ?>
        <script type="text/javascript">
            loadAjax('<?= $url_back ?>', {}, $('#load-update-order-mt'));
        </script>
        <div id="load-update-order-mt">
        </div>    
    <?php } ?>    
<?php } else if($repspone == 0) { ?>
    <script type="text/javascript">
        setTimeout(function(){ 
            $('#load-like').fadeOut(1000, function() {});
            $('.new-remove-order').css('display', 'block');
        }, 2000);

    </script>
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
    <p><?= $msg ?></p>

<?php } else if($repspone == 20) { ?>
    <script type="text/javascript">
        setTimeout(function(){ 
            $('#load-like').fadeOut(1000, function() {});
            $('.new-remove-order').css('display', 'block');
        }, 5000);
    </script>
    <style type="text/css">
        body .load-like {
            width: 290px;
            margin-left: calc(50% - 145px);
            height: 145px;
            padding-top: 27px;
            margin-top: calc(50vh - 150px);
            padding: 20px;
        }
    </style>
    <p><?= $msg ?></p>
<?php } ?>
   
