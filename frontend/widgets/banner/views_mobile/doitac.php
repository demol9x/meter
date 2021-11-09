<style type="text/css">
    .item-doi-tac {
        height: 100px;
        overflow: hidden;
        display: inline-block;
        margin-right: 10px;
    }

    .doi-tac {
        padding-left: 30px;
    }

    .item-doi-tac a {
        width: 100px;
        height: 100px;
        display: flex;
        background: #fff;
    }

    .item-doi-tac img {
        height: auto;
        max-height: 100%;
        width: auto;
        max-width: unset;
        margin: auto;
    }
</style>
<?php if (isset($data) && $data) { ?>
    <div class="doi-tac">
        <?php foreach ($data as $tg) {
            $banner->setAttributeShow($tg); ?>
            <div class="item-doi-tac">
                <div class="img-item-doi-tac">
                    <a <?= $banner['target'] ? 'target="_blank"' : '' ?> <?= $banner['link'] ? 'href="' . $banner['link'] . '"' : ''; ?>>
                        <img src="<?= $banner->src ?>" title="<?= $banner['name']; ?>" alt="<?= $banner['name']; ?>">
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>