<?php if (isset($data) && $data) { ?>
    <div class="fix-social">
        <ul>
            <?php foreach ($data as $menu) { ?>
                <li>
                    <a <?= $menu['link'] ? ($menu['target'] ? 'target="_blank" href="' . $menu['link'] . '"' : 'href="' . $menu['link'] . '"') : '' ?>>
                        <img style="width: 40px; height: 40px;" src="<?= \common\components\ClaHost::getLinkImage($menu['avatar_path'], $menu['avatar_name'], ['size' => 's50_50/']) ?>" alt="<?= $menu['name']; ?>">
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <style>
        .fix-social li img {
            animation: 1s messenger infinite;
            border-radius: 50%;
        }

        .fix-social {
            position: fixed;
            right: 26px;
            bottom: 125px;
            z-index: 9999;
        }

        body .icons-messenger {
            position: relative;
            right: unset;
            bottom: unset;
        }

        .fix-social li {
            margin-bottom: 10px;
            list-style: none;
        }

        .icons-phone {
            background-position: -43px -109px;
            width: 40px;
            height: 40px;
            display: inline-block;
            border-radius: 50%;
            animation: 1s messenger infinite;
        }

        .icons-zalo {
            background-position: -2px -56px;
            width: 40px;
            height: 40px;
            display: inline-block;
            border-radius: 50%;
            animation: 1s messenger infinite;
        }
    </style>
<?php } ?>