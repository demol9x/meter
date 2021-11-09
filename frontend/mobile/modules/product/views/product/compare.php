<?php

use yii\helpers\Url;
use common\product1s\product\Product;
use common\components\ClaHost;
use common\components\ClaLid;
use frontend\components\AttributeHelper;
?>
<link rel="stylesheet" href="https://code.jquery.com/jquery-migrate-3.0.0.min.js">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>js/jquery-ui/jquery-ui.min.css?v=1">
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/jquery-ui/jquery-ui.min.js?v=1"></script>
<style type="text/css">
    .remove-compare-js {
        color: #999;
        position: absolute;
        right: 0px;
        font-size: 19px;
        border: 1px solid #999;
        width: 31px;
        height: 30px;
        padding: 0px 10px;
        border-radius: 50%;
        cursor: pointer;
        background: #fff;
    }
    #add-compare {
        opacity: 0;
    }
    #add-compares {
        margin-left: 20px;
        display: inline-block;
        border: 1px solid #ebebeb;
        padding: 10px;
        cursor: pointer;
        color: red;
    }
    #box-responce {
        max-height: 310px;
        overflow: auto;
    }
    #box-responce img {
        float: left;
        margin-right: 7px;
    }
    #box-responce a{
        display: block;
        height: 100%;
    }
    #box-responce p{
        height: 55px;
        border-bottom: 1px solid #ebebeb;
        margin-top: 12px;
    }
    #myModal-search-product .modal-content {
        width: 400px;
    }
    .compare-content {
        border-top: 1px solid #ebebeb;
        padding: 20px 15px 60px;
    }
    .compare-content .img {
        padding: 20px 0px;
    }
    .title {
        font-weight: bold;
    }
    .col {
        padding-right: 15px !important;
        width: 44%;
        text-align: center;
    }
    .col-0 {
        width: 15%;
        float: left;
        margin: 0px;
        padding: 15px 0px;
    }
    .col-9 {
        width: 5%;
        float: left;
        margin: 0px;
        padding: 15px 0px;
    }
    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8 {
        min-width: 150px;
        float: left;
        margin: 0px;
        padding: 15px;
        position: relative;
    }
    .col-3 {
        width: 26%;
    }
    .col-2 {
        width: 40%;
    }
    .col-1 {
        width: 80%;
    }
    .col-4 {
        width: 20%;
    }
    .col-5 {
        width: 16%;
    }
    .col-6 {
        width: 13%;
    }
    .col-7 {
        width: 11%;
    }
    .col-8 {
        width: 10%;
    }
    .compare-content h3 {
        font-size: 16px;
    }
</style>
<div class="compare-content">
    <div class="title-cate-product">
        <h2><a><?= Yii::t('app','compare') ?></a></h2>
    </div>
    <div class="row">
        <div class="col-0">
            <h3><?= Yii::t('app','product') ?></h3>
        </div>
        <?php 
            $count=count($data); 
            if($data) foreach($data as $product) { ?>
            <div class="col-<?= ($count > 8) ? 8 : $count ?>">
                <div class="remove-compare-js" data="<?= $product['id'] ?>">
                    x
                </div>
                <div class="img">
                    <a href="<?= Url::to(['/product/product/detail', 'id' => $product['id'], 'alias' => $product['alias']]) ?>">
                        <img src="<?= ClaHost::getImageHost(), $product['avatar_path'], 's400_400/', $product['avatar_name'] ?>" />
                    </a>
                </div>
                <h3><?= $product['name'] ?></h3>
            </div>
        <?php } ?>
        <?php if(count($_SESSION['compares']) <4) { ?>
            <div class="col-9">
                <a data-toggle="modal" data-target="#myModal-search-product" title="<?= Yii::t('app','add_product') ?>" id="add-compares">+</a>
            </div>
        <?php } ?>
    </div>
    <div class="rows">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><?= Yii::t('app','general_infomation') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="title "><?= Yii::t('app','price') ?>:</td>
                    <?php foreach ($data as $product) {?>
                        <td class="col col-<?= ($count > 8) ? 8 : $count ?>"><?= number_format($product['price'], 0, ',', '.') ?></td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function() {
        $('.remove-compare-js').click(function() {
            data = $(this).attr('data');
            $(this).css('display','none');
            $.ajax({
                url: '<?= Url::to(['/product/product/remove-compare']) ?>',
                type: 'get',
                data: {data: data},
                success: function (response) {
                    $('#box-compare').html(response);
                }
            });
        });
        // $('.add-compare-js').click(function() {
        //     data = $(this).attr('data');
        //     $(this).css('display','none');
        //     $.ajax({
        //         url: '<?= Url::to(['/product/product/remove-compare']) ?>',
        //         type: 'get',
        //         data: {data: data},
        //         success: function (response) {
        //             $('#box-compare').html(response);
        //         }
        //     });
        // });
    });
