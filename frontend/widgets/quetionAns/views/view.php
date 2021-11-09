<?php if($categorys) { ?>
<div class="staticpage stfaq pl15">
    <h2><?= Yii::t('app', 'question_normal') ?></h2>
    <?php  ?>
    <div class="faq-accordion">
        <div aria-multiselectable="true" class="panel-group" id="accordion" role="tablist">
            <?php $open =1; foreach ($categorys as $category) { ?>
                <div class="item">
                    <p>
                        <span class="font18">
                            <strong><?= Trans($category['name'], $category['name_en']) ?></strong>
                        </span>
                    </p> 
                    <?php  $i =1;  foreach ($data as $qa) 
                        if($qa['cat_id']  == $category['id']) {
                        ?>
                        <div class="panel actives">
                            <div class="panel-heading" id="heading<?= $qa['id'] ?>" role="tab">
                                <h4 class="panel-title"><?= $i++ ?>. <a aria-controls="collapse<?= $qa['id'] ?>" aria-expanded="<?= ($open) ? 'true' : 'false' ?>" class="<?= ($open) ? '' : 'collapsed' ?>" data-parent="#accordion" data-toggle="collapse" href="#collapse<?= $qa['id'] ?>" role="button"> <?= Trans($qa['question'], $qa['question_en']) ?> </a></h4>
                            </div>

                            <div aria-labelledby="heading<?= $qa['id'] ?>" class="panel-collapse collapse <?= ($open) ? 'in' : '' ?>" id="collapse<?= $qa['id'] ?>" role="tabpanel" style="" aria-expanded="<?= ($open) ? 'true' : 'false' ?>">
                                <div class="panel-body">
                                    <p><?= Trans($qa['answer'], $qa['answer_en']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php $open =0;} ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>
