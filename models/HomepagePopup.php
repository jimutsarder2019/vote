<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_homepage_popup".
 *
 * @property int $id
 * @property string $image_url
 * @property string $image_link
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $expire_date
 */
class HomepagePopup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_homepage_popup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'required'],
            ['image_url','required','on'=>'create'],
            [['image_url', 'image_link'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at', 'expire_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_url' => 'Image Url',
            'image_link' => 'Image Link',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'expire_date' => 'Expire Date',
        ];
    }
}
