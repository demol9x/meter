<?php

use yii\helpers\Url;

$siteinfo = common\components\ClaLid::getSiteinfo();
?>
<style type="text/css">
    .list-cate-footer a:hover {
        text-decoration: underline;
    }

    #fb-root .fb_dialog_content>iframe {
        right: -11px !important;
    }
</style>
<div id="footer">
    <div class="width-full-footer">
        <div class="container">
            <div class="row" style="border-bottom: 1px solid #ebebeb;">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?= \frontend\widgets\menu\MenuWidget::widget(['view' => 'footer', 'group_id' => 3]) ?>
                    <?php if ($siteinfo->link_bct) { ?>
                        <p style="clear: both; padding-top: 30px;">
                            <a target="_bank" href="<?= $siteinfo->link_bct ?>"><img alt="xac-nhan-dang-ky-bo-cong-thuong" title="" src="<?= Yii::$app->homeUrl ?>images/dadangky.png"></a>
                        </p>
                    <?php } ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?= \frontend\widgets\menu\MenuWidget::widget(['view' => 'footer', 'group_id' => 4]) ?>
                    <div class="support-footer">
                        <div class="ico-support">
                            <a href=""><img src="<?= Yii::$app->homeUrl ?>images/icon-phone.png" alt="phone"></a>
                        </div>
                        <div class="title-support">
                            <p><?= Yii::t('app', 'support_phone') ?></p>
                            <a href="tel:<?= $siteinfo->phone ?>"><?= formatPhone($siteinfo->phone) ?></a> - <a href="tel:<?= $siteinfo->hotline ?>"><?= formatPhone($siteinfo->hotline) ?></a>
                        </div>
                    </div>
                    <div class="support-footer">
                        <div class="ico-support">
                            <a href=""><img src="<?= Yii::$app->homeUrl ?>images/icon-email.png" alt="email"></a>
                        </div>
                        <div class="title-support">
                            <p><?= Yii::t('app', 'support_email') ?></p>
                            <a href="mailto:<?= $siteinfo->email ?>"><?= $siteinfo->email ?></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <?=
                    frontend\widgets\html\HtmlWidget::widget([
                        'view' => 'newsletter'
                    ]);
                    ?>
                    <?php if (!\common\components\ClaSite::isActiceApp()) { ?>
                        <div class="list-app">
                            <div class="logo-app-footer">
                                <a href="<?= Yii::$app->homeUrl ?>"><img src="<?= $siteinfo->footer_logo ?>" atl="logo-app"></a>
                            </div>
                            <a href="//www.dmca.com/Protection/Status.aspx?ID=d4ad83d9-300b-4422-a7e5-03a24d303874" title="DMCA.com Protection Status" class="dmca-badge">
                                <img src="https://images.dmca.com/Badges/dmca_protected_sml_120n.png?ID=d4ad83d9-300b-4422-a7e5-03a24d303874" alt="DMCA.com Protection Status" />
                            </a>
                            <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
                            <a class="lzd-footer-sprit icon-ios-footer" href="#" style="width: 50px;"><img src="<?= Yii::$app->homeUrl ?>images/imglg2.jpg" alt="verrifier"></a>
                            <!-- <a target="_bank" class="lzd-footer-sprit icon-ios-footer" href="https://itunes.apple.com/us/app/gcaeco/id1399857315?mt=8"><img src="<?= Yii::$app->homeUrl ?>images/logo-app.png" alt="app-apple"></a> -->
                            <a target="_bank" class="lzd-footer-sprit icon-android-footer" href="https://play.google.com/store/apps/details?id=com.ocop.partner"><img src="<?= Yii::$app->homeUrl ?>images/logo-app1.png" alt="app-adroid"></a>
                        </div>
                    <?php } ?>
                    <div class="giayphep">
                        <h2>
                            <?= $siteinfo->company ?>
                        </h2>
                        <?= nl2br($siteinfo->number_auth) ?>
                        <p>
                            <a href="" style="float: left;width: 100%; font-weight: 400; color: #979797; font-style: italic; font-size: 12px;"><?= $siteinfo->copyright ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container box-doitac" style="border-bottom: 1px solid #ebebeb;">
        <div class="row">
            <?= \frontend\widgets\banner\BannerWidget::widget(['view' => 'doitac', 'group_id' => 5, 'limit' => 20]) ?>
        </div>
    </div>
    <div class="container">
        <?= \frontend\widgets\menuCategory\MenuCategoryWidget::widget() ?>
    </div>
    <div class="bottom-payment-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div class="area">
                        <?= \frontend\widgets\menu\MenuWidget::widget(['view' => 'footer_img', 'group_id' => 11]) ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div class="social-footer">
                        <h2><?= Yii::t('app', 'connect_with_us') ?></h2>
                        <ul>
                            <?php
                            $social = common\components\ClaLid::getSocialInfo();
                            ?>
                            <?php if (isset($social['facebook']) && $social['facebook']) { ?>
                                <li><a class="facebook" target="_bank" href="<?= $social['facebook'] ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <?php } ?>
                            <?php if (isset($social['instagram']) && $social['instagram']) { ?>
                                <li><a class="twitter" target="_bank" href="<?= $social['instagram'] ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <?php } ?>
                            <?php if (isset($social['pinterest']) && $social['pinterest']) { ?>
                                <li><a class="pinterest" target="_bank" href="<?= $social['pinterest'] ?>"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                            <?php } ?>
                            <?php if (isset($social['youtube']) && $social['youtube']) { ?>
                                <li><a class="facebook" target="_bank" href="<?= $social['youtube'] ?>"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                            <?php } ?>
                            <?php if (isset($social['google']) && $social['google']) { ?>
                                <li><a class="google" target="_bank" href="<?= $social['google'] ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                            <?php } ?>
                            <?php if (isset($social['linkedin']) && $social['linkedin']) { ?>
                                <li><a class="linkedin" target="_bank" href="<?= $social['linkedin'] ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <?php } ?>
                            <?php if (isset($social['tumblr']) && $social['tumblr']) { ?>
                                <li><a class="google" target="_bank" href="<?= $social['tumblr'] ?>"><i class="fa fa-tumblr" aria-hidden="true"></i></a></li>
                            <?php } ?>
                            <?php if (isset($social['twitter']) && $social['twitter']) { ?>
                                <li><a class="twitter" target="_bank" href="<?= $social['twitter'] ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div class="area">
                        <?= \frontend\widgets\menu\MenuWidget::widget(['view' => 'footer_img', 'group_id' => 12]) ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div class="area">
                        <?= \frontend\widgets\menu\MenuWidget::widget(['view' => 'footer_img', 'group_id' => 13]) ?>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .bottom-payment-footer ul li img {
                max-height: 50px;
            }
        </style>
    </div>
    <p class="center"><?= $siteinfo->copyright ?></p>
    <p class="center">Website đang trong giai đoạn hoàn thiện ,công ty đã nộp đơn và chờ cấp phép của Bộ công thương .</p>
</div>

<?= \frontend\widgets\menu\MenuWidget::widget(['view' => 'social_bt', 'group_id' => 10]) ?>

<!-- <link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>css/calling-gca.css?v=1.0.1">
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/socket.io-2.1.1.js"></script>
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/StringeeSDK-1.5.1.js"></script>
<div class="calling-to">
    <button id="show-gca-calling"><i class="fa fa-phone"></i></button>
    <div class="formcalling">
        <div class="pad-20">
            <div class="gca-logo">
                <img src="<?= $siteinfo->logo ?>" height="55" class="stringee-margin-auto stringee-display-block">
            </div>
            <div class="gca-call-close">
                <img class="" src="https://v2.stringee.com/softphone-sdk-intergrate/images/close.svg" width="12">
            </div>
            <div class="content">
                <div class="stringee_text_phone_number">
                    <p class="stringee_text_welcome">Tư vấn bán hàng</p>
                    <h2 class="stringee_phone_number"><?= $siteinfo->hotline ?></h2>
                </div>
                <div class="stringee-row">
                    <div class="keypad-key btn-success btn-call start-call-login stringee-margin-auto">
                        <div class="wrap-img-icon">
                            <img src="https://v2.stringee.com/softphone-sdk-intergrate/images/phone.svg" width="30">
                        </div>
                    </div>
                    <div class="keypad-key btn-call btn-danger end-call stringee-margin-auto stringee-display-none">
                        <div class="wrap-img-icon">
                            <img src="https://v2.stringee.com/softphone-sdk-intergrate/images/phone-call-end.svg" width="40">
                        </div>
                    </div>
                </div>
            </div>
            <div class="stringee-footer">
                <p>Powered by OCOP</p>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="mobile_calling" value="+842899966638">
<script>
    var stringeeClient;
    var fromNumber = '842899966638';
    var access_token = 'eyJjdHkiOiJzdHJpbmdlZS1hcGk7dj0xIiwidHlwIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJqdGkiOiJTS296Tm9mQ0NWMVREYkxXM0FvTDdhdkRtbTlGRVNkZXktMTU3ODI3Mzg0OSIsImlzcyI6IlNLb3pOb2ZDQ1YxVERiTFczQW9MN2F2RG1tOUZFU2RleSIsImV4cCI6MTU4MDg2NTg0OSwidXNlcklkIjoiYWdlbnRfMSIsImljY19hcGkiOnRydWV9.qqoQhKGqJUDePmwJ5xlENGPzCGOP0NPNjyiVuv3qSVs';
    var call;

    function ShowPopCall(phone) {
        $('#mobile_calling').val(phone);
        $(".calling-to .formcalling").animate({
            right: 0
        }, 500);
        $(".calling-to .formcalling .gca-call-close").animate({
            right: -35
        }, 500);
        $("#show-gca-calling").animate({
            right: 250
        }, 500);
        $('.stringee_phone_number').html('<?= $siteinfo->hotline ?>');
    }

    var my_val = 0;
    $("#show-gca-calling").click(function() {
        if (my_val % 2 != 0) {
            $(".calling-to .formcalling").animate({
                right: 0
            }, 500);
            $(".calling-to .formcalling .gca-call-close").animate({
                right: -35
            }, 500);
            $("#show-gca-calling").animate({
                right: 250
            }, 500);
        } else {
            $("div.formholder").animate({
                width: 0
            }, 500);
            $("#mybutton").animate({
                right: 0
            }, 500);
        }

        $(".calling-to .formcalling").animate({
            right: 0
        }, 500);
        $(".calling-to .formcalling .gca-call-close").animate({
            right: -35
        }, 500);
        $("#show-gca-calling").animate({
            right: 250
        }, 500);

    });
    $(".gca-call-close").click(function() {
        $(".calling-to .formcalling").animate({
            right: -250
        }, 500);
        $(".calling-to .formcalling .gca-call-close").animate({
            right: -250
        }, 500);
        $("#show-gca-calling").animate({
            right: 0
        }, 500);
    });
    $('.start-call-login').click(function() {
        var tonumber = $('#mobile_calling').val();
        MakeCallNow(tonumber);
        // navigator.mediaDevices.getUserMedia({audio: true})
        //     .then(function (stream) {
        //         MakeCallNow(tonumber);
        //         return false;
        //     })
        //     .catch(function (err) {
        //         alert("Bạn cần cấp quyền kết nối micro tới website trước!");
        //         return false;
        //     });

    });
    $('.end-call').click(function() {
        RejectCall();
    });


    $(document).ready(function() {
        //check isWebRTCSupported
        // console.log('StringeeUtil.isWebRTCSupported: ' + StringeeUtil.isWebRTCSupported());

        stringeeClient = new StringeeClient();
        settingClientEvents(stringeeClient);
        stringeeClient.connect(access_token);
    });

    function MakeCallNow(toNumber) {
        call = new StringeeCall(stringeeClient, fromNumber, toNumber.toString());
        settingCallEvents(call);

        call.makeCall(function(res) {
            if (JSON.stringify(res.message) === "GET_USER_MEDIA_ERROR") {
                alert('Bạn cần kết nối thiết bị micro trước');
                return false;
            } else {
                $('.stringee_phone_number').html('<span>Đang gọi</span> ' + '<?= $siteinfo->hotline ?>');
                $('.stringee_phone_number span').each(function() {
                    var elem = $(this);
                    setInterval(function() {
                        if (elem.css('visibility') == 'hidden') {
                            elem.css('visibility', 'visible');
                        } else {
                            elem.css('visibility', 'hidden');
                        }
                    }, 500);
                });
                $('.calling-to .formcalling').css('height', 310);
                $('.start-call-login').css('opacity', 0);
                $('.start-call-login').hide();
                $('.end-call').show();
                $('.end-call').css('opacity', 1);
            }
            console.log('make call callback: ' + JSON.stringify(res));
            if (res.r !== 0) {
                $('#callStatus').html(res.message);

            }
        });
    }

    function settingClientEvents(client) {
        client.on('connect', function() {
            console.log('connected to StringeeServer');
        });

        client.on('authen', function(res) {
            $('#loggedUserId').html(res.userId);
        });

        client.on('disconnect', function() {
            console.log('disconnected');
        });

        client.on('incomingcall', function(incomingcall) {
            call = incomingcall;
            settingCallEvents(incomingcall);

            $('#incoming-call-div').show();
            $('#incoming_call_from').html(call.fromNumber);

            console.log('incomingcall: ', incomingcall);
        });

        client.on('requestnewtoken', function() {
            console.log('request new token; please get new access_token from YourServer and call client.connect(new_access_token)');
            //please get new access_token from YourServer and call:
            //client.connect(new_access_token);
        });

        client.on('otherdeviceauthen', function(data) {
            console.log('otherdeviceauthen: ', data);
        });
    }

    function settingCallEvents(call1) {
        call1.on('addlocalstream', function(stream) {});

        call1.on('addremotestream', function(stream) {
            // reset srcObject to work around minor bugs in Chrome and Edge.
            remoteVideo.srcObject = null;
            remoteVideo.srcObject = stream;
        });

        call1.on('signalingstate', function(state) {
            console.log('signalingstate ', state);

            if (state.code == 6) {
                $('#incoming-call-div').hide();
            }

            var reason = state.reason;
            $('#callStatus').html(reason);
        });

        call1.on('mediastate', function(state) {
            console.log('mediastate ', state);
        });

        call1.on('info', function(info) {
            console.log('on info', info);
        });

        call1.on('otherdevice', function(data) {
            console.log('on otherdevice:' + JSON.stringify(data));

            if ((data.type === 'CALL_STATE' && data.code >= 200) || data.type === 'CALL_END') {
                $('#incoming-call-div').hide();
            }
        });
    }

    function RejectCall() {
        remoteVideo.srcObject = null;
        call.hangup(function(res) {
            console.log('hangup res', res);
            $('.stringee_phone_number').html('<?= $siteinfo->hotline ?>');
            $('.calling-to .formcalling').css('height', 285);
            $('.end-call').css('opacity', 0);
            $('.end-call').hide();
            $('.start-call-login').show();
            $('.start-call-login').css('opacity', 1);
        });
    }
</script>
<video id="remoteVideo" playsinline autoplay style="width: 350px; display: none"></video> -->