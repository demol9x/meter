<?php

namespace common\components;

/**
 * @author trungduc <trungduc.vnu@gmail.com>
 */
class ClaMeter
{

    public static function betweenTwoPoint($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        $km = $angle * $earthRadius;
        $km = explode('.', $km);
        return $km[0] / 1000;
    }

    static function genMoneyText($price_min, $price_max)
    {
        if ($price_min < 1000 && $price_max < 1000) {
            return $price_min . ' triệu - ' . $price_max . ' triệu';
        }
        if($price_min < 1000 && $price_max >= 1000){
            return $price_min . ' triệu - ' . $price_max/1000 . ' tỷ';
        }

        if($price_min >= 1000 && $price_max >= 1000){
            return $price_min/1000 . ' tỷ - ' . $price_max/1000 . ' tỷ';
        }

        return $price_min . ' - ' . $price_max . ' triệu';
    }

    static function genStarText()
    {
        return [
            1 => 'Rất tệ',
            2 => 'Tệ',
            3 => 'Bình thường',
            4 => 'Tốt',
            5 => 'Rất tốt',
        ];
    }
}
