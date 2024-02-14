<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $designation
 * @property int $department
 * @property string $gender
 * @property string $joining_date
 * @property string $exit_date
 * @property string $skill
 * @property string $address
 * @property string $mobile
 * @property int $salary
 * @property int $is_login
 * @property int $email_notify
 * @property string $image
 * @property int $status
 * @property string $date
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'designation', 'department', 'gender', 'joining_date', 'exit_date', 'skill', 'address', 'mobile', 'salary', 'image', 'date'], 'required'],
            [['designation', 'department', 'salary', 'is_login', 'email_notify', 'status'], 'integer'],
            [['name', 'email', 'address'], 'string', 'max' => 100],
            [['password', 'image'], 'string', 'max' => 50],
            [['gender', 'joining_date', 'exit_date', 'mobile', 'date'], 'string', 'max' => 20],
            [['skill'], 'string', 'max' => 200],
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
            'email' => 'Email',
            'password' => 'Password',
            'designation' => 'Designation',
            'department' => 'Department',
            'gender' => 'Gender',
            'joining_date' => 'Joining Date',
            'exit_date' => 'Exit Date',
            'skill' => 'Skill',
            'address' => 'Address',
            'mobile' => 'Mobile',
            'salary' => 'Salary',
            'is_login' => 'Is Login',
            'email_notify' => 'Email Notify',
            'image' => 'Image',
            'status' => 'Status',
            'date' => 'Date',
        ];
    }
}
