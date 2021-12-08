<?php

use yii\helpers\Url;
?>
<table class="table table-bordered" style="margin: 15px 0 5px 0; color: #888888">
    <tr><td><?= $file->display_name ?></td></tr>
    <tr><td>Cập nhật: <?= date('d-m-Y', $file->updated_at) ?></td></tr>
    <tr>
        <td style="text-align: center">
            <a style="background: none; text-decoration: underline" href="<?= Url::to(['/profile/profile/download-file-cv', 'id' => $file->id]) ?>">Download</a>
        </td>
    </tr>
</table>