<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visitor".
 *
 * @property int $id
 * @property string $ip
 * @property string $lat
 * @property string $lng
 * @property string $date
 * @property string $time
 */
class Visitor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visitor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip', 'lat', 'lng', 'date', 'time'], 'required'],
            [['ip', 'lat', 'lng'], 'string', 'max' => 50],
            [['date', 'time'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'SL',
            'ip' => 'Ip Address',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'date' => 'Date',
            'time' => 'Time',
        ];
    }
}
