<?php $this->beginContent('@frontend/mobile/modules/management/views/layouts/main_user.php'); ?>
<style>
    .tbllisting {
        border-collapse: collapse;
        font-family: Arial, Tahoma;
        background: #fff;
        font-weight: bold;
        width: 100%;
    }

    .box-chitiet-taikhoan .tbllisting tr td:first-child,
    .box-chitiet-taikhoan .tbllisting tr th:first-child {
        border-radius: 4px 0 0 4px;
    }

    .box-chitiet-taikhoan .tbllisting th {
        background: #dbbf6d;
        font-weight: bold;
        color: #fff;
    }

    .box-chitiet-taikhoan .tbllisting td,
    .box-chitiet-taikhoan .tbllisting th {
        padding: 10px 15px;
        text-align: center;
        border: 1px solid #eee;
    }

    .colCenter {
        text-align: center !important;
        font-size: 12px;
        padding: 10px;
    }

    .box-chitiet-taikhoan .tbllisting td {
        background: #fff;
        color: #222;
    }

    .box-chitiet-taikhoan .tbllisting td,
    .box-chitiet-taikhoan .tbllisting th {
        padding: 10px 15px;
        text-align: center;
        border: 1px solid #eee;
    }
</style>
<?= $content ?>
<?php $this->endContent(); ?>