<div class="item">
    <div class="form-group">
        <label class="control-label col-md-3">Công ty: </label>
        <div class="controls col-md-9"> 
            <div class="row">
                <div class="controls col-xs-5">
                    <input name="ApplyWorkHistory[<?php echo $stt ?>][company]" class="form-control" placeholder="Công ty đã làm gần đây" type="text" />
                </div>
                <label class="control-label col-xs-2 txt-right"> Vị trí: </label>
                <div class="controls col-xs-5">
                    <input name="ApplyWorkHistory[<?php echo $stt ?>][position]" class="form-control" placeholder="Vị trí" type="text" />
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Lĩnh vực hoạt động / Ngành nghề công ty: </label>
        <div class="controls col-md-9"> 
            <div class="row">
                <div class="controls col-xs-5">
                    <input name="ApplyWorkHistory[<?php echo $stt ?>][field_business]" class="form-control" placeholder="Lĩnh vực hoạt động" type="text" />
                </div>
                <label class="control-label col-xs-2 txt-right"> Quy mô: </label>
                <div class="controls col-xs-5 select-scale">
                    <?php
                    $scales = \common\models\recruitment\ApplyWorkHistory::getArrayScale();
                    ?>
                    <select name="ApplyWorkHistory[<?php echo $stt ?>][scale]">
                        <?php foreach ($scales as $value => $name) { ?>
                            <option value="<?php echo $value ?>"><?php echo $name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Mô tả chi tiết công việc đã làm: </label>
        <div class="controls col-md-9"> 
            <div class="row">
                <div class="col-xs-12 form-group">
                    <div class="row">
                        <label class="control-label col-xs-3"> Công việc cụ thể: </label>
                        <div class="controls col-xs-9">
                            <input name="ApplyWorkHistory[<?php echo $stt ?>][job_detail]" class="form-control" placeholder="Công việc cụ thể" type="text" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 form-group">
                    <div class="row">
                        <label class="control-label col-xs-3"> Thời gian làm việc: </label>
                        <div class="controls col-xs-9">
                            <input name="ApplyWorkHistory[<?php echo $stt ?>][time_work]" class="form-control" placeholder="Thời gian làm việc" type="text" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 form-group">
                    <div class="row">
                        <label class="control-label col-xs-3"> Nguyên nhân nghỉ việc: </label>
                        <div class="controls col-xs-9">
                            <input name="ApplyWorkHistory[<?php echo $stt ?>][reason_offwork]" class="form-control" placeholder="Nguyên nhân nghỉ việc" type="text" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>