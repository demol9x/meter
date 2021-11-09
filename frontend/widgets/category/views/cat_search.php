<?php

use common\components\ClaHost;

if (isset($data) && $data) {
    ?>
    <div class="cate-search-engine hidden-md hidden-sm hidden-xs">
        <input type="hidden" id="input-search_cat" name="category_id" value="<?= isset($_GET['category_id']) ? $_GET['category_id'] : '' ?>">
        <h2 class="dropdow-btn-search"><span id="sl-name-cat"><?= Yii::t('app', 'category') ?></span> <i class="fa fa-angle-down"></i></h2>
        <div class="dropdow-lv1">
            <ul>
                <li>
                    <a class="change-cat-st" id="cat-0" data="0">
                        <?= Yii::t('app', 'category') ?>
                    </a>
                </li>
                <?php
                foreach ($data as $item) { 
                    $text[0] ='';
                    $text[1] ='';
                    $text[2] ='';
                    ?>
                    <li>
                        <a class="change-cat-st" id="cat-<?= $item['id'] ?>" data="<?= $item['id'] ?>"><?= $item['name'] ?></a>
                        <?php  
                            $kt = 0;
                            if($item['children'])  {
                                foreach ($item['children'] as $item_children) {
                                    $kt = ($kt ==3) ? 0 : $kt;
                                    $text[$kt++] .= '<a class="change-cat-st"  id="cat-'.$item_children['id'].'" data="'.$item_children['id'].'">'.$item_children['name'].'</a>'; 
                                }
                            }
                        ?>
                            <div class="dropdown-cate">
                                <?php for ($i=0; $i < 3; $i++) 
                                    if($text[$i]) {
                                    ?>
                                    <div class="list-cate-lv2">
                                        <?= $text[$i] ?>
                                    </div>
                                <?php } ?>
                            </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.change-cat-st').click(function() {
            $('#input-search_cat').val($(this).attr('data'));
            $('#sl-name-cat').html($(this).html());
            $('.dropdow-lv1').removeClass('open');
        });
        <?php
            if((isset($_GET['category_id']) && $_GET['category_id'])) {
                echo '$("#sl-name-cat").html($("#cat-'.$_GET['category_id'].'").html());';
            }
        ?>
    });
</script>