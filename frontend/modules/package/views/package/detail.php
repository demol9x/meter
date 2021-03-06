<?php

use  common\components\ClaHost;
use yii\widgets\ActiveForm;

?>
<div class="site51_prodel_col12_chitietgoithau">
    <div class="container_fix">
        <?php //Menu main
        echo frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(['view' => 'view']);
        ?>
        <div class="pro_detail">
            <div class="detail_left wow fadeInLeft" data-wow-duration="3s"
                 style="visibility: visible; animation-duration: 3s;">
                <div class="left_env">
                    <div class="slide_detail_on">
                        <div class="img_detail">
                            <a data-fancybox="gallery"
                               href="<?= ClaHost::getImageHost(), $package['avatar_path'], $package['avatar_name'] ?>">
                                <img src="<?= ClaHost::getImageHost(), $package['avatar_path'], $package['avatar_name'] ?>"
                                     alt="">
                            </a>
                        </div>
                        <?php foreach ($image as $key) { ?>
                            <div class="img_detail">
                                <a data-fancybox="gallery"
                                   href="<?= ClaHost::getImageHost(), $key['path'], $key['name'] ?>">
                                    <img src="<?= ClaHost::getImageHost(), $key['path'], $key['name'] ?>"
                                         alt=" <?= $key['display_name'] ?>">
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="slide_detail_in">
                        <div class="img_detail_1">
                            <img src="<?= ClaHost::getImageHost(), $package['avatar_path'], $package['avatar_name'] ?>" alt="">
                        </div>
                        <?php foreach ($image as $key) { ?>
                            <div class="img_detail_1">
                                <img src="<?= ClaHost::getImageHost(), $key['path'], $key['name'] ?>" alt=" <?= $key['display_name'] ?>">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="detail_right wow fadeInRight" data-wow-duration="3s"
                 style="visibility: visible; animation-duration: 3s;">
                <div class="content">
                    <div class="title title_28">
                        <?= $package['name'] ?>
                    </div>
                    <div class="description">
                        <i class="far fa-sticky-note"></i><span
                                class="content_16">????ng k?? d??? th???u: <?= isset($count) && $count ? $count : 'Ch??a c?? ai d??? th???u' ?></span>
                    </div>
                </div>
                <div class="contact_info">
                    <div class="content_16_b">Th??ng tin li??n l???c:</div>
                    <div class="contact_row">
                        <img src="<?= yii::$app->homeUrl ?>images/img_detail_home.png" alt="">
                        <a href="<?= isset($shop['website']) && $shop['website'] ? $shop['website'] : '#' ?>"
                           class="content_16"><?= isset($shop['name']) && $shop['name'] ? $shop['name'] : '' ?></a>
                    </div>
                    <div class="contact_row">
                        <i class="far fa-map-marker-alt"></i>
                        <span class="content_16"><?= isset($shop['address']) && $shop['address'] ? $shop['address'] : '??ang c???p nh???t ' ?></span>
                    </div>
                    <div class="contact_row">
                        <div class="contact_flex">
                            <div class="flex">
                                <i class="far fa-phone-alt"></i>
                                <a href="tel:<?= $shop['phone'] ?>"
                                   class="content_16"><?= isset($shop['phone']) && $shop['phone'] ? $shop['phone'] : '??ang c???p nh???t' ?></a>
                            </div>
                            <div class="flex">
                                <i class="far fa-envelope"></i>
                                <a href="mailto:<?= $shop['email'] ?>"
                                   class="content_16"> <?= isset($shop['email']) && $shop['email'] ? $shop['email'] : '??ang c???p nh???t' ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail_des">
                    <span class="content_16_b">Gi???i thi???u:</span>
                    <span class="content_16"><?= isset($package->short_description) && $package->short_description ? $package->short_description : '??ang c???p nh???t' ?></span>
                </div>
                <div class="detail_upload">
                    <i class="far fa-paperclip"></i>
                    <a href="<?=  'http://meter.nanoweb.vn/'.'/static/'.$package->ho_so ?>" class="content_16"><?= isset($package->ho_so) && $package->ho_so ? 'T??i li???u v??? g??i th???u' : ' ??ang c???p nh???t' ?></a>
                </div>
                <?php
                if(!yii::$app->user->id){?>
                <a class="detail_button btn-animation" href="<?= \yii\helpers\Url::to(['/login/login/login'])?>" >
                    <img src="<?= yii::$app->homeUrl ?>images/pages.png" alt=""><span class="content_16_b">????ng nh???p tr?????c khi d??? th???u</span>
                </a>
                <?php } else if($check){
                ?>
                <a class="detail_button btn-animation" style="cursor: no-drop">
                    <img src="<?= yii::$app->homeUrl ?>images/pages.png" alt=""
                         ><span class="content_16_b">B???n ???? ????ng k?? d??? th???u</span>
                </a>
                <?php }
                else if($package_active){?>
                    <a class="detail_button btn-animation" style="cursor: no-drop">
                        <img src="<?= yii::$app->homeUrl ?>images/pages.png" alt=""><span class="content_16_b">B???n kh??ng th??? d??? th???u c???a m??nh</span>
                    </a>
               <?php  }else
                    {?>
                    <a class="detail_button btn-animation" onclick="check_dangky()">
                        <img src="<?= yii::$app->homeUrl ?>images/pages.png" alt=""><span class="content_16_b">????ng k?? d??? th???u</span>
                    </a>
                <?php }?>
            </div>
        </div>
        <?php if (isset($package_shop) && $package_shop) {
            ?>
            <div class="pro_similar">
                <div class="pro_package">
                    <div class="pro_content">
                        <div class="content_text">
                            <h3>g??i th???u t????ng t???</h3>
                        </div>
                    </div>
                    <div class="pro_flex item-list-sp">
                        <?php
                        foreach ($package_shop as $key) {
                            $link = \yii\helpers\Url::to(['/package/package/detail', 'id' => $key['id'], 'alias' => $key['alias']]);
                            $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                            if (isset($key['avatar_path']) && $key['avatar_path']) {
                                $avatar_path = \common\components\ClaHost::getImageHost() . $key['avatar_path'] . $key['avatar_name'];
                            }
                            ?>
                            <div class="pro_card wow fadeIn" data-wow-delay="0.1s">
                                <a href="<?= $link ?>">
                                    <div class="card_img">
                                        <img src="<?= $avatar_path ?>" alt="<?= $key['name'] ?>">
                                    </div>
                                    <div class="card_text">
                                        <div class="title"><?= $key['name'] ?></div>
                                        <div class="adress"><span><?= $key['province']['name'] ?></span>
                                            <span>60km</span>
                                        </div>
                                        <div class="date_time">
                                    <span>
                                        <img src="<?= yii::$app->homeUrl ?>images/time_pro.png" alt="">
                                        <?= date('d-m-y', $key['created_at']) ?>
                                    </span>
                                        </div>
                                    </div>
                                </a>
                                <label class="heart">
                                    <a data-id="<?= $key['id'] ?>"
                                       class="iuthik1 <?= in_array($key['id'], $package_wish) ? 'active' : '' ?>"><i
                                                class="fas fa-heart"></i></a>
                                </label>
                                <?php
                                if (isset($key) && $key['ishot'] == 1) {
                                    ?>
                                    <div class="hot_product">
                                        <img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt="">
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="pro_main">
            <div class="pro_flex_left">
                <div class="nav_menu">
                    <a id="scroll_load_1" href="#" class="nav_list active title_18">M?? t??? g??i th???u</a>
                    <a id="scroll_load_2" href="#" class="nav_list title_18">h??? s?? d??? th???u</a>
                </div>
                <div id="pro_desc_list" class="pro_description">
                    <?= isset($package->description) && $package->description ? $package->description : 'Ph???n n??y m?? t??? v??? g??i th???u' ?>
                    <div class="button_position">
                        <a class="content_16 btn-animation">Xem th??m <i class="fas fa-chevron-down"></i></a>
                    </div>

                </div>
                <div id="pro_desc_list_1" class="pro_description_1">
                    <div class="pro_package">
                        <div class="pro_content">
                            <div class="content_text">
                                <h3>h??? s?? d??? th???u</h3>
                            </div>
                        </div>
                        <div class="pro_flex">
                            <table>
                                <tr>
                                    <td class="content_16">????n d??? th???u ho???c gi???y t??? th???a thu???n li??n doanh (n???u c??)</td>
                                    <td class="content_16">B??? gi???y t??? th???a thu???n li??n doanh ch??? c?? khi c??c ????n v??? ?????u
                                        th???u c??ng li??n
                                        k???t, h???p t??c v???i nhau ????? gi??nh l???y g??i th???u l???n v???i m???c gi?? c??? m?? c??c b??n
                                        ?????u th???a thu???n ?????ng ??.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content_16">????n d??? th???u ho???c gi???y t??? th???a thu???n li??n doanh (n???u c??)</td>
                                    <td class="content_16">B??? gi???y t??? th???a thu???n li??n doanh ch??? c?? khi c??c ????n v??? ?????u
                                        th???u c??ng li??n
                                        k???t, h???p t??c v???i nhau ????? gi??nh l???y g??i th???u l???n v???i m???c gi?? c??? m?? c??c b??n
                                        ?????u th???a thu???n ?????ng ??.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content_16">????n d??? th???u ho???c gi???y t??? th???a thu???n li??n doanh (n???u c??)</td>
                                    <td class="content_16">B??? gi???y t??? th???a thu???n li??n doanh ch??? c?? khi c??c ????n v??? ?????u
                                        th???u c??ng li??n
                                        k???t, h???p t??c v???i nhau ????? gi??nh l???y g??i th???u l???n v???i m???c gi?? c??? m?? c??c b??n
                                        ?????u th???a thu???n ?????ng ??.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content_16">????n d??? th???u ho???c gi???y t??? th???a thu???n li??n doanh (n???u c??)</td>
                                    <td class="content_16">B??? gi???y t??? th???a thu???n li??n doanh ch??? c?? khi c??c ????n v??? ?????u
                                        th???u c??ng li??n
                                        k???t, h???p t??c v???i nhau ????? gi??nh l???y g??i th???u l???n v???i m???c gi?? c??? m?? c??c b??n
                                        ?????u th???a thu???n ?????ng ??.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content_16">????n d??? th???u ho???c gi???y t??? th???a thu???n li??n doanh (n???u c??)</td>
                                    <td class="content_16">B??? gi???y t??? th???a thu???n li??n doanh ch??? c?? khi c??c ????n v??? ?????u
                                        th???u c??ng li??n
                                        k???t, h???p t??c v???i nhau ????? gi??nh l???y g??i th???u l???n v???i m???c gi?? c??? m?? c??c b??n
                                        ?????u th???a thu???n ?????ng ??.
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="button_pro_detail">
                    <?php
                    if(!yii::$app->user->id){?>
                        <a class="detail_button btn-animation" href="<?= \yii\helpers\Url::to(['/login/login/login'])?>" >
                            <img src="<?= yii::$app->homeUrl ?>images/pages.png" alt=""><span class="content_16_b">????ng k?? d??? th???u</span>
                        </a>
                    <?php } else if($check){
                        ?>
                        <a class="detail_button btn-animation" style="cursor: no-drop">
                            <img src="<?= yii::$app->homeUrl ?>images/pages.png" alt=""
                            ><span class="content_16_b">B???n ???? ????ng k?? d??? th???u</span>
                        </a>
                    <?php }
                    else
                        if($package_active){?>
                            <a class="detail_button btn-animation" style="cursor: no-drop">
                                <img src="<?= yii::$app->homeUrl ?>images/pages.png" alt=""
                                ><span class="content_16_b">B???n kh??ng th??? d??? th???u c???a ch??nh b???n</span>
                            </a>
                        <?php }
                        else
                        {?>
                        <a class="detail_button btn-animation" onclick="check_dangky()">
                            <img src="<?= yii::$app->homeUrl ?>images/pages.png" alt=""><span class="content_16_b">????ng k?? d??? th???u</span>
                        </a>
                    <?php }?>
                </div>
            </div>
            <?php if (isset($package_ishot) && $package_ishot) { ?>
                <div class="pro_flex_right">
                    <div class="pro_package">
                        <div class="pro_content">
                            <div class="content_text">
                                <h3>n???i b???t</h3>
                            </div>
                        </div>
                        <div class="pro_flex item-list-hot-deal">
                            <?php
                            foreach ($package_ishot as $key) {
                                $link = \yii\helpers\Url::to(['/package/package/detail', 'id' => $key['id'], 'alias' => $key['alias']]);
                                $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                                if (isset($key['avatar_path']) && $key['avatar_path']) {
                                    $avatar_path = \common\components\ClaHost::getImageHost() . $key['avatar_path'] . $key['avatar_name'];
                                }
                                ?>
                                <div class="pro_card wow fadeIn" data-wow-delay="0.1s">
                                    <a href="<?= $link ?>">
                                        <div class="card_img">
                                            <img src="<?= $avatar_path ?>" alt="<?= $key['name'] ?>">
                                        </div>
                                        <div class="card_text">
                                            <div class="title"><?= $key['name'] ?></div>
                                            <div class="adress"><span><?= $key['province']['name'] ?></span>
                                                <span>60km</span>
                                            </div>
                                            <div class="date_time">
                                    <span>
                                        <img src="<?= yii::$app->homeUrl ?>images/time_pro.png" alt="">
                                        <?= date('d-m-y', $key['created_at']) ?>
                                    </span>
                                            </div>
                                        </div>
                                    </a>
                                    <label class="heart">
                                        <a data-id="<?= $key['id'] ?>"
                                           class="iuthik1 <?= in_array($key['id'], $package_wish) ? 'active' : '' ?>"><i
                                                    class="fas fa-heart"></i></a>
                                    </label>
                                    <?php
                                    if (isset($key) && $key['ishot'] == 1) {
                                        ?>
                                        <div class="hot_product">
                                            <img src="<?= yii::$app->homeUrl ?>images/hot_product.png" alt="">
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if (isset($package_related) && $package_related) { ?>
            <div class="pro_slide">
                <div class="pro_package">
                    <div class="pro_content">
                        <div class="content_text">
                            <h3>g??i th???u kh??c</h3>
                        </div>
                    </div>
                    <div class="pro_flex slide_pro_active">
                        <?php
                        foreach ($package_related as $key) {
                            $link = \yii\helpers\Url::to(['/package/package/detail', 'id' => $key['id'], 'alias' => $key['alias']]);
                            $avatar_path = \common\components\ClaHost::getImageHost() . '/imgs/default.png';
                            if (isset($key['avatar_path']) && $key['avatar_path']) {
                                $avatar_path = \common\components\ClaHost::getImageHost() . $key['avatar_path'] . $key['avatar_name'];
                            }
                            ?>
                            <div class="pro_card wow fadeIn" data-wow-delay="0.1s">
                                <a href="<?= $link ?>">
                                    <div class="card_img">
                                        <img src="<?= $avatar_path ?>" alt="<?= $key['name'] ?>">
                                    </div>
                                    <div class="card_text">
                                        <div class="title"><?= $key['name'] ?></div>
                                        <div class="adress"><span><?= $key['province']['name'] ?></span>
                                            <span>60km</span>
                                        </div>
                                        <div class="date_time">
                                    <span>
                                        <img src="<?= yii::$app->homeUrl ?>images/time_pro.png" alt="">
                                        <?= date('d-m-y', $key['created_at']) ?>
                                    </span>
                                        </div>
                                    </div>
                                </a>
                                <label class="heart">
                                    <a data-id="<?= $key['id'] ?>"
                                       class="iuthik1 <?= in_array($key['id'], $package_wish) ? 'active' : '' ?>"><i
                                                class="fas fa-heart"></i></a>
                                </label>
                                <?php
                                if (isset($key) && $key['ishot'] == 1) {
                                    ?>
                                    <div class="hot_product"><img src="<?= yii::$app->homeUrl ?>images/hot_product.png"
                                                                  alt=""></div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div>
</div>

<div id="popup_goithau" class="site51_popup_col12_popupgoithau">
    <div class="popup_goithau">
        <div class="popup_flex">
            <div class="item-title-popup">
                <div class="title-popup-donhang">
                    <h3 class="title_26">????NG K?? D??? TH???U</h3>
                    <img class="Rectangle" src="<?= yii::$app->homeUrl ?>images/Rectangle.png">
                </div>
            </div>
            <div id="popup_close_goithau" class="popup_close">
                <i class="fas fa-times"></i>
            </div>
            <div class="popup_goithau--env">
                <div class="popup_content">
                    <div class="popup_img">
                        <img src="<?= yii::$app->homeUrl ?>images/image10.png" alt="">
                    </div>
                    <div class="detaile">
                        <div class="popup_title title_28">
                            <span><?= $package['name'] ?> </span>
                        </div>
                        <div class="contact_info">
                            <div class="content_16_b">Th??ng tin li??n l???c:</div>
                            <div class="contact_row">
                                <img src="<?= yii::$app->homeUrl ?>images/img_detail_home.png" alt="">
                                <a href=""
                                   class="content_16"><?= isset($shop['name']) && $shop['name'] ? $shop['name'] : '' ?></a>
                            </div>
                            <div class="contact_row">
                                <i class="far fa-map-marker-alt"></i>
                                <span class="content_16"><?= isset($shop['address']) && $shop['address'] ? $shop['address'] : '??ang c???p nh???t ' ?></span>
                            </div>
                            <div class="contact_row">
                                <div class="contact_flex">
                                    <div class="flex">
                                        <i class="far fa-phone-alt"></i>
                                        <a href="tel:<?= $shop['phone'] ?>"
                                           class="content_16"><?= isset($shop['phone']) && $shop['phone'] ? $shop['phone'] : '??ang c???p nh???t' ?></a>
                                    </div>
                                    <div class="flex">
                                        <i class="far fa-envelope"></i>
                                        <a href="mailto:<?= $shop['email'] ?>"
                                           class="content_16"><?= isset($shop['email']) && $shop['email'] ? $shop['email'] : '??ang c???p nh???t' ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pro_content">
                    <div class="content_text">
                        <h3>H??? S?? D??? TH???U</h3>
                    </div>
                </div>
                <?php
                $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])
                ?>
                <?=
                $form->field($model, 'name', [
                    'template' => ' <div class="form-group form-row">{label}<div class="form-field">{input}{error}{hint} </div></div>'
                ])->textInput([
                    'class' => '',
                    'placeholder' => 'T??n c??ng ty',
                    'value' => $shop_user['name'],
                ])->label('T??n c??ng ty', ['class' => 'content_14']);
                ?>
                <?=
                $form->field($model, 'founding', [
                    'template' => ' <div class="form-group form-row">{label} <div class="form-field">{input}{error}{hint}</div></div>'
                ])->textInput([
                    'type' => 'date',
                    'class' => '',

                ])->label('Ng??y th??nh l???p', ['class' => 'content_14']);
                ?>
                <?=
                $form->field($model, 'number_auth', [
                    'template' => ' <div class="form-group form-row">{label} <div class="form-field">{input}{error}{hint} </div></div>'
                ])->textInput([
                    'class' => '',
                    'placeholder' => 'M?? s??? thu???',
                    'value' => $shop_user['number_auth'],
                ])->label('T??n c??ng ty', ['class' => 'content_14']);
                ?>
                <?=
                $form->field($model, 'business', [
                    'template' => ' <div class="form-group form-row">{label} <div class="form-field">{input}{error}{hint} </div></div>'
                ])->textInput([
                    'class' => '',
                    'placeholder' => $model->getAttributeLabel('business'),
                    'value' => $shop_user['number_auth'],
                ])->label($model->getAttributeLabel('business'), ['class' => 'content_14']);
                ?>
                <?=
                $form->field($model, 'phone', [
                    'template' => ' <div class="form-group form-row">{label}<div class="form-field">{input}{error}{hint} </div></div>'
                ])->textInput([
                    'class' => '',
                    'placeholder' => 'S??? ??i???n tho???i',
                    'value' => $shop_user['phone'],
                ])->label($model->phone, ['class' => 'content_14']);
                ?>
                <?=
                $form->field($model, 'email', [
                    'template' => ' <div class="form-group form-row">{label}<div class="form-field">{input}{error}{hint}</div></div>'
                ])->textInput([
                    'class' => '',
                    'placeholder' => 'Nh???p email',
                    'value' => $shop_user['email'],
                ])->label($model->email, ['class' => 'content_14']);
                ?>
                <?=
                $form->field($model, 'website', [
                    'template' => ' <div class="form-group form-row">{label}<div class="form-field">{input}{error}{hint}</div></div>'
                ])->textInput([
                    'class' => '',
                    'placeholder' => 'Nh???p website c??ng ty',
                    'value' => $shop_user['website'],
                ])->label($model->getAttributeLabel('website'), ['class' => 'content_14']);
                ?>
                <?=
                $form->field($model, 'address', [
                    'template' => ' <div class="form-group form-row">{label}<div class="form-field">{input}{error}{hint} </div></div>'
                ])->textInput([
                    'class' => '',
                    'placeholder' => 'Nh???p ?????a ch???',
                    'value' => $shop_user['address'],
                ])->label($model->getAttributeLabel('address'), ['class' => 'content_14']);
                ?>
                <?=
                $form->field($model, 'price', [
                    'template' => ' <div class="form-group form-row">{label}<div class="form-field">{input}{error}{hint} </div></div>'
                ])->textInput([
                    'class' => '',
                    'placeholder' => 'Nh???p v???n ??i???u l???',
                    'value' => $shop_user['price'],
                ])->label($model->getAttributeLabel('price'), ['class' => 'content_14']);
                ?>
                <?=
                $form->field($model, 'file', [
                    'template' => '<div class="form-group form-row">{label}<div class="form-field">{input}{error}{hint}</div></div>'
                ])->textInput([
                    'type' => 'file',
                    'class' => '',
                ])->label($model->getAttributeLabel('attachment'), ['class' => 'content_14']);
                ?>
                <?=
                $form->field($model, 'description', [
                    'template' => '<div class="form-group form-row">{label}<div class="form-field">{input}{error}{hint} </div></div>'
                ])->textarea([
                    'class' => '',
                    'value' =>strip_tags($shop_user['description']) ,
                ])->label($model->getAttributeLabel('description'), ['class' => 'content_14']);
                ?>
                <button class="btn-animation click_send content_16" type="submit">N???p h??? s??
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                         class="bi bi-cursor" viewBox="0 0 16 16">
                        <path d="M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103zM2.25 8.184l3.897 1.67a.5.5 0 0 1 .262.263l1.67 3.897L12.743 3.52 2.25 8.184z"/>
                    </svg>
                </button>
                <?php
                ActiveForm::end();
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(".iuthik1").click(function () {
        var t = $(this);
        var package_id = $(this).data('id');
        $.ajax({
            url: "<?= yii\helpers\Url::to(['/package/package/add-like']) ?>",
            type: "get",
            data: {"package_id": package_id},
            success: function (response) {
                var data = JSON.parse(response);
                if (data.success) {
                    t.toggleClass('active');
                } else {
                    alert(data.message)
                }
            },
        });
    });

    function check_goithau() {
        var id = '<?=  yii::$app->user->id?>';

        if (!id) {
            var r = confirm("B???n ch??a ????ng nh???p vui l??ng ????ng nh???p ????? thao t??c");
            if (r == true) {
                window.location.href = "<?= yii\helpers\Url::to(['/login/login/login']) ?>";
            }
            else {

            }

        }

        //$.ajax({
        //    url: "<?//= yii\helpers\Url::to(['/package/package/check']) ?>//",
        //    type: "get",
        //    data: {"package_id": package_id},
        //    success: function (response) {
        //        var data = JSON.parse(response);
        //        if (data.success) {
        //            $('#popup_goithau').addClass('active');
        //        } else {
        //            alert(data.message);
        //        }
        //    },
        //});
    }
    function check_dangky() {
        $('#popup_goithau').addClass('active');
    }
</script>



