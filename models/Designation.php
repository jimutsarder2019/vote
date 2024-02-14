<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "designation".
 *
 * @property int $id
 * @property string $name
 * @property int|null $employe_count
 * @property int $status
 * @property string|null $date
 */
class Designation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'designation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['employe_count', 'status'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['date'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'employe_count' => 'Employe Count',
            'status' => 'Status',
            'date' => 'Date',
        ];
    }
}
