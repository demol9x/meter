<?php //Menu main
echo frontend\widgets\menu\MenuWidget::widget([
    'view' => 'social_bt',
    'group_id' => 10,
])
?>
<div class="site51_foot_col0_meter" >
    <div class="container_fix">
        <div class="fluild">
            <div class="rows">
                <div class="footer_1">
                    <div class="logo_foot">
                        <img src="<?= $siteinfo->footer_logo ?>" alt="<?= $siteinfo->title ?>">
                    </div>
                    <div class="content_foot">
                        <p>MST: 01N8022048 - Ngày cấp: 27/11/2020</p>
                        <p>Nơi cấp: UBND Quận Long Biên - Phòng tài chính - Kế hoạch</p>
                    </div>
                    <div class="info_foot">
                        <div class="flex_foot">
                            <div class="img_foot">
                                <img src="<?= Yii::$app->homeUrl ?>images/map_foot.png" alt="" >
                            </div>
                            <div class="text_foot">
                                <a href="#"><?= $siteinfo->address ?></a>
                            </div>
                        </div>
                        <div class="flex_foot">
                            <div class="img_foot">
                                <img src="<?= yii::$app->homeUrl ?>images/phone_foot.png" alt="" >
                            </div>
                            <div class="text_foot">
                                <a href="tel:<?= $siteinfo->phone ?>"><?= $siteinfo->phone ?> - <?= $siteinfo->hotline ?></a>
                            </div>
                        </div>
                        <div class="flex_foot">
                            <div class="img_foot">
                                <img src="<?= yii::$app->homeUrl ?>images/mail_foot.png" alt="" >
                            </div>
                            <div class="text_foot">
                                <a href="mailto:<?= $siteinfo->email ?>"><?= $siteinfo->email ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer_2">
                    <?php //Menu main
                    echo frontend\widgets\menu\MenuWidget::widget([
                        'view' => 'footer',
                        'group_id' => 4,
                    ])
                    ?>
                </div>
                <?=
                frontend\widgets\html\HtmlWidget::widget([
                    'view' => 'newsletter'
                ]);
                ?>
            </div>
        </div>
        <div class="fluild_2">
            <div class="rows">
                <div class="service_1 service"><a href=""><img src="<?= yii::$app->homeUrl ?>images/dau_foot.png" alt=""></a></div>
                <div class="service_2 service">
                    <a href="#">
                        <img src="<?= yii::$app->homeUrl ?>images/vnpay_foot.png" alt="">
                    </a>
                    <a href="#">
                        <img src="<?= yii::$app->homeUrl ?>images/visa_foot.png" alt="">
                    </a>
                    <a href="#">
                        <img src="<?= yii::$app->homeUrl ?>images/banking_foot.png" alt="">
                    </a>
                    <a href="#">
                        <img src="<?= yii::$app->homeUrl ?>images/visa_foot.png" alt="">
                    </a>
                    <a href="#">
                        <img src="<?= yii::$app->homeUrl ?>images/installment_foot.png" alt="">
                    </a>
                    <a href="#">
                        <img src="<?= yii::$app->homeUrl ?>images/the_foot.png" alt="">
                    </a>
                    <a href="#">
                        <img src="<?= yii::$app->homeUrl ?>images/monney_foot.png" alt="">
                    </a>
                </div>
                <div class="service_3 service">
                    <span>LIÊN KẾT:</span>
                    <div class="flex-icon">
                        <?php //Menu main
                        echo frontend\widgets\menu\MenuWidget::widget([
                            'view' => 'view',
                            'group_id' => 8,
                        ])
                        ?>
                    </div>
                </div>
                <div class="service_4">
                    <a href="https://nanoweb.vn/" target="_blank">
                        <span><span><?= $siteinfo->copyright ?></span></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //Menu main
echo frontend\widgets\menu\MenuWidget::widget([
    'view' => 'social_bt',
    'group_id' => 10,
])
?>