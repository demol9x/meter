<?php

namespace frontend\components;

use common\components\ClaLid;
use common\components\ClaGenerate;
use yii\db\Query;
use yii\helpers\Url;

/**
 * Description of FTSMySQL
 *
 */
class FTSNormal {

    public $table = 'video';
    public $limit = 30;
    public $keyword = '';

    /**
     * search and return result
     * 
     * @param type $keyword
     * @param type $type
     * @return type
     */
    function search($keyword, $type) {
        $keyword = $this->processKeyWord($keyword);
        switch ($type) {
            case ClaLid::SEARCH_INDEX_TYPE_PROVINCE: {
                    $this->table = 'province';
                    $data = (new Query())->select('*')
                            ->from($this->table)
                            ->where("name like {$keyword}")
                            ->limit($this->limit)
                            ->all();
                }break;
            default: {
                    $this->table = 'video';
                    $data = (new Query())->select('*')
                            ->from($this->table)
                            ->where("name like {$keyword} AND status=" . ClaLid::STATUS_ACTIVED)
                            ->limit($this->limit)
                            ->all();
                }
        }
        $results = $this->processData($data, $type);
        return $results;
    }

    /**
     * process keyword
     * 
     * @param type $keyword
     * @return type
     */
    function processKeyWord($keyword = '') {
        $return = '';
        $keyword = trim($keyword);
        if ($keyword) {
            $this->keyword = $keyword;
            $keywords = explode(' ', $keyword);
            if ($keywords) {
                $return = implode('%', $keywords);
                $return = '%' . $return . '%';
                $return = ClaGenerate::quoteValue($return);
            }
        }
        return $return;
    }

    function processData($data = null, $type = '') {
        $results = array();
        if ($data) {
            foreach ($data as $dt) {
                $key = isset($dt['cat_id']) ? $dt['cat_id'] : $dt['id'];
                $dt['type'] = $type;
                $results[$key] = $dt;
                $results[$key]['content'] = $this->getContent($dt, $type);
                $results[$key]['url'] = $this->getItemUrl($dt);
            }
        }
        return $results;
    }

    function getContent($data = array(), $type = '') {
        $content = '';
        switch ($type) {
            case ClaLid::SEARCH_INDEX_TYPE_VIDEO: {
                    $content = isset($data['name_en']) ? $data['name_en'] : $data['name'];
                }break;
            case ClaLid::SEARCH_INDEX_TYPE_PROVINCE: {
                    $content = isset($data['name_en']) ? $data['name_en'] : $data['name'];
                }break;
        }
        return $content;
    }

    /**
     * 
     * @param type $item
     */
    function getItemUrl($item = null) {
        $url = '';
        if ($item && isset($item['type'])) {
            switch ($item['type']) {
                case ClaLid::SEARCH_INDEX_TYPE_VIDEO: {
                        $url = Url::to(['/video/detail', 'id' => $item['id'], 'alias' => $item['alias']]);
                    }break;
                case ClaLid::SEARCH_INDEX_TYPE_PROVINCE: {
                        $url = Url::to(['/video/province', 'id' => $item['id'], 'alias' => $item['alias']]);
                    }break;
            }
        }
        return $url;
    }

    function markKeyword($string = '') {
        if ($this->keyword) {
            $keywords = explode(' ', $this->keyword);
            if ($keywords) {
                foreach ($keywords as $kw) {
                    $string = preg_replace('/' . $kw . '/i', '<b>' . $kw . '</b>', $string);
                }
            }
        }
        return $string;
    }

    /**
     * set limit
     * @param type $limit
     */
    function setLimit($limit) {
        if ($limit)
            $this->limit = $limit;
    }

}
