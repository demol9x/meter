<?php  
    use yii\helpers\Url;
?>
<div class="ctn-trick-faq">
    <h2><?= isset($category) ? $category->name : Yii::t('app', 'qa_title') ?></h2>
    <div class="list-trick-faq">
        <ul>
            <?php foreach ($data as $qa) {?>
                <li>
                    <a href="<?= Url::to(['/qa/qa/detail', 'id' => $qa['id'], 'alias' => $qa['alias']]) ?>">
                        <i class="fa fa-file-text" aria-hidden="true"></i> 
                        <?= $qa['title'] ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="paginate">
        <?=
        yii\widgets\LinkPager::widget([
            'pagination' => new yii\data\Pagination([
                'pageSize' => $limit,
                'totalCount' => $totalitem
                    ])
        ]);
        ?>            
    </div>
</div>