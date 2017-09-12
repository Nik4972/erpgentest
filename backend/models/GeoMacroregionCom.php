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
 * @property GeoMacroregionCom $group
 * @property GeoMacroregionCom[] $GeoMacroregionComs
 */
class GeoMacroregionCom extends \yii\db\ActiveRecord
{
    use ErpGroupModel;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_macroregion_com';
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
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeoMacroregionCom::className(), 'targetAttribute' => ['group_id' => 'id']],
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
        return $this->hasOne(GeoMacroregionCom::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoMacroregionComs()
    {
        return $this->hasMany(GeoMacroregionCom::className(), ['group_id' => 'id']);
    }

}
