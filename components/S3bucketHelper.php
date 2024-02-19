<?php

//hotel
namespace app\components;


use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Yii;

class S3bucketHelper
{
    public static function get_storage_image_url($folder_name, $image_name)
    {
        if (!empty($folder_name) && !empty($image_name)) {
            $image_link = 'https://travels-bucket.s3.us-west-2.amazonaws.com/' . $folder_name . '/' . $image_name;
            return $image_link;
        }
        return '';
    }

    public static function upload_aws_s3_bucket($folder_name, $image_instance)
    {
        $current_date = new \DateTime();
        $bucketName = 'travels-bucket';
        $IAM_KEY = 'AKIAIEIE6BO6ILNJUFKA';
        $IAM_SECRET = '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';

        $keyName = $folder_name . '/' . $current_date->getTimestamp() . '.' . $image_instance->extension;
        try {
            $s3 = S3Client::factory(
                array(
                    'credentials' => array(
                        'key' => $IAM_KEY,
                        'secret' => $IAM_SECRET
                    ),
                    'version' => 'latest',
                    'region' => 'us-west-2'
                )
            );
            $result = $s3->putObject(
                array(
                    'Bucket' => $bucketName,
                    'Key' => $keyName,
                    'SourceFile' => $image_instance->tempName,
                    //'StorageClass' => 'REDUCED_REDUNDANCY',
                    'StorageClass' => 'STANDARD',
                    'ACL' => 'public-read'
                )
            );

            $data = $result->toArray();
            //ApplicationHelper::_setTrace($data['@metadata']['statusCode']);
            if (isset($data['@metadata']['statusCode']) && $data['@metadata']['statusCode'] == 200) {
                return $result['ObjectURL'];
            }

        } catch (S3Exception $e) {
            //echo "There was an error uploading the file.\n";
        }
        return '';
    }

    public static function driver_registration_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['driverImages'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }

    public static function vehicle_registration_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['vehicleImages'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }

    public static function customer_registration_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['customerRegistration'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }

    public static function slider_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['sliderImages'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }

    public static function bd_tour_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['bdTourImages'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }
    
    public static function blog_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['blogContentImages'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }
	
	public static function bd_hotel_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['bdHotelImages'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }
	
	public static function bd_room_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['bdRoomImages'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }

    public static function domestic_airlines_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['domesticAirlines'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }

    public static function international_airlines_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['internationalFlights'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }

    public static function hotel_service_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['hotelService'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }

    public static function car_rental_service($s3_image_object_url)
    {
        $find_string = Yii::$app->params['carRentalService'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';

    }

    public static function homepage_popup_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['homepagePopup'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }


    public static function agent_ad_image($s3_image_object_url)
    {
        $find_string = Yii::$app->params['agentAdImage'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }
    
    
    public static function testimonial_image($s3_image_object_url)
    {
        $find_string = Yii::$app->params['testimonialImage'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }
    
    public static function intl_tour_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['intlTourImages'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }

    public static function special_promotion_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['specialPromotionImages'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }

    public static function room_images($s3_image_object_url)
    {
        $find_string = Yii::$app->params['roomImages'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }
    
    public static function mobile_ad_image($s3_image_object_url)
    {
        $find_string = Yii::$app->params['mobileAdImage'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }

    public static function invoice_photo($s3_file_object)
    {
        $find_string = Yii::$app->params['invoiceFiles'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_file_object, $match_string) !== false) {
            $results = explode($match_string, $s3_file_object);
            return $results[1];
        }
        return '';

    }
    
    public static function client_registration($s3_image_object_url)
    {
        $find_string = Yii::$app->params['clientRegistration'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }
    
    
    public static function document_file($s3_image_object_url)
    {
        $find_string = Yii::$app->params['documentDirectory'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_image_object_url, $match_string) !== false) {
            $results = explode($match_string, $s3_image_object_url);
            return $results[1];
        }
        return '';
    }
    
    public static function employee_file($s3_file_object)
    {
        $find_string = Yii::$app->params['employeeFiles'];
        $match_string = '/' . $find_string . '/';
        if (strpos($s3_file_object, $match_string) !== false) {
            $results = explode($match_string, $s3_file_object);
            return $results[1];
        }
        return '';

    }
    
    
    public static function deleteObject($image_path,$key){

        $bucketName = Yii::$app->params['s3BucketName'];
        $IAM_KEY = Yii::$app->params['IAM_KEY'];
        $IAM_SECRET = Yii::$app->params['IAM_SECRET'];
        
        $a2S3 = S3Client::factory(
                array(
                    'credentials' => array(
                        'key' => $IAM_KEY,
                        'secret' => $IAM_SECRET
                    ),
                    'version' => 'latest',
                    'region' => 'us-west-2'
                )
            );
        $a2S3->deleteObject(array(
            'Bucket' => $bucketName,
            'Key'    => $image_path.'/'.$key,
        ));

        return true;
        //return (self::objectExist($image_path.'/'.$key)) ? false : true;
    }

}