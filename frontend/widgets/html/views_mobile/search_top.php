<?php

use yii\helpers\Url;
use common\components\ClaHost;
use common\components\ClaLid;
?>
<div class="flex-col flex-right search-engine">
        <?=
            \frontend\widgets\category\CategoryWidget::widget([
                'view' => 'cat_search',
                'type' => common\components\ClaCategory::CATEGORY_PRODUCT
            ])
        ?>
        <input type="text" class="text-search hidden-xs" name="key" placeholder="<?= Yii::t('app', 'enter_product') ?>" value="<?= isset($_GET['key']) ? $_GET['key'] : '' ?>">
        <select name="" id="" class="location hidden-md hidden-sm hidden-xs">
            <option value="1">Địa điểm</option>
            <option value="1">Hà nội</option>
            <option value="1">Hồ chí minh</option>
            <option value="1">Đà nẵng</option>
        </select>
        <button type="submit" class="submit-search btn-style-2 hidden-xs">Tìm kiếm</button>
         <a class="btn-style-2 btn-show-search"><i class="fa fa-cog" aria-hidden="true"></i><span class="hidden-md hidden-sm hidden-lg">Tìm kiếm</span> nâng cao</a>
        <div class="close-btn"></div>
    </form>
</div>
