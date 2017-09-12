<?php

namespace backend\models;

use Yii;
use backend\ErpGroupModel;

/**
 * This is the model class for table "geo_country".
 *
 * @property string $id
 * @property string $title
 * @property string $name
 * @property string $iso3
 * @property string $iso2
 * @property string $zip_name
 * @property string $geo_macroregion_geo_id
 * @property string $geo_macroregion_com_id
 * @property integer $status
 * @property string $group_id
 * @property integer $is_group
 *
 * @property Company[] $companies
 * @property ContractorAddress[] $contractorAddresses
 * @property Currency[] $currencies
 * @property GeoCity[] $geoCities
 * @property GeoMacroregionGeo $geoMacroregionGeo
 * @property GeoMacroregionCom $geoMacroregionCom
 * @property GeoCountry $group
 * @property GeoCountry[] $geoCountries
 * @property GeoRegion[] $geoRegions
 * @property GeoStreet[] $geoStreets
 * @property GeoStreetType[] $geoStreetTypes
 */
class GeoCountry extends \yii\db\ActiveRecord
{
    use ErpGroupModel;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['geo_macroregion_geo_id', 'geo_macroregion_com_id'], 'required'],
            [['geo_macroregion_geo_id', 'geo_macroregion_com_id', 'status', 'group_id', 'is_group'], 'integer'],
            [['title', 'name', 'zip_name'], 'string', 'max' => 255],
            [['iso3'], 'string', 'max' => 3],
            [['iso2'], 'string', 'max' => 2],
            [['title', 'name', 'zip_name'], 'required'],
            [['title'], 'unique'],
            [['geo_macroregion_geo_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeoMacroregionGeo::className(), 'targetAttribute' => ['geo_macroregion_geo_id' => 'id']],
            [['geo_macroregion_com_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeoMacroregionCom::className(), 'targetAttribute' => ['geo_macroregion_com_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeoCountry::className(), 'targetAttribute' => ['group_id' => 'id']],
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
            'name' => 'Name',
            'iso3' => 'Iso3',
            'iso2' => 'Iso2',
            'zip_name' => 'Zip Name',
            'geo_macroregion_geo_id' => 'Macroregion Geo',
            'geo_macroregion_com_id' => 'Macroregion Com',
            'status' => 'Status',
            'group_id' => 'Group ID',
            'is_group' => 'Is Group',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['geo_country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContractorAddresses()
    {
        return $this->hasMany(ContractorAddress::className(), ['geo_country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencies()
    {
        return $this->hasMany(Currency::className(), ['geo_country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoCities()
    {
        return $this->hasMany(GeoCity::className(), ['geo_country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoMacroregionGeo()
    {
        return $this->hasOne(GeoMacroregionGeo::className(), ['id' => 'geo_macroregion_geo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoMacroregionCom()
    {
        return $this->hasOne(GeoMacroregionCom::className(), ['id' => 'geo_macroregion_com_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(GeoCountry::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoCountries()
    {
        return $this->hasMany(GeoCountry::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoRegions()
    {
        return $this->hasMany(GeoRegion::className(), ['geo_country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoStreets()
    {
        return $this->hasMany(GeoStreet::className(), ['geo_country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoStreetTypes()
    {
        return $this->hasMany(GeoStreetType::className(), ['geo_country_id' => 'id']);
    }
}
