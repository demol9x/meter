<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
    <?php if (isset($categories) && $categories) { ?>
        <div class="box-filter">
            <h2>NGÀNH NGHỀ</h2>
            <div class="group-check-box">
                <?php foreach ($categories as $category_id => $category) { ?>
                    <div class="checkbox">
                        <input type="checkbox" class="ais-checkbox" value="<?= $category_id ?>">
                        <label><span class="text-clip" title="<?= $category['category_name'] ?>"><?= $category['category_name'] ?></span></label>
                        <span class="facet-count pull-right"><?= $category['count_job'] ?></span>
                    </div>
                <?php } ?>
            </div>
            <div class="view-more-list-job"><a href="javascript:void(0);">Xem thêm</a></div>
        </div>
    <?php } ?>
    <?php if (isset($locations) && $locations) { ?>
        <div class="box-filter">
            <h2>ĐỊA ĐIỂM</h2>
            <div class="group-check-box">
                <?php foreach ($locations as $province_id => $province) { ?>
                    <div class="checkbox">
                        <input type="checkbox" class="ais-checkbox" value="<?= $province_id ?>">
                        <label><span class="text-clip" title="<?= $province['province_name'] ?>"><?= $province['province_name'] ?></span></label>
                        <span class="facet-count pull-right"><?= $province['count_job'] ?></span>
                    </div>
                <?php } ?>
            </div>
            <div class="view-more-list-job"><a href="javascript:void(0);">Xem thêm</a></div>
        </div>
    <?php } ?>
    <?php if (isset($skills) && $skills) { ?>
        <div class="box-filter">
            <h2>KỸ NĂNG</h2>
            <div class="group-check-box">
                <?php foreach ($skills as $skill_id => $skill) { ?>
                    <div class="checkbox">
                        <input type="checkbox" class="ais-checkbox" value="<?= $skill['skill_name'] ?>">
                        <label><span class="text-clip" title="<?= $skill['skill_name'] ?>"><?= $skill['skill_name'] ?></span></label>
                        <span class="facet-count pull-right"><?= $skill['count_job'] ?></span>
                    </div>
                <?php } ?>
            </div>
            <div class="view-more-list-job"><a href="javascript:void(0);">Xem thêm</a></div>
        </div>
    <?php } ?>
    <div class="box-filter">
        <h2>MỨC LƯƠNG</h2>
        <div class="group-check-box">
            <?php
            $salaries = common\models\recruitment\Recruitment::arraySalaryDetail();
            ?>
            <?php foreach ($salaries as $salary_id => $salary_name) { ?>
                <div class="radio">
                    <input type="radio" class="" value="<?= $salary_id ?>">
                    <label><span class="text-clip" title="<?= $salary_name ?>"><?= $salary_name ?></span></label>
                </div>
            <?php } ?>
        </div>
        <div class="view-more-list-job"><a href="javascript:void(0);">Xem thêm</a></div>
    </div>
</div>
<script type="text/javascript">
    function insertParam(key, value) {
        key = encodeURI(key);
        value = encodeURI(value);
        var kvp = document.location.search.substr(1).split('&');
        var i = kvp.length;
        var x;
        while (i--) {
            x = kvp[i].split('=');
            if (x[0] == key) {
                x[1] = value;
                kvp[i] = x.join('=');
                break;
            }
        }
        if (i < 0) {
            kvp[kvp.length] = [key, value].join('=');
        }
        document.location.search = kvp.join('&');
    }
</script>