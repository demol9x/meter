<?php

namespace common\models\user;

use common\components\ClaGenerate;
use common\components\ClaLid;
use common\models\product\ProductCategory;
use Yii;

/**
 */
class UserPointHelper
{

    public $dataLog = [];

    /**
     * Get point current user
     * @param $userId
     * @return UserPoint|null
     */
    public function getModelUserPoint($userId)
    {
        $userPoint = UserPoint::findOne($userId);
        if ($userPoint === NULL) {
            $userPoint = new UserPoint();
            $userPoint->user_id = $userId;
            $userPoint->point = 0;
            $userPoint->point_hash = ClaGenerate::encrypt($userPoint->point);
        }
        //
        return $userPoint;
    }

    /**
     * Add point to current user
     * @param $userId
     * @param $point
     * @param $orderId
     * @return bool
     */
    public function addPointForUser($userId, $point, $orderId)
    {
        $userPoint = $this->getModelUserPoint($userId);
        if ($userPoint->point != ClaGenerate::decrypt($userPoint->point_hash)) {
            $userPoint->point_error = ClaLid::STATUS_ACTIVED;
            return $userPoint->save();
        }
        //
        $userId = $userPoint->user_id;
        $pointBefore = $userPoint->point;
        $pointChange = $point;
        $pointAfter = $pointBefore + $pointChange;
        $type = UserPointLog::TYPE_PLUS;
        $reason = 'Cộng điểm từ đơn hàng';
        // Check point equal point_hash
        if ($userPoint->point == ClaGenerate::decrypt($userPoint->point_hash)) {
            $userPoint->point += $point;
            $userPoint->point_hash = ClaGenerate::encrypt($userPoint->point);
            if ($userPoint->save()) {
                return $this->addLogPoint($userId, $pointBefore, $pointChange, $pointAfter, $type, $reason, $orderId);
            }
        }
    }

    /**
     * @param $userId
     * @param $pointBefore
     * @param $pointChange
     * @param $pointAfter
     * @param $type
     * @param $reason
     * @param $orderId
     * @return bool
     */
    public function addLogPoint($userId, $pointBefore, $pointChange, $pointAfter, $type, $reason, $orderId)
    {
        $log = new UserPointLog();
        $log->user_id = $userId;
        $log->point_before = $pointBefore;
        $log->point_change = $pointChange;
        $log->point_after = $pointAfter;
        $log->type = $type;
        $log->reason = $reason;
        $log->order_id = $orderId;
        $log->data = json_encode($this->dataLog);
        return $log->save();
    }

    /**
     * Get all point from shopping cart
     * @param $data
     * @return float|int
     */
    public function getPoint($data)
    {
        $point = 0;
        foreach ($data as $item) {
            $point += $this->getPointItem($item);
        }
        //
        return $point;
    }

    /**
     * Get point from item in shopping cart
     * @param $item
     * @return float|int
     */
    public function getPointItem($item)
    {
        $category = ProductCategory::findOne($item['category_id']);
        if ($category === false || $category['point_percent'] == 0) {
            return 0;
        }
        //
        $totalPrice = $item['price'] * $item['quantity'];
        $pointPercent = $category['point_percent'];
        $point = ($totalPrice / 100) * $pointPercent;
        //
        $this->dataLog[] = [
            'category_id' => $item['category_id'],
            'percent' => $pointPercent,
            'product_id' => $item['id'],
            'quantity' => $item['quantity'],
        ];
        //
        return $point;
    }
}
