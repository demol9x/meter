<?php
use yii\helpers\Url;
?>
<link rel="stylesheet" href="<?= yii::$app->homeUrl ?>css/diachicanhan.css">
<div class="item_right">
    <div class="form-create-store">
        <div class="title-form">
            <h2 class="content_15"><img src="<?= yii::$app->homeUrl?>images/ico-map-marker.png" alt=""> ĐỊA CHỈ</h2>
            <a href="<?= Url::to(['/profile/profile/update-address']) ?>" class="add-address-pay">Thêm địa chỉ mới</a>
        </div>
        <div class="list-address-pay">

            <?php foreach ($model as $key){?>
            <div class="item-address-pay">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                        <h2>
                            <b>Họ và tên:</b>
                            <?php echo $key['name_contact'] ?>
                        </h2>
                        <p>
                            <b>Điện thoại:</b>
                            <?php echo $key['phone'] ?>
                        </p>
                        <p>
                            <b>Địa chỉ:</b>
                           <?php echo $key['address'] ?>
                        </p>
                        <div class="btn-default-pay">
                            <?php if(isset($key['isdefault']) && $key['isdefault']==1 ){
                             ?>
                            <a style="cursor: no-drop">Mặc định</a>
                            <span><i class="fa fa-check"></i> Địa chỉ gửi đến</span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                        <div class="tool-box">
                            <a href="<?= Url::to(['/profile/profile/update-address','id'=>$key['id']])?>" class="open-input-fixeds">
                                <i class="fa fa-pencil"></i>Cập nhật
                            </a>
                            <?php if(isset($key['isdefault']) && $key['isdefault'] == 1 ){
                            ?>
                            <?php } else{?>
                            <a class="cance" onclick="return confirm('Bạn có chắn chắn xóa??');" href="<?= Url::to(['/profile/profile/delete-address','id'=>$key['id']])?>"><i class="fa fa-times"></i>Xóa</a>
                            <a class="btn-set-default active" href='#'">Chọn làm mặc định</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            </div>
        </div>
    </div>
</div>