</script>
<style type="text/css">
    /*login form*/
    .frame-box .login-register{
        display: table-cell;
        vertical-align: middle;
        padding: 0px 15px;
    }
    .frame-box .login-register .register-form{

    }
    .frame-box .login-register .register-form .img-register-form{
        float: left;
        margin-right: 10px;
        margin-top: 6px;
    }
    .frame-box .login-register .register-form .img-register-form img{

    }
    .frame-box .login-register .register-form .title-register-form{
        float: left;
        position: relative;
    }
    .frame-box .title-register-form:hover .sub-account{
        /*opacity: 1;*/
        display: block;
    }
    .frame-box .title-register-form i{
        margin: 0 6px;
    }
    .sub-account {
        position: absolute;
        min-width: 160px;
        right: -13px;
        top: 35px;
        background: #46b96c;
        border: 2px solid #009846;
        padding: 6px;
        /*opacity: 0;*/
        display: none;
        z-index: 99999;
        text-align: right;
        transition: all 0.6s ease-in-out 0s;
        -moz-transition: all 0.6s ease-in-out 0s;
        -o-transition: all 0.6s ease-in-out 0s;
        -webkit-transition: all 0.6s ease-in-out 0s;
        -ms-transition: all 0.6s ease-in-out 0s;
    }
    .sub-account li a {
        padding: 5px 0;
        font-size: 12px;
        float: left;
        width: 100%;
    }
    .sub-account:after {
        content: "";
        width: 0;
        height: 0;
        position: absolute;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid #009846;
        top: -6px;
        left: 0px;
        right: 0px;
        margin: auto;
    }
    .frame-box .login-register .register-form .title-register-form p{
        color: #454545;
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
        font-size: 14px;
    }
    .frame-box .login-register .register-form .title-register-form p a{
        color: #454545;
        font-weight: normal;
        white-space: nowrap;
        font-family: 'Roboto';
        letter-spacing: 0px;
    }
    .frame-box .login-register .register-form .title-register-form p:hover{
        color: #009846;
    }
    .frame-box .login-register .register-form .title-register-form p a:hover{
        text-decoration: underline;
    }
    .frame-box .login-register .register-form .title-register-form p span{
        font-weight: normal;
        white-space: nowrap;
        display: block;
        font-size: 13px;
        font-family: 'Roboto';
        letter-spacing: 0px;
    }
    .title-register-form {
        position: relative;
        background: #46b96c;
        color: #fff;
        margin-right: 15px;
        padding: 9px 20px 6px 20px;
        margin-top: -8px;
        font-size: 13px;
        border-radius: 30px;
    }
    .title-register-form p{
        margin-bottom: 0px;
    }
    .title-register-form a{
        color: #fff;
        text-transform: uppercase;
    }
    .title-register-form a:hover{color: #fff;text-decoration: underline;}
    .login{ float:right;}
    .login ul li{ list-style:none; position:relative; float:left; margin:0 5px;}
    .login ul li a{ color:#fff; font-size:12px; padding:5px 10px;line-height: 30px; position:relative; font-weight:500;}
    .login ul li:hover a { color:#fcb040;}
    .modal-dialog.modal-sm-register-login{ width:300px;}
    .login-fb-gg ul li{ list-style:none; margin-bottom:10px;}
    .login-fb-gg ul li a{ color:#fff; font-size:13px; padding:5px 10px 5px 0px; border-radius:5px; display:block;}
    .login-fb-gg ul li.login-fb a{ background:#314FAF; text-align: center;}
    .login-fb-gg ul li.login-fb a:hover{ background-color:#2240a1;}
    .login-fb-gg ul li.login-gg{ margin-bottom:0;}
    .login-fb-gg ul li.login-gg a{ background:#E84C3D; text-align: center;}
    .login-fb-gg ul li.login-gg a:hover{ background-color:#d53324;}
    .modal-dialog.modal-sm-register-login .modal-content{ padding:20px;}
    .modal-dialog.modal-sm-register-login .form-control{ border-radius:0px; box-shadow:none; font-size:13px; font-style:italic; margin-bottom:15px; }
    .modal-dialog.modal-sm-register-login .checkbox{ margin-top:0;}
    .modal-dialog.modal-sm-register-login .btn-primary{ background:#e89f34; border-color:#e39625; width: 100%; text-transform:uppercase; font-weight:500;}
    .modal-dialog.modal-sm-register-login .btn-primary:hover{ background:#da8c1a; border-color:#cd8111;}
    .forget-pass{ color:#0c519a;    margin-bottom: 10px;display: block;}
    .forget-pass:hover{ color:#e89f34;}
    .register-new .guide{ font-size:13px; color:#666;}
    .register-new form .guide {text-align: center; font-size: 12px;line-height: 15px; margin-top: 10px; margin-bottom:0;}
    .register-new form .guide a{ color:#0c519a;}
    .register-new form .guide a:hover{ color:#da8c1a;}
    .modal-dialog{
        width: 300px;
        margin: auto;
        margin-top: 30px; 
    }
    .modal-dialog .cont{
        padding: 15px;
    }
    .modal-content{
        position: relative;
    }
    .login-fb-gg ul{
        padding: 0px;
    }
    button.close{
        position: absolute;
        right: -15px;
        top: -12px;
        color: #000;
        opacity: 1;
        font-size: 29px;
        border-radius: 50px;
        width: 30px;
        height: 30px;
        background: #fff;
    }
    button.close:hover{
        opacity: 1;
    }
    .register-new{
        margin: 10px 0px;
    }
    .guide{
        margin-bottom: 10px;
    }
     #signupform-type {
            padding: 5px;
        }
    #signupform-type .radio {
        width: 50%;
        float: left;
        margin: 0px;
        padding: 0px 0px 15px 0px;
    }
    body .modal {
        z-index: 999999;
    }
    /*ENDFORM*/
</style>
<div id="myModal-search-product" class="modal fade" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <div class="cont">
                <div class="login-fb-gg">
                    <ul class="clearfix">
                        <li class="login-fb">
                            <a class="btn-facebook push-top-xs auth-link" ><?= Yii::t('app','search_product') ?></a>
                        </li>
                    </ul>
                </div>    
                <div class="register-new">
                    <form id="form-register" method="POST" action="/vangduyhien/dang-ky.html">
                        <div class="item-register" style="margin-bottom: 15px;">
                            <input style="margin-bottom: 0px;" id="autocomplete" name="key" type="text" class="form-control" placeholder="<?= Yii::t('app','enter_product_name') ?>">
                            <div id="box-responce"></div>
                        </div>
                    </form>
                    <script type="text/javascript">
                        // $("#autocomplete").autocomplete({
                        //   source: '<?= Url::to(['/product/product/search-product']) ?>'
                        // });
                        $(function() {
                            $( "#autocomplete" ).autocomplete({
                              source: function( request, response ) {
                                $.ajax({
                                  url: '<?= Url::to(['/product/product/search-product']) ?>',
                                  dataType: "jsonp",
                                  data: {
                                    term: request.term
                                  },
                                  success: function( data ) {
                                    $('#box-responce').html(data);
                                  }
                                });
                              },
                              minLength: 3,
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
