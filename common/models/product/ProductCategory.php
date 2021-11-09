<?php

namespace common\models\product;

use Yii;
use yii\db\Query;
use common\models\product\Product;

/**
 * This is the model class for table "product_category".
 *
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $parent
 * @property integer $level
 * @property string $track
 * @property string $created_at
 * @property string $updated_at
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property integer $status
 * @property string $avatar_path
 * @property string $avatar_name
 * @property integer $attribute_set_id
 * @property integer $point_percent
 */
class ProductCategory extends \yii\db\ActiveRecord
{

    const ROOT_CATEGORY = 0;
    const NORMAL = 0;
    const SHOW_CAT_CHILD = 1;
    const SHOW_CAT_CHILD_AND_ITEM = 2;
    const KEY_PRODUCT_CATEGORY = 'memcached_product_category_gca';
    const KEY_PRODUCT_CATEGORY_PARENT = 'memcached_product_category_gca_parent';
    const CATEGORY_AFILATE = 499;
    const CATEGORY_SALE = 500;
    const CATEGORY_GROUP = 504;

    private $_cats = array('' => ' --- Chọn danh mục --- ');
    private $_dataProvider = array();
    public $avatar = '';
    public $avatar2 = '';
    public $avatar3 = '';
    public $items = [];
    public $active = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent', 'level', 'created_at', 'updated_at', 'status', 'attribute_set_id', 'order', 'point_percent'], 'integer'],
            [['name', 'alias', 'track', 'meta_keywords', 'meta_description', 'meta_title', 'avatar_path', 'avatar_name'], 'string', 'max' => 255],
            [['avatar', 'avatar2', 'avatar3', 'isnew', 'show_in_home', 'show_in_home_2', 'frontend_not_up'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'menu_name'),
            'alias' => Yii::t('app', 'alias'),
            'parent' => Yii::t('app', 'parent_category'),
            'level' => Yii::t('app', 'level'),
            'track' => Yii::t('app', 'track'),
            'created_at' => Yii::t('app', 'created_at'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'meta_keywords' => Yii::t('app', 'meta_keywords'),
            'meta_description' => Yii::t('app', 'meta_description'),
            'meta_title' => Yii::t('app', 'meta_title'),
            'status' => Yii::t('app', 'status'),
            'attribute_set_id' => Yii::t('app', 'attribute_set_id'),
            'avatar2' => Yii::t('app', 'icon_small'),
            'avatar3' => Yii::t('app', 'icon_background'),
            'isnew' => 'Danh mục hot',
            'order' => Yii::t('app', 'order'),
            'description' => Yii::t('app', 'description'),
            'show_in_home' => Yii::t('app', 'show_in_home'),
            'point_percent' => Yii::t('app', 'point_percent'),
            'show_in_home_2' => 'Hiện thị danh mục',
            'frontend_not_up' => 'Chỉ giành cho Admin'
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
            $this->alias = \common\components\HtmlFormat::parseToAlias($this->name);
            \Yii::$app->cache->delete(self::KEY_PRODUCT_CATEGORY);
            \Yii::$app->cache->delete(self::KEY_PRODUCT_CATEGORY_PARENT);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public static function aryViewLayout()
    {
        return array(
            self::NORMAL => 'Mặc định(Sản phẩm)',
            self::SHOW_CAT_CHILD => 'Hiển thị danh mục con',
            self::SHOW_CAT_CHILD_AND_ITEM => 'Hiển thị danh mục và sản phẩm'
        );
    }

    /**
     * return options category
     * @param type $parent
     * @param type $level
     * @return type
     */
    public function optionsCategory($parent = 0, $level = 0, $without_self = false)
    {
        if (\Yii::$app->id == 'app-backend') {
            $data = ProductCategory::find()->where(['parent' => $parent])->orderBy('order')->all();
        } else {
            $data = ProductCategory::find()->where(['parent' => $parent, 'frontend_not_up' => 0])->orderBy('order')->all();
        }
        $glue = str_repeat('- - - ', $level);
        if ($data) {
            $level++;
            foreach ($data as $category) {
                $this->_cats[$category->id] = $glue . $category->name;
                $this->optionsCategory($category->id, $level);
            }
        }
        if ($without_self && $this->id) {
            unset($this->_cats[$this->id]);
        }
        return $this->_cats;
    }

    public function getDataProvider($parent = 0, $level = 0)
    {
        $data = ProductCategory::find()->where(['parent' => $parent])->orderBy('order, id DESC')->all();
        $glue = str_repeat('- - - ', $level);
        if ($data) {
            $level++;
            foreach ($data as $category) {
                $category->name = $glue . $category->name;
                $this->_dataProvider[$category->id] = $category->attributes;
                $this->getDataProvider($category->id, $level);
            }
        }

        return $this->_dataProvider;
    }

    public static function getCodeAppName($code)
    {
        $code = explode(' ', $code);
        $html = '';
        if ($code) {
            foreach ($code as $co) {
                $co = trim($co);
                $option = ProductAttributeOption::find()
                    ->where('attribute_id=:attribute_id AND code_app=:code_app', [':attribute_id' => 22, 'code_app' => $co])
                    ->one();
                $html .= $option['code_app'] . ': <b>' . $option['value'] . '</b> <br />';
            }
        }
        return $html;
    }

    public static function getHtmlAttributes($attributes)
    {
        $html = '';
        if ($attributes) {
            foreach ($attributes as $attribute) {
                if (isset($attribute['index_key']) && $attribute['index_key']) {
                    $option = ProductAttributeOption::find()
                        ->select('value')
                        ->where('attribute_id=:attribute_id AND index_key IN (' . implode(',', $attribute['index_key']) . ')', [':attribute_id' => $attribute['id']])
                        ->column();
                    $html .= $attribute['name'] . ': <b>' . ((isset($option) && $option) ? implode(', ', $option) : '') . '</b><br />';
                }
            }
        }
        return $html;
    }

    public static function getAllCached()
    {
        $cache = Yii::$app->cache;
        $cates = $cache->get(self::KEY_PRODUCT_CATEGORY);
        if ($cates === false) {
            $cates = self::find()->where(['status' => 1])->orderBy('order, id DESC')->all();
            $cache->set(self::KEY_PRODUCT_CATEGORY, $cates);
        }
        return $cates;
    }

    public static function getByParent()
    {
        //        $key = self::KEY_PRODUCT_CATEGORY_PARENT;
        //        $cache = Yii::$app->cache;
        //
        //        $return = $cache->get($key);
        //        if ($return === false) {
        $cates = self::getAllCached();
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if ($cates) foreach ($cates as $item) {
            if ($item['id'] == $id) {
                $item['active'] = 1;
            }
            $return[$item['parent']][] = $item;
        }
        //            $cache->set($key, $return);
        //        }
        return $return;
    }

    public static function getItemChild($parent, $attr = [])
    {
        $return = self::getByParent();
        return isset($return[$parent]) ? $return[$parent] : [];
    }

    public static function getItemChildLimit($parent, $limit)
    {
        $tgs = (new self)->getAllCached();
        $data = [];
        $dem = 0;
        if ($tgs) foreach ($tgs as $item) {
            if ($item->parent == $parent  && $item->status == 1) {
                $data[] = $item;
                $dem++;
            }
            if ($dem >= $limit) {
                return $data;
            }
        }
        return $data;
        // return ProductCategory::find()->where(['parent' => $parent])->orderBy('order ASC')->limit($limit)->all();
    }

    public static function getItemChildAll($parent, $attr = [])
    {
        $data = ProductCategory::getItemChild($parent, $attr);
        if ($data) for ($i = 0; $i < count($data); $i++) {
            $data[$i]['items'] = ProductCategory::getItemChildAll($data[$i]['id'], $attr);
        }
        return $data;
    }

    public static function getItemInShop($shop_id)
    {
        return (new Query())->select('*')
            ->from('product_category')
            ->where(['id' => Product::getItiemInShop($shop_id)])
            ->all();
    }

    // public static function getIdChild($parent, $attr = []) {
    //     $ids=[];
    //     $data = ProductCategory::find()->select('id')->where(array_merge(['parent' => $parent],$attr))->orderBy('order ASC')->all();
    //     if($data) foreach ($data as $id) {
    //        $ids[] = $id['id'];
    //     }
    //     return $ids;
    // }

    // public static function getIdChildAll($parent, $attr = []) {
    //     if($parent) {
    //          $data = ProductCategory::getIdChild($parent, $attr);
    //         if($data) for ($i=0; $i <count($data) ; $i++) { 
    //             $tg = ProductCategory::getIdChild($data[$i], $attr);
    //             $data = array_merge($tg, $data);
    //         }
    //         $data[] = $parent;
    //         return $data;
    //     }
    //     return null;
    // }
    public function getBackGruond()
    {
        $category = ProductCategory::findOne($this->parent);
        if ($category) {
            if ($category->bgr_name) {
                return $category;
            }
            return $category->getBackGruond();
        }
        return null;
    }

    public static function getParentMost($id)
    {
        $cat = self::findOne($id);
        if ($cat) {
            if ($cat->parent < 1) {
                return $cat->id;
            } else {
                return self::getParentMost($cat->parent);
            }
        }
        return 0;
    }

    function allowGroup($user_id)
    {
        if (!$this->inGroup()) {
            return true;
        }
        if ($user_id) {
            if (in_array($this->id, \common\models\user\UserInGroup::getListCatAllow($user_id))) {
                return true;
            }
        }
        return false;
    }

    function inGroup()
    {
        if ($this->parent == self::CATEGORY_GROUP) {
            return true;
        }
        return false;
    }

    function isAllGroup()
    {
        return $this->id == self::CATEGORY_GROUP;
    }

    function getShowHome()
    {
        $tgs = (new self)->getAllCached();
        $data = [];
        if ($tgs) foreach ($tgs as $item) {
            if ($item->show_in_home == 1 && $item->status == 1) {
                $data[] = $item;
            }
        }
        return $data;
        // return self::find()->where(['show_in_home' => 1])->orderBy('order ASC')->all();
    }

    function getShowHome2()
    {
        $tgs = (new self)->getAllCached();
        $data = [];
        if ($tgs) foreach ($tgs as $item) {
            if ($item->show_in_home_2 == 1 && $item->status == 1) {
                $data[] = $item;
            }
        }
        return $data;
        // return self::find()->where(['show_in_home_2' => 1])->orderBy('order ASC')->all();
    }
}
