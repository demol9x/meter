<?php


use common\components\ClaHost;

?>

<div class="pro_main">
    <div id="pro_desc_list_2" class="pro_description_2 active">
        <div class="pro_package">
            <div class="pro_content">
                <div class="content_text">
                    <h3><?= $title ?></h3>
                </div>
            </div>
            <div class="pro_flex">
                <div class="item-top-sdps">
                    <div class="tongthongso">
                        <div class="tongquan">
                            <h4 class="title_48"><?= isset($rating['rate']) && $rating['rate'] ? $rating['rate'] : 0 ?>
                                /5</h4>
                            <div>
                                <div class="star-vote">
                                    <div class="star-style star-rating"
                                         style="background-image: url(<?= ClaHost::getImageHost() ?>/imgs/star.jpg); width:<?= $rating['rate'] * 100 / 5 ?>%"></div>
                                    <div class="star-style star_background"
                                         style="background-image: url(<?= ClaHost::getImageHost() ?>/imgs/star2.jpg);"></div>
                                </div>
                                <p class="content_14">
                                    (<?= isset($rating['rate_count']) && $rating['rate_count'] ? $rating['rate_count'] : 0 ?>
                                    Đánh giá)</p>
                            </div>
                        </div>
                        <div class="chitiet">
                            <div class="phantram">
                                <span class="content_14">5</span>
                                <i class='fa fa-star'></i>
                                <div class="w3-border">
                                    <div class="w3-oran" style="height:7.86px;width:100%"></div>
                                </div>
                                <span class="content_14">57</span>
                            </div>
                            <div class="phantram">
                                <span class="content_14">4</span>
                                <i class='fa fa-star'></i>
                                <div class="w3-border">
                                    <div class="w3-oran" style="height:7.86px;width:80%"></div>
                                </div>
                                <span class="content_14">20</span>
                            </div>
                            <div class="phantram">
                                <span class="content_14">3</span>
                                <i class='fa fa-star'></i>
                                <div class="w3-border">
                                    <div class="w3-oran" style="height:7.86px;width:30%"></div>
                                </div>
                                <span class="content_14">17</span>
                            </div>
                            <div class="phantram">
                                <span class="content_14">2</span>
                                <i class='fa fa-star'></i>
                                <div class="w3-border">
                                    <div class="w3-oran" style="height:7.86px;width:20%"></div>
                                </div>
                                <span class="content_14">2</span>
                            </div>
                            <div class="phantram">
                                <span class="content_14">1</span>
                                <i class='fa fa-star'></i>
                                <div class="w3-border">
                                    <div class="w3-oran" style="height:7.86px;width:10%"></div>
                                </div>
                                <span class="content_14">1</span>
                            </div>
                        </div>
                    </div>
                    <div class="list-item-images">
                        <p class="content_14">Tất cả hình ảnh (<?= $images['total'] ?>)</p>

                        <!--$images['images'] chính là list tất cả ảnh-->
                        <?php if ($images['images']):
                            if( isset($images['images'][6]) && $images['images'][6]){
                                $data_6=$images['images'][6];
                            }
                            $data_images=array_slice($images['images'],0,5); ?>
                            <div class="item-images">
                                <?php foreach ($data_images as $image): ?>
                                    <div class="image" >
                                        <a data-fancybox="gallery" href="<?= ClaHost::getImageHost() . $image['path'] . $image['name'] ?>" >
                                            <img src="<?= ClaHost::getImageHost() . $image['path'] . $image['name'] ?>" alt="">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                                <?php if(isset($data_6) && $data_6){?>
                                <div class="image" style="position: relative">
                                    <img src="<?= ClaHost::getImageHost() . $data_6['path'] . $data_6['name'] ?>" alt="">
                                    <div class="position_rating_images" >
                                        <a  class="content_16" onclick="viewAllimages()" style="cursor: pointer">
                                            Xem tất cả
                                        </a>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        <?php endif; ?>

                        <div class="item-loccomt">
                            <p class="content_14">Lọc theo:</p>
                            <div class="button-loc">
                                <button class="content_14">Mới nhất</button>
                                <button class="content_14">Có hình ảnh</button>
                                <button class="content_14">Đã mua hàng</button>
                                <button class="content_14">5
                                    <i class='fa fa-star'></i>
                                </button>
                                <button class="content_14">4
                                    <i class='fa fa-star'></i>
                                </button>
                                <button class="content_14">3
                                    <i class='fa fa-star'></i>
                                </button>
                                <button class="content_14">2
                                    <i class='fa fa-star'></i>
                                </button>
                                <button class="content_14">1
                                    <i class='fa fa-star'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Form đánh giá-->
                <?= $this->render('partial/form', ['object_id' => $object_id, 'type' => $type]); ?>
            </div>
            <div class="pro_flex body-comment">
                <?php if ($data):?>
                    <?php foreach ($data as $value):
                        $avatar = ClaHost::getImageHost() . '/imgs/default.png';
                        if (isset($value['user']['avatar_path']) && $value['user']['avatar_path']) {
                            $avatar = ClaHost::getImageHost() . $value['user']['avatar_path'] . $value['user']['avatar_name'];
                        }
                        ?>
                        <div class="item-comment">
                            <div class="avt-main">
                                <div class="image-avt">
                                    <img src="<?= $avatar ?>" alt="">
                                </div>

                                <div class="textch">
                                    <h5 class="content_14"><?= $value['user']['username'] ?></h5>
                                    <p class="content_14"><?= date('d-m-Y', $value['created_at']) ?></p>
                                </div>
                            </div>
                            <div class="item-chat">
                                <?php if ($value['rating']): ?>
                                    <div class="danhgiakh">
                                        <div class="star-vote">
                                            <div class="star-style star-rating"
                                                 style="background-image: url(<?= ClaHost::getImageHost() ?>/imgs/star.jpg); width:<?= $value['rating'] * 100 / 5 ?>%"></div>
                                            <div class="star-style star_background"
                                                 style="background-image: url(<?= ClaHost::getImageHost() ?>/imgs/star2.jpg);"></div>
                                        </div>
                                        <p class="content_14"><?= \common\components\ClaMeter::genStarText()[$value['rating']] ?></p>
                                    </div>

                                <?php endif; ?>
                                <div style="display: flex;flex-wrap: wrap">
                                <?php
                                if(isset($value['images']) && $value['images']){?>
                                    <?php foreach ($value['images'] as $key ){
                                        $avatar_image = ClaHost::getImageHost() . '/imgs/default.png';
                                        if (isset($key['path']) && $key['path']) {
                                            $avatar_image = ClaHost::getImageHost() .$key['path'] . $key['name'];
                                        }
                                        ?>
                                        <div class="images_danhgia_all">
                                            <a data-fancybox="gallery" href="<?= $avatar_image ?>" >
                                                <img src="<?= $avatar_image ?>" alt="<?= $key['name']?>">
                                            </a>
                                        </div>
                                    <?php }?>
                                <?php } ?>
                                </div>
                                <p class="content_14"><?= \yii\bootstrap\Html::encode($value['content']) ?></p>

                                <div class="rep-like">
                                    <div class="rep">
                                        <button onclick="repComment(this)" data-id="<?= $value['id'] ?>"><i
                                                    class="fa fa-reply"></i>&nbsp;Trả lời
                                        </button>
                                    </div>
                                    <button onclick="likeComment(this)" data-id="<?= $value['id'] ?>"
                                            class="<?= $value['is_like'] ? 'like-active' : '' ?>">
                                        <i class="fa fa-thumbs-up"></i>&nbsp;<span>Thích</span>
                                    </button>
                                </div>
                                <?= $this->render('partial/rating_item', ['rating_id' => $value['id']]); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($total > count($data)): ?>
            <div style="text-align: center">
                <a href="javascript:void(0)" onclick="loadComment(this)">Xem thêm &nbsp;<i
                            class="fas fa-chevron-down"></i></a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php if ($images['images']){
    ?>
    <div class="popup_showall_image">
        <div class="flex_show_all">
            <div><div class="images_row_title content_16_b"> Tất cả ảnh  </div><div class="images_close content_16_b" onclick="clickClose()" style="cursor: pointer"> X </div></div>
            <div class="flex_wwwww">
                <?php foreach ($images['images'] as $image): ?>
                    <div class="images_row">
                        <a data-fancybox="gallery"
                           href="<?= ClaHost::getImageHost() . $image['path'] . $image['name'] ?>" >
                            <img src="<?= ClaHost::getImageHost() . $image['path'] . $image['name'] ?>" alt="">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php }?>
<script type="text/javascript">
    var page = parseInt('<?= $page ? $page : 1 ?>');
    var limit = parseInt('<?= $limit ? $limit : 10 ?>');
    var total = parseInt('<?= $total ? $total : 0 ?>');
    <?php if(Yii::$app->user->id) { ?>
    $('body').on('beforeSubmit', 'form#rating-form', function () {
        var form = $(this);
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                var res = JSON.parse(response);
                if (res.success) {
                    alert('<?= Yii::t('app', 'thank_for_rate') ?>');
                    location.reload();
                }
            }
        });
        return false;
    });
    <?php } else { ?>
    $(document).ready(function () {
        $('.check-rate').click(function () {
            if (confirm('<?= Yii::t('app', 'you_need_login_for_rate') ?>')) {
                $('.open-popup-link').click();
            }
        });
        return false;
    });
    <?php } ?>

    function likeComment(t) {
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/ajax/like-comment']) ?>',
            type: 'post',
            data: {
                id: $(t).data('id'),
            },
            success: function (response) {
                var res = JSON.parse(response);
                if (res.success) {
                    $(t).toggleClass('like-active')
                }
            }
        });
    }

    function loadComment(t) {
        page += 1;
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/rating/load-comment']) ?>',
            type: 'post',
            data: {
                type: '<?= $type ?>',
                object_id: '<?= $object_id ?>',
                page: page,
                limit: limit,
            },
            success: function (response) {
                $('.body-comment').append(response);
                console.log(total);
                if (total < page * limit) {
                    $(t).remove();
                }
            }
        });
    }

    function submitComment(id) {
        var content = $('.rep-content' + id).val();
        if(content == ''){
            $('.err' + id).html('Nội dung không được bỏ trống');
            return false;
        }
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/rating/rep-comment']) ?>',
            type: 'post',
            data: {
                id: id,
                content: content,
                type: '<?= $type ?>',
                object_id: '<?= $object_id ?>',
            },
            success: function (response) {
                $('.rep-content' + id).parents('.item-chat').append(response);
                $('.rep-content' + id).parent('.rep-comment').remove();
            }
        });
    }

    function repComment(t) {
        var us_id = '<?= Yii::$app->user->id ?>';
        if(!us_id){
            alert('Bạn phải đăng nhập để thực hiện hành động này.');
            return false;
        }
        var id = $(t).data('id');
        var html = '<div class="rep-comment">\n' +
            '                                    <input type="text" class="form-control rep-content' + id + '">\n' +
            '                                    <button onclick="submitComment(' + id + ')" class="btn-submit-cm">Gửi</button>\n' +
            '                                </div>\n' +
            '                                    <div class="help-block err' + id + '"></div>';
        $(t).parents('.item-chat').find('.rep-comment').remove();
        $(t).parents('.item-chat').append(html);
    }
    function viewAllimages() {
        if($(this).click()){
            $('.popup_showall_image').addClass('active');
        }
    }
    function clickClose() {
        if($(this).click()){
            $('.popup_showall_image').removeClass('active');
        }
    }
</script>