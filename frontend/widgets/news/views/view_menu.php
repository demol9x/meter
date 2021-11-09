<?php 
use  yii\helpers\Url;

function writeUl($data) {
    if(isset($data['active'])) unset($data['active']);
    if($data) {
        echo '<i class="fa fa-angle-right changul"></i>';
        echo '<ul class="">';
            foreach ($data as $value) {
                $name = $value['name'];
                echo '<li '.($value['active'] ? 'class="liactive"' : '').'><a href="'. Url::to(['/news/news/category', 'id' => $value['id'], 'alias' => $value['alias']]) .'">'.$name.'</a>';
                if($value['items']) {
                    writeUl($value['items']);
                } 
                echo '</li>';
            }
        echo "</ul>";
    }
}
?>
<style type="text/css">
    .liactive >a{
        background: #5ec1cf;
        color: #fff !important;
        margin: 0px -15px;
        padding: 6px 15px !important;
    }
    .liactive >i {
        color: #fff;
    }
    .menu-new ul li a{
        color: #333;
        padding: 6px 0px;
        display: block;
        font-size: 14px;
    }
    .menu-new ul li a:hover {
        color: #ff6a00;
    }
    .menu-new ul {
        padding-bottom: 30px;
        transition: all .6s ease-in-out 0s;
        -moz-transition: all .6s ease-in-out 0s;
        -o-transition: all .6s ease-in-out 0s;
        -webkit-transition: all .6s ease-in-out 0s;
        -ms-transition: all .6s ease-in-out 0s;
    }
    .menu-new ul li {
        position: relative;
    }
    .menu-new >ul li ul{
        height: 0px;
        overflow: hidden;
        padding: 0px;
    }
    .menu-new >ul li .active {
        height: auto !important;
        overflow: hidden !important;
        padding: 10px 20px !important;
    }

    body .menu-new >ul .liactive >ul {
        height: auto ;
        overflow: hidden;
        padding: 10px 0px 10px 20px;
    }
    li .changul {
        right: 0px;
    }
   /* .menu-new >ul li:hover > ul {
        height: auto;
        overflow: hidden;
        padding: 10px 20px;
    }*/

    .changul:hover {
        background: #337ab79e;
        color: #fff;
    }

    .changul {
        position: absolute;
        right: -10px;
        top: 0px;
        border-radius: 50%;
        padding: 8px 13.5px;
        height: 32px;
        -moz-transition: all .6s ease-in-out 0s;
        -o-transition: all .6s ease-in-out 0s;
        -webkit-transition: all .6s ease-in-out 0s;
        -ms-transition: all .6s ease-in-out 0s;
        cursor: pointer;
    }
</style>
<?php if (isset($data) && $data) { ?>
    <div class="top-5-reason menu-new">
        <div class="title-top-reason">
            <h2><?= Yii::t('app','library_dh') ?></h2>
        </div>
        <ul>
            <?php foreach ($data as $menu) {
                $name = $menu['name'];
                ?>
                <li <?= ($menu['active']) ? 'class="liactive"' : '' ?>><a href="<?= Url::to(['/news/news/category', 'id' => $menu['id'], 'alias' => $menu['alias']]) ?>"><?= $name ?></a>
                    <?php 
                        writeUl($menu['items']);
                    ?>
                </li>
            <?php } ?>
        </ul>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.changul').click(function() {
                if($(this).parent().children('ul').first().attr('class') == '') {
                    $(this).parent().children('ul').first().attr('class', 'active');
                    $(this).css('transform', 'rotate(90deg)');
                } else {
                    $(this).parent().children('ul').first().attr('class', '');
                    $(this).css('transform', 'rotate()');
                }
            });
        });
    </script>
<?php  } ?>