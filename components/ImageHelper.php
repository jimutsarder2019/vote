<?php

namespace app\components;
use Yii;
use yii\helpers\Url;

class ImageHelper
{
    public static function ImageType($image){
        if($image->type == 'image/gif' || $image->type == 'image/png' || $image->type == 'image/jpeg' || $image->type == 'image/JPEG' || $image->type == 'image/PNG' || $image->type == 'image/GIF' ){
                return true;
        }else{
            return false;
        }
    }


}