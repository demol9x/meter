<?php
if (isset($attributes) && $attributes) {
    ?>
    <div class="filter-product">
        <div class="container">
            <div class="content-filter">
                <p class="title-block">Tùy chọn</p>
                <div class="list-filter">
                    <?php
                    foreach ($attributes as $key => $attribute) {
                        echo $this->render('partial/' . $attribute['att']['frontend_input'], [
                            'key' => $key,
                            'attribute' => $attribute
                        ]);
                        ?>

                        <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        function removeParam(key) {
            var url = document.location.href;
            var params = url.split('?');
            if (params.length == 1) {
                return;
            }
            url = params[0] + '?';
            params = params[1];
            params = params.split('&');

            $.each(params, function (index, value) {
                var v = value.split('=');
                if (v[0] != key) {
                    url += value + '&';
                }
            });
            url = url.replace(/&$/, '');
            url = url.replace(/\?$/, '');
            document.location.href = url;
        }

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
        $(document).ready(function () {
            //--Search select-
            $('.chosen-select').chosen({
                allow_single_deselect: true
            }).change(function () {
                var value = $(this).val();
                var res = value.split("=");
                if (res[0] == 'empty') {
                    removeParam(res[1]);
                } else {
                    insertParam(res[0], res[1]);
                }
            });

            $(window).off('resize.chosen')
                    .on('resize.chosen', function () {
                        $('.chosen-select').each(function () {
                            var $this = $(this);
                            $this.next().css({'width': $this.parent().width()});
                        });
                    }).trigger('resize.chosen');
            //resize chosen on sidebar collapse/expand
            $(document).on('settings.ace.chosen', function (e, event_name, event_val) {
                if (event_name != 'sidebar_collapsed') {
                    return;
                }
                $('.chosen-select').each(function () {
                    var $this = $(this);
                    $this.next().css({'width': $this.parent().width()});
                });
            });


            $('#chosen-multiple-style .btn').on('click', function (e) {
                var target = $(this).find('input[type=radio]');
                var which = parseInt(target.val());
                if (which == 2)
                    $('#form-field-select-4').addClass('tag-input-style');
                else
                    $('#form-field-select-4').removeClass('tag-input-style');
            });
        });
    </script>
    <?php
}
?>