<?php

namespace api\modules\app\controllers;


use common\models\media\Video;

class BannerController extends AppController
{
    function actionPopupHome()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $group_id = isset($post['group_id']) && $post['group_id'] ? $post['group_id'] : '';
        $group = \common\models\banner\BannerGroup::findOne(['id' => $group_id]);
        $resonse['type'] = '';
        $video = Video::getVideoInCategory(2,[
            'limit' => 1,
            'page' => 1,
            'order' => 'ishot DESC, id DESC'
        ]);
        if($video){
            $resonse['code'] = 1;
            $resonse['data'] = $video;
            $resonse['type'] = 'video';
            return $this->responseData($resonse);
        }
        if ($group) {
            $limit = isset($post['limit']) ? $post['limit'] : '';
            $category_id = isset($post['category_id']) ? $post['category_id'] : '';
            $data = \common\models\banner\Banner::getBannerFromGroupId($group_id, ['limit' => $limit, 'category_id' => $category_id]);
            $resonse['data'] = [];
            if ($data) {
                foreach ($data as $item) {
                    if ($item['src'][0] == '/') {
                        $item['src'] = \common\components\ClaHost::getImageHost() . $item['src'];
                    }
                    $resonse['data'][] = $item;
                }
            }
            $resonse['type'] = 'image';
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy danh sách banner thàng công';
        } else {
            $resonse['error'] = "Nhóm banner không tồn tại";
        }

        return $this->responseData($resonse);
    }
}
