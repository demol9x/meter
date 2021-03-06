<?php

namespace common\models\news;

use Yii;
use common\components\ClaLid;
use yii\db\Query;

/**
 * This is the model class for table "news".
 *
 * @property string $id
 * @property string $title
 * @property string $alias
 * @property string $category_id
 * @property string $short_description
 * @property string $description
 * @property integer $status
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $author
 * @property string $updated_at
 * @property string $publicdate
 * @property string $viewed
 * @property string $source
 * @property integer $ishot
 * @property integer $type
 * @property integer $real_time
 * @property integer $start_date
 * @property integer $end_date
 * @property string $created_at
 * @property string $link_video
 * @property string $address
 * @property string $discount_code
 */
class News extends \common\models\ActiveRecordC
{

    const DEFAULT_ORDER = " id DESC ";
    const CATEGORY_GUIGE = 1;
    const CATEGORY_SELL = 13;
    const CATEGORY_BUY = 12;

    public $avatar = '';
    public $default_limit = 12;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category_id', 'description', 'avatar'], 'required'],
            [['category_id', 'status', 'updated_at', 'publicdate', 'viewed', 'ishot', 'created_at'], 'integer'],
            [['description'], 'string'],
            [['title', 'alias', 'meta_keywords', 'meta_description', 'meta_title', 'avatar_path', 'avatar_name', 'author', 'source'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 500],
            [['link_video','address','discount_code'], 'string', 'max' => 255],
            [['avatar','type','real_time', 'start_date','end_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Ti??u ?????',
            'alias' => 'Alias',
            'category_id' => 'Danh m???c',
            'short_description' => 'M?? t??? ng???n',
            'description' => 'Chi ti???t b??i tin',
            'status' => 'Tr???ng th??i',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'meta_title' => 'Meta Title',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'author' => 'T??c gi???',
            'updated_at' => 'Updated At',
            'publicdate' => 'Publicdate',
            'viewed' => 'Viewed',
            'source' => 'Ngu???n b??i tin',
            'ishot' => 'Tin n???i b???t',
            'created_at' => 'Created At',
            'type' => 'Lo???i tin',
            'link_video' => 'Link video youtube embed',
            'real_time' => 'Th???i gian di???n ra',
            'address' => '?????a ch??? nh???n h??ng',
            'discount_code' => 'M?? gi???m gi??',
            'user_id' => 'Th??ng tin ng?????i ????ng k??',
            'start_date' => 'Th???i gian b???t ?????u',
            'end_date' => 'Th???i gian k???t th??c',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = $this->updated_at = time();
            } else {
                $this->updated_at = time();
            }
            $this->alias = \common\components\HtmlFormat::parseToAlias($this->title);
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param array $options
     * @return int|array
     */
    public static function getType (){
        return [
          0 => 'Tin th?????ng',
          1 => 'Tin b??n h??ng',
          2 => 'Tin s??? ki???n',
          3 => 'Tin tuy???n d???ng nh??n s???'
        ];
    }

    /**
     *
     * @param array $options
     * @return int|array
     */
    public static function getNews($options = [])
    {
        $condition = 'status=:status';
        $params = [
            ':status' => ClaLid::STATUS_ACTIVED
        ];
        //
        if (isset($options['ishot']) && $options['ishot']) {
            $condition .= ' AND ishot=:ishot';
            $params[':ishot'] = $options['ishot'];
        }
        if (isset($options['_id']) && $options['_id']) {
            $condition .= ' AND id <> :id';
            $params[':id'] = $options['_id'];
        }
        //
        if (isset($options['category_id']) && $options['category_id']) {
            if (is_array($options['category_id'])) {
                $condition .= " AND category_id IN ('" . implode(" ',' ", $options['category_id']) . "')";
            } else {
                $condition .= ' AND category_id=:category_id';
                $params[':category_id'] = $options['category_id'];
            }
        }
        $order = 'publicdate DESC';
        if (isset($options['relation']) && $options['relation'] && isset($options['_id']) && $options['_id']) {
            $order = 'ABS(id - ' . $options['_id'] . ')';
        }
        //
        $limit = ClaLid::DEFAULT_LIMIT;
        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        if (!isset($options['page'])) {
            $options['page'] = 1;
        }
        $offset = ($options['page'] - 1) * $limit;
        //



        if (isset($options['count']) && $options['count']) {
            return News::find()
                ->where($condition, $params)
                ->count();
        }
        return News::find()
            ->where($condition, $params)
            ->orderBy($order)
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();
    }

    public static function getNewByAttr($options = [], $countOnly = false)
    {
        $where = "status = 1";
        if (isset($options['attr']) && $options['attr']) {
            foreach ($options['attr'] as $key => $value) {
                $where .= " AND $key = '$value' ";
            }
        }
        if (isset($options['_new']) && $options['_new']) {
            $where .= " AND id <> " . $options['_new'];
        }

        $order = News::DEFAULT_ORDER;
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }

        $limit = ClaLid::DEFAULT_LIMIT;
        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        //
        $news = (new Query())->select('*')
            ->from('news')
            ->where($where)
            ->orderBy($order)
            ->limit($limit)
            ->all();
        return $news;
    }

    public static function countAllNews()
    {
        $condition = 'status=:status';
        $params = [
            ':status' => ClaLid::STATUS_ACTIVED,
        ];
        return News::find()
            ->where($condition, $params)
            ->count();
    }

    static function getDataSearch($option)
    {
        if ($option['tag']) {
            $tag = $option['tag'];
            $tag_set = \common\models\product\Product::changeKey($option['tag']);
        } else {
            $tag = null;
            $tag_set = null;
        }
        if (isset($option['limit'])) {
            $limit = $option['limit'];
        } else {
            $limit = \common\models\Search::LIMIT;
        }
        if (isset($option['page'])) {
            $page = $option['page'];
        } else {
            $page = 1;
        }
        $data = (new \yii\db\Query())
            ->from('news')
            ->select('id, alias, title, meta_keywords, short_description as content, avatar_name, avatar_path')
            ->where(['like', 'alias', $tag_set])
            ->orWhere(['like', 'meta_keywords', $tag])
            ->orderBy('id DESC')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->all();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['type'] = \common\models\Search::getTypeName(\common\models\Search::TYPE_NEW);
            $data[$i]['link'] = \yii\helpers\Url::to(['/news/news/detail', 'id' => $data[$i]['id'], 'alias' => $data[$i]['alias']]);
        }
        $tg['data'] = $data;
        $count = (new \yii\db\Query())
            ->from('news')
            ->where(['like', 'alias', $tag_set])
            ->orWhere(['like', 'meta_keywords', $tag])
            ->count();
        $tg['pagination'] = new \yii\data\Pagination([
            'defaultPageSize' => $limit,
            'totalCount' => $count,
        ]);

        return $tg;
    }

    public function optionStatus()
    {
        return [
            0 => '???n b??i',
            1 => 'Hi???n th???',
            2 => 'Ch??? duy???t',
        ];
    }

    public function showStatus($status = null)
    {
        $status = ($status !== null) ? $status : $this->status;
        $arr = $this->optionStatus();
        return (isset($arr[$status])) ? $arr[$status] : 'N/A';
    }
}
