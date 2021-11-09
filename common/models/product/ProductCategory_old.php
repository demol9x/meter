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
class ProductCategory extends \yii\db\ActiveRecord {

    const ROOT_CATEGORY = 0;
    const NORMAL = 0;
    const SHOW_CAT_CHILD = 1;
    const SHOW_CAT_CHILD_AND_ITEM = 2;

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
    public static function tableName() {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['parent', 'level', 'created_at', 'updated_at', 'status', 'attribute_set_id', 'order', 'point_percent'], 'integer'],
            [['name', 'alias', 'track', 'meta_keywords', 'meta_description', 'meta_title', 'avatar_path', 'avatar_name'], 'string', 'max' => 255],
            [['avatar', 'avatar2', 'avatar3', 'isnew', 'show_in_home'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
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
            'isnew' => Yii::t('app', 'fresh'),
            'order' => Yii::t('app', 'order'),
            'description' => Yii::t('app', 'description'),
            'show_in_home' => Yii::t('app', 'show_in_home'),
            'point_percent' => Yii::t('app', 'point_percent'),
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = $this->updated_at = time();
            } else {
                $this->updated_at = time();
            }
            $this->alias = \common\components\HtmlFormat::parseToAlias($this->name);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public static function aryViewLayout() {
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
    public function optionsCategory($parent = 0, $level = 0, $without_self = false) {
        $data = ProductCategory::find()->where(['parent' => $parent])->all();
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

    public function getDataProvider($parent = 0, $level = 0) {
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

    public static function getCodeAppName($code) {
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

    public static function getHtmlAttributes($attributes) {
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

    public static function getItemChild($parent, $attr = []) {
        return ProductCategory::find()->where(array_merge(['parent' => $parent],$attr))->orderBy('order ASC')->all();
    }

    public static function getItemChildLimit($parent, $limit) {
        return ProductCategory::find()->where(['parent' => $parent])->orderBy('order ASC')->limit($limit)->all();
    }

    public static function getItemChildAll($parent, $attr = []) {
        $data = ProductCategory::getItemChild($parent, $attr);
        if($data) for ($i=0; $i <count($data) ; $i++) { 
            $data[$i]['items'] = ProductCategory::getItemChildAll($data[$i]['id'], $attr);
        }
        return $data;
    }

    public static function getItemInShop($shop_id) {
        return  (new Query())->select('*')
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
    public function getBackGruond() {
        $category = ProductCategory::findOne($this->parent);
        if($category) { 
            if($category->bgr_name) {
                return $category;
            }
            return $category->getBackGruond();
        }
        return null;
    }

    public static function getParentMost($id) {
        $cat = self::findOne($id);
        if($cat) {
            if($cat->parent < 1) {
                return $cat->id;
            } else {
                return self::getParentMost($cat->parent);
            }            
        }
        return 0;
    }
}
