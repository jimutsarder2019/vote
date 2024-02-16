<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "voter".
 *
 * @property int $id
 * @property string $company
 * @property string $name
 * @property string $ispab_member
 * @property string $voter_no
 * @property string $mobile1
 * @property string|null $mobile2
 * @property string $email
 * @property string $thana
 * @property string $district
 * @property string $address
 * @property string $license
 * @property string $date
 */
class Voter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'voter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company', 'name', 'ispab_member', 'voter_no', 'mobile1', 'email', 'thana', 'district', 'address', 'license', 'date'], 'required'],
            [['company', 'name', 'address', 'license'], 'string', 'max' => 100],
            [['ispab_member', 'voter_no', 'mobile1', 'mobile2', 'email', 'thana', 'district'], 'string', 'max' => 50],
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
            'company' => 'Company',
            'name' => 'Name',
            'ispab_member' => 'Ispab Member',
            'voter_no' => 'Voter No',
            'mobile1' => 'Mobile1',
            'mobile2' => 'Mobile2',
            'email' => 'Email',
            'thana' => 'Thana',
            'district' => 'District',
            'address' => 'Address',
            'license' => 'License',
            'date' => 'Date',
        ];
    }
}
