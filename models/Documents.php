<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property int $type
 * @property int $employee
 * @property int $ref_number
 * @property string|null $issue_date
 * @property string|null $expiry_date
 * @property string|null $date
 */
class Documents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'employee', 'ref_number'], 'required'],
            [['type', 'employee', 'ref_number'], 'integer'],
            [['issue_date', 'expiry_date', 'date'], 'string', 'max' => 50],
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
            'employee' => 'Employee',
            'ref_number' => 'Ref Number',
            'issue_date' => 'Issue Date',
            'expiry_date' => 'Expiry Date',
            'date' => 'Date',
        ];
    }
}
