<?php
namespace app\components;

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
}