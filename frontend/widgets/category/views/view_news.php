<?php

use common\components\ClaHost;

if (isset($data) && $data) {
    ?>
    <div class="cate-news-detail">
        <h2>
            Danh mục bài viết
        </h2>
        <ul>
            <?php
            foreach ($data as $item) {
                ?>
                <li>
                    <a href="<?= $item['link'] ?>" title="<?= $item['name'] ?>"><?= $item['name'] ?></a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
    <?php
}
?>