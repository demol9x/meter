<?php
$url = '/product/product/index';
$get = $_GET;
?>
<div class="site51_profil_col3_locsanpham">
    <div class="locsanpham">
        <div class="pro_fitler">
            <div class="pro_env">
                <span class="content_16_b">Địa điểm</span><i class="fas fa-chevron-right"></i>
            </div>
            <?php
            if(isset($province) && $province){
                ?>
                <div class="fitler">
                    <?php
                    foreach ($province as $key => $value){
                        $arr_p = [];
                        if (isset($_GET['p']) && $_GET['p']) {
                            $arr_p = explode(',',$_GET['p']);
                        }
                        ?>
                        <div>
                            <a class="p_provin" href="javascript:void(0)" data-param="p">
                                <input type="checkbox" id="<?= $value['id']  ?>" name="<?= $value['id']  ?>" value="<?= $value['id']  ?>" <?=(in_array($value['id'],$arr_p)) ? 'checked' : ''?>>
                                <label for="<?= $value['id']  ?>"> <?= $value['name']?></label>
                            </a>
                        </div>
                    <?php }?>
                </div>
            <?php }?>
        </div>
        <div class="pro_fitler">
            <div class="pro_env">
                <span class="content_16_b">Khoảng cách</span><i class="fas fa-chevron-right"></i>
            </div>
            <div class="fitler">
                <div class="fitler_flex">
                    <div>
                        <input type="checkbox" id="10-50" name="10-50" value="10-50" checked>
                        <label for="10-50"> 10 - 50 km</label>
                    </div>
                    <span>15</span>
                </div>
                <div class="fitler_flex">
                    <div>
                        <input type="checkbox" id="60-100" name="60-100" value="60-100">
                        <label for="60-100"> 60 - 100 km</label>
                    </div>
                    <span>15</span>
                </div>
                <div class="fitler_flex">
                    <div>
                        <input type="checkbox" id="60-100" name="60-100" value="60-100">
                        <label for="60-100"> 60 - 100 km</label>
                    </div>
                    <span>15</span>
                </div>
                <div class="fitler_flex">
                    <div>
                        <input type="checkbox" id="60-100" name="60-100" value="60-100">
                        <label for="60-100"> 60 - 100 km</label>
                    </div>
                    <span>15</span>
                </div>
                <div class="fitler_flex">
                    <div>
                        <input type="checkbox" id="60-100" name="60-100" value="60-100">
                        <label for="60-100"> 60 - 100 km</label>
                    </div>
                    <span>15</span>
                </div>

            </div>
        </div>
        <div class="pro_fitler">
            <div class="pro_env">
                <span class="content_16_b">Ngày đăng</span><i class="fas fa-chevron-right"></i>
            </div>
            <div class="fitler">
                <div class="fitler_flex">
                    <div>
                        <input type="checkbox" id="moinhat" name="moinhat" value="moinhat" checked>
                        <label for="moinhat"> Mới nhất</label>
                    </div>
                    <span>15</span>
                </div>

                <div class="fitler_flex">
                    <div>
                        <input type="checkbox" id="tuantruoc" name="tuantruoc" value="tuantruoc">
                        <label for="tuantruoc"> Tuần trước</label>
                    </div>
                    <span>15</span>
                </div>
                <div class="fitler_flex">
                    <div>
                        <input type="checkbox" id="thangtruoc" name="thangtruoc" value="thangtruoc">
                        <label for="thangtruoc"> Tháng trước</label>
                    </div>
                    <span>15</span>
                </div>
            </div>
        </div>
    </div>
</div>