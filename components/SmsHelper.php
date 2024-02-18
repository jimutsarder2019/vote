<?php


namespace common\helpers;


use backend\models\SmsApi;
use backend\models\SmsTemplateList;
use backend\models\SmsTypeList;
use Yii;

class SmsHelper
{
    public static function sendMessage($message, $phone)
    {
        $api_end_point = 'https://portal.adnsms.com/api/v1/secure/send-sms';
        $api_key = 'KEY-t5anxt73vd8gxn2f07jbkghvmyf6qizw';
        $api_secret = 'aqDDnNkK0O5USOnK';

        $otp_end_point = $api_end_point;
        $otp_api_key = $api_key;
        $otp_api_secret = $api_secret;

        $phone = trim($phone, '+');
        $esms_endpoint = $otp_end_point;
        $api_key = $otp_api_key;
        $api_secret = $otp_api_secret;

        $post_fields = json_encode([
            'api_key' => $api_key,
            'api_secret' => $api_secret,
            'request_type' => 'OTP',
            'message_type' => 'TEXT',
            'mobile' => $phone,
            'message_body' => $message,
        ]);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $esms_endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_fields,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
        $result = curl_exec($curl);
        return $result;

        /*response:
         $otp_response = self::sendOTPMessage($otp_code, $customer_mobile);
        $otp_response_array = json_decode($otp_response, true);
        $otp_response_success_code = $otp_response_array['api_response_code'];*/
    }

    public static function get_sms_type_status($status)
    {
        if ($status) {
            return "Active";
        } else {
            return "Inactive";
        }
    }

    public static function get_sms_template_status($status)
    {
        if ($status) {
            return "Active";
        } else {
            return "Inactive";
        }
    }

    public static function get_sms_type_name($type_id)
    {
        $sms_type_model = SmsTypeList::findOne(['id' => $type_id]);
        if (!empty($sms_type_model)) {
            return $sms_type_model->name;
        } else {
            return '';
        }
    }

    public static function sms_type($sms_type)
    {
        if ($sms_type) {
            return "Masking";
        } else {
            return "Non-masking";
        }
    }

    public static function sms_api_status($status)
    {
        if ($status) {
            return "Active";
        } else {
            return "Inactive";
        }
    }

    public static function technician_message()
    {
        $sms_template_list = SmsTemplateList::find()->where(['sms_type_id'=>1])->one();
        if(!empty($sms_template_list)){
            return $sms_template_list->template_content;
        }else{
            return '';
        }
    }

    public static function client_message()
    {
        $sms_template_list = SmsTemplateList::find()->where(['sms_type_id'=>2])->one();
        if(!empty($sms_template_list)){
            return $sms_template_list->template_content;
        }else{
            return '';
        }
    }

    public static function complain_completed_message()
    {
        $sms_template_list = SmsTemplateList::find()->where(['sms_type_id'=>3])->one();
        if(!empty($sms_template_list)){
            return $sms_template_list->template_content;
        }else{
            return '';
        }
    }

    public static function registration_sms()
    {
        $sms_template_list = SmsTemplateList::find()->where(['sms_type_id'=>4])->one();
        if(!empty($sms_template_list)){
            return $sms_template_list->template_content;
        }else{
            return '';
        }
    }

    public static function bill_sms()
    {
        $sms_template_list = SmsTemplateList::find()->where(['sms_type_id'=>5])->one();
        if(!empty($sms_template_list)){
            return $sms_template_list->template_content;
        }else{
            return '';
        }
    }

}