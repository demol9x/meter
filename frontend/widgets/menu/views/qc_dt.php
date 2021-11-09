<?php if (isset($data) && $data) {
    foreach ($data as $menu) {
                if($orther['type'] >=  $menu['order']) {
                    echo '<b class="actived"><a '.($menu['target'] ? 'target="_blank"' : '').' href="'. $menu['link'].'"><i class="fa fa-check"></i>'.$menu['name'].'</a></b></br>';
                } else {
                    echo '<span class="non-active"><a '.($menu['target'] ? 'target="_blank"' : '').' href="'. $menu['link'].'"><i class="fa fa-times"></i>'.$menu['name'].'</span></a></br>';
                }
            }
    } 
?>
