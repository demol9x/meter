<?php if ($user) { ?>
    <ul>
        <li>Tên tài khoản: <b><?= $user->username ?></b></li>
        <?php if ($shop) { ?>
            <li>Tên doanh nghiệp: <b><?= $shop->name ?></b></li>
        <?php } ?>
        <li>Email: <b><?= $user->email ?></b></li>
    </ul>
    <script>
        $('#transfer-user_receive').val(<?= $user->id ?>);
        $('#form-transfer').attr('csave', '1');
    </script>
<?php } else { ?>
    <ul>
        <li>Không tìm thấy tài khoản. Vui lòng kiểm tra lại thông tin.</li>
    </ul>
    <script>
        $('#form-transfer').attr('csave', '0');
    </script>
<?php } ?>