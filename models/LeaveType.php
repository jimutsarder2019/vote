<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leave_type".
 *
 * @property int $id
 * @property string $name
 * @property int $no_of_leave
 * @property int $status
 */
class LeaveType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'no_of_leave'], 'required'],
            [['id', 'no_of_leave', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
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
            'no_of_leave' => 'No Of Leave',
            'status' => 'Status',
        ];
    }
}
