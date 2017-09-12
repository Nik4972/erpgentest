<?php

namespace backend\models;

use Yii;
use backend\ErpGroupModel;

/**
 * This is the model class for table "geo_macroregion_geo".
 *
 * @property string $id
 * @property string $title
 * @property integer $status
 * @property string $group_id
 * @property integer $is_group
 *
 * @property GeoMacroregionGeo $group
 * @property GeoMacroregionGeo[] $GeoMacroregionGeos
 */
class GeoMacroregionGeo extends \yii\db\ActiveRecord
{
    use ErpGroupModel;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_macroregion_geo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'group_id', 'is_group'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'required'],
            [['title'], 'unique'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeoMacroregionGeo::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
            'group_id' => 'Group ID',
            'is_group' => 'Is Group',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(GeoMacroregionGeo::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoMacroregionGeos()
    {
        return $this->hasMany(GeoMacroregionGeo::className(), ['group_id' => 'id']);
    }

}
