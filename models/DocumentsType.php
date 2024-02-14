<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documents_type".
 *
 * @property int $id
 * @property string $type
 * @property int $status
 * @property string|null $date
 */
class DocumentsType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['status'], 'integer'],
            [['type'], 'string', 'max' => 100],
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
            'type' => 'Type',
            'status' => 'Status',
            'date' => 'Date',
        ];
    }
}
