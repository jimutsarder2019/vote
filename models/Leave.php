<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leave".
 *
 * @property int $id
 * @property int $user
 * @property int $type
 * @property int $duration
 * @property string $leave_date
 * @property int $status
 * @property string $reason
 * @property string $date
 */
class Leave extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'type', 'leave_date', 'reason', 'date'], 'required'],
            [['user', 'type', 'duration', 'status'], 'integer'],
            [['leave_date', 'reason'], 'string', 'max' => 500],
            [['date'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'type' => 'Type',
            'duration' => 'Duration',
            'leave_date' => 'Leave Date',
            'status' => 'Status',
            'reason' => 'Reason',
            'date' => 'Date',
        ];
    }
}
