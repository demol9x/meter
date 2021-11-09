<?php

use common\components\ClaHost;
use yii\helpers\Url;

if (isset($data) && $data) {
    ?>
    <style type="text/css">
        .item-cate-menu h3 {
            font-size: 14px;
            line-height: 18px !important;
        }
    </style>
    <div class="cate-menu-inhome">
        <div class="container">
            <div class="title-standard">
                <h2>
                    <a href="javascript:void(0)"><?= Yii::t('app', 'menu') ?></a>
                </h2>
                <div class="right">
                    <h2><a class="copy_bl">LINK BẢO LÃNH</a></h2>
                </div>
            </div>
            <div class="list-cate-menu-mobile">
                <?php
                foreach ($data as $item) {
                    $link = Url::to(['/product/product/category/', 'id' => $item['id'], 'alias' => $item['alias']]);
                    ?>
                     <div class="item-cate-menu"  data-merge="1">
                        <a href="<?= $link ?>" title="<?= $item['name'] ?>">
                            <div class="img" <?= $item['avatar_name'] ? 'style="background-image: url('.ClaHost::getImageHost(). $item['avatar_path']. 's80_80/'. $item['avatar_name'] .'"' : '' ?>  alt="<?= $item['name'] ?>"></div>
                            <h3>
                                <?= $item['name'] ?>
                            </h3>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.copy_bl').click(function () {
            var copyText = document.getElementById("linkcopy");
            copyText.select();
            document.execCommand("copy");
            $(this).html('Copied LINK BẢO LÃNH');
            return false;
        });
    </script>
<?php } ?>