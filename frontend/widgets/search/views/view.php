<?php

use yii\helpers\Url;
?>
<div class="box-search">
    <form class="form-search" id="search_mini_form" method="GET" action="<?= Url::to(['/search/search/index']) ?>">
        <input class="input-text" type="text" value="<?= $key ?>" name="key" placeholder="Từ khóa tìm kiếm...">
        <button class="search-btn-bg" title="Tìm kiếm" type="submit">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>