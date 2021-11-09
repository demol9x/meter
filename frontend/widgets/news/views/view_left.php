<?php

use common\components\ClaHost;
use yii\helpers\Url;
?>
<?php if (isset($data) && $data) { ?>
    <div class="popular-posts widget widget__sidebar stl_list_item " id="recent-posts-4">
        <div class="title-site">
            <h2>
                <a href="javascript:void(0)" title="Tin nổi bật">Tin nổi bật</a>
                <span class="border-title"></span>
            </h2>
        </div>
        <div class="widget-content">
            <ul class="posts-list unstyled clearfix">
                <?php foreach ($data as $news) { ?>
                    <li>
                        <figure class="featured-thumb" style="width:35%">
                            <a href="<?= Url::to(['/news/news/detail', 'id' => $news['id'], 'alias' => $news['alias']]) ?>" title="<?= $news['title'] ?>">
                                <img src="<?= ClaHost::getImageHost(), $news['avatar_path'], 's100_100/', $news['avatar_name'] ?>" style=" width: 100px;">
                            </a> 
                        </figure>
                        <!--featured-thumb-->
                        <h4><a title="<?= $news['title'] ?>" href="<?= Url::to(['/news/news/detail', 'id' => $news['id'], 'alias' => $news['alias']]) ?>"><?= $news['title'] ?></a></h4>
                        <p class="post-meta"><i class="icon-calendar"></i>
                            <time class="entry-date"><?= date('d/m/Y', $news['publicdate']) ?></time>
                        </p>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <!--widget-content--> 
    </div>
    <?php
}
?>