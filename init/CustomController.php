<?php

namespace app\init; 
use Yii; use yii\web\Controller; 
use yii\web\NotFoundHttpException; 

class CustomController extends Controller {

   public function init(){
      parent::init();
   }
   
   public static function getLicenseData()
   {
       return [
	        "registration_name"=> "Cloud Hub",
	        "license_number"=> 20231112,
			"license_nic"=> "",
			"license_expire"=> "2023-12-31",//hint: 2023-12-06
			"upgradable_till"=> "2023-12-31",
			"maximum_number_of_account"=> "unlimited",
			"maximum_number_of_router"=> "unlimited",
			"maximum_number_of_user_allow"=> 1000,
			"maximum_number_of_user_allow_alert_perchantage"=> 80
	   ];
   }	   
}
?>