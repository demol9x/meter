<?php

namespace common\components;

/**
 * @author hungtm <hungtm.0712@gmail.com>
 * get link host, host info
 */
class ClaHost
{

    /**
     * Get host upload for images and files
     */
    static function getUploadHost()
    {
        return __SERVER_NAME . '/mediacenter';
    }

    /**
     * get host view images
     */
    static function getImageHost()
    {
        $servername = \common\components\ClaSite::getServerName();
        return __SERVER_NAME . '/static';
    }

    /**
     * trả về dường dẫn tương đối của media
     */
    static function getMediaBasePath()
    {
        self::getImageHost();
    }

    public static function getLinkImage($path, $name, $options = [])
    {
        if (is_array($options)) {
            $size = isset($options['size']) ? $options['size'] . '/' : '';
        } else {
            $size = $options;
        }
        if ($name) {
            return self::getImageHost() . $path . $size . $name;
        }
        $type = isset($options['type']) ? $options['type'] . '/' : 'default/';
        return self::getImageHost() . '/media/images/default/'  . $type . $size . 'default.png';
    }
}
