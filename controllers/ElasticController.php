<?php
//TODO:: CODE OPTIMIZE
namespace app\controllers;

ini_set('max_execution_time', '300');

require_once __DIR__ . '/../api/vendor/autoload.php';

use Yii;
use yii\web\Controller;
use yii\elasticsearch\Query;
use app\components\ApplicationHelper;
use app\init\CustomController;

class ElasticController extends Controller
{	

	public function beforeAction($action) 
	{ 
		$this->enableCsrfValidation = false; 
		return parent::beforeAction($action); 
	}
	
	
	public function actionGet()
    {
		$from_date = Yii::$app->request->post('from_date');
		$to_date = Yii::$app->request->post('to_date');
		
		$from_hours = Yii::$app->request->post('from_hours');
		$from_mins = Yii::$app->request->post('from_mins');
		$to_hours = Yii::$app->request->post('to_hours');
		$to_mins = Yii::$app->request->post('to_mins');
		
		$user = Yii::$app->request->post('user');
		$mac = Yii::$app->request->post('mac');
		$src_ip = Yii::$app->request->post('src_ip');
		$dst_ip = Yii::$app->request->post('dst_ip');
		$nat_ip = Yii::$app->request->post('nat_ip');
		
		$src_port = Yii::$app->request->post('src_port');
		$dst_port = Yii::$app->request->post('dst_port');
		$nat_port = Yii::$app->request->post('nat_port');
		
		$limit = Yii::$app->request->post('limit', 50);
		$date_limit = Yii::$app->request->post('limit_date');
		$search = Yii::$app->request->post('search');
		$router = Yii::$app->request->post('router');
		$offset = Yii::$app->request->post('offset', 0);
		$page_name = Yii::$app->request->post('page_name', 'log');
		$report_type = Yii::$app->request->post('report_type', '');

		$message_filter = [];
		$mac_filter = [];
		$user_filter = [];
		$src_filter = [];
		$dst_filter = [];
		$nat_filter = [];
		
		$src_port_filter = [];
		$dst_port_filter = [];
		$nat_port_filter = [];
		
		$router_filter = [];
		
		if($mac){
			$mac_filter[] = self::filter_match_phrase_prefix($mac);
		}
		if($user){
			$user_filter[] = self::filter_match_phrase_prefix($user);
		}
		if($src_ip){
			$src_filter[] = self::filter_match_phrase_prefix($src_ip);
		}
		if($dst_ip){
			$dst_filter[] = self::filter_match_phrase_prefix($dst_ip);
		}
		if($nat_ip){
			$nat_filter[] = self::filter_match_phrase_prefix($nat_ip);
		}
		
		if($src_port){
			$src_port = (string) $src_port;
			$src_port = ":".$src_port.'->';
			$src_port_filter[] = self::filter_match_phrase_prefix($src_port);
		}
		if($dst_port){
			$dst_port = ":".$dst_port.",";
			$dst_port_filter[] = self::filter_match_phrase_prefix($dst_port);
		}
		if($nat_port){
			$nat_port = ":".$nat_port."->";
			$nat_port_filter[] = self::filter_match_phrase_prefix($nat_port);
		}
		
		$message_filter = array_merge($mac_filter, $user_filter, $src_filter, $dst_filter, $nat_filter, $src_port_filter, $dst_port_filter, $nat_port_filter);	
		$message_filter_ppp = array_merge($mac_filter, $user_filter, $src_filter);	
		
		$router_filter = [];
		$router_list = ApplicationHelper::getRouters();
		$data_count = 0;
		if(!empty($router_list)){
			
			foreach($router_list  as $router_ip){
				if($router == 'all'){
					$router_filter[] = [
						"match"=> [
							"HOST"=> '.*'.$router_ip.'.*'
						]
					];
				}else{
					if($router == $router_ip){
						$router_filter[] = [
							  "match"=> [
								"HOST"=> '.*'.$router_ip.'.*'
							  ]
						];
					}
				}
			}
			
			if($from_date && $to_date && $from_hours && $from_mins && $to_hours && $to_mins && !empty($message_filter)){
				
				$date_filter[] = [
					"range"=>[
						"@timestamp"=>[
						                "time_zone"=> "+06:00", 
										"gte"=>"".$from_date."T".$from_hours.":".$from_mins.":00",
										"lte"=>"".$to_date."T".$to_hours.":".$to_mins.":59",
						]
					]
				];
				$date_filter_ppp[] = [
						"range"=>[
									"@timestamp"=>[
									    "time_zone"=> "+06:00", 
										//"gte"=>"".$from_date."T00:00:00",
										"lte"=>"".$to_date."T23:59:59",
									]
						]
				];
				
				$message_filter_ppp = array_merge($message_filter_ppp, $date_filter_ppp);
				$message_filter = array_merge($message_filter, $date_filter);
				
				if(count($router_filter) > 1){
					$match  =	 [
						"bool"=> [
						  "should"=> $router_filter,
						  "must"=> $message_filter
						]
					];
				}else{
					$match  =	 [
						"bool"=> [
						  "must"=> array_merge($router_filter,$message_filter)	
						]
					];
				}
			}else if($from_date && $to_date && $from_hours && $from_mins && $to_hours && $to_mins){
				
				$date_filter[] = [
					"range"=>[
						"@timestamp"=>[
						                "time_zone"=> "+06:00", 
										"gte"=>"".$from_date."T".$from_hours.":".$from_mins.":00",
										"lte"=>"".$to_date."T".$to_hours.":".$to_mins.":59",
						]
					]
				];
				$date_filter_ppp[] = [
						"range"=>[
									"@timestamp"=>[
									    "time_zone"=> "+06:00", 
										//"gte"=>"".$from_date."T00:00:00",
										"lte"=>"".$to_date."T23:59:59",
									]
						]
				];
				
				$message_filter_ppp = $date_filter_ppp;
				
				if(count($router_filter) > 1){
					$match  =	 [
						"bool"=> [
						  "should"=> $router_filter,
						  "must"=> $date_filter
						]
					];
				}else{
					$match  =	 [
						"bool"=> [
						  "must"=> array_merge($router_filter,$date_filter)	
						]
					];
				}
			}else if($date_limit){		
				$match = [
							"range"=>[
								 "@timestamp"=>[
									"gte"=>$date_limit
								 ]
						]
				];
			}else if($search){
				  if(count($router_filter) > 1){
					  $match  =	 [
						"bool"=> [
						  "must"=> self::filter_match_phrase_prefix($search),
						  "should"=> $router_filter
						]
					  ];
				  }else{  
					$match_prefix[] = self::filter_match_phrase_prefix($search);
					$match  =	 [
						"bool"=> [
						  "must"=> array_merge($router_filter,$match_prefix)
						]
					  ];
				  }
			}else{
				if($page_name == 'log'){
				
					if($router && $router != 'all'){
						$date_filter[] = [
								"range"=>[
									"@timestamp"=>[
										   "time_zone"=> "+06:00",
										   "gte" => "now-24h",
										   "lt" =>  "now"
									]
								]
						];
						$match  =	 [
							"bool"=> [
							  "must"=> array_merge($router_filter,$date_filter)	
							]
						];
					}else{
						
						$date_filter[] = [
								"range"=>[
									"@timestamp"=>[
										   "time_zone"=> "+06:00",
										   "gte" => "now-24h",
										   "lt" =>  "now"
									]
								]
						];
						
						if(count($router_filter) > 1){
							$match  =	 [
								"bool"=> [
								  "must"=> $date_filter,
								  "should"=> $router_filter
								]
							];
						}else{
							$match  =	 [
								"bool"=> [
								  "must"=> array_merge($router_filter,$date_filter)	
								]
							];
						}
					}
				}else{
					$match  =	 [
						"bool"=> [
						  "should"=> $router_filter
						]
					];
				}
			}
			
			if($page_name == 'search'){
				$limit = 10000;
			}
			
			if($page_name == 'report'){
				$limit = 4000;
			}
			
			$report_match1 = json_encode($match);
			$report_match2 = '';
			$match_type = 'nat';

			$all_data = self::getQueryData($match, 'cloud-log-nat', $limit, $offset, $page_name);
			
			$all_message = [];
			$all_syslog_data = [];
			
            $data_count = 0;
			if(!empty($all_data)){
				$data_count = count($all_data);
				$all_syslog_data = self::dataProcess($all_data, true, $from_date, $to_date, $from_hours, $from_mins, $to_hours, $to_mins, $router_list, false, false, false, $_POST);	
			    //ApplicationHelper::_setTrace($all_syslog_data);
			}else{
				if($search){
					$_filter[] = [
					  "match_phrase_prefix"=> [
						"MESSAGE"=> '.* '.$search.'. *'
					  ]
					];
					
					$match  =	 [
						"bool"=> [
						  "must"=> $_filter			
						  ]
					];
				}else{
					$match  =	 [
						"bool"=> [
						  "must"=> $message_filter_ppp		
						  ]
					];
				}
				$match_type = 'ppp';
				$report_match1 = json_encode($match);
				
				//ApplicationHelper::_setTrace($match, 0);
				$all_data = self::getQueryData($match, 'cloud-log-ppp', 1, 0, $page_name);
				//print 'ppp data';
				//print '</br>';
				//ApplicationHelper::_setTrace($all_data, 0);
				if(!empty($all_data)){
					$missing_user_data = $all_data[0]['_source']['MESSAGE'];
					$main_src_ip = $all_data[0]['_source']['HOST'];
					$message_array = explode(" ",$missing_user_data);
					if(isset($message_array[0],  $message_array[1])){
						$user_name = $message_array[0];
						$mac_ip = $message_array[1];
						$src_ip_string = $message_array[2];
						
						if($user_name == 'PPPLOG'){
						   $user_name = $message_array[1];
						   $mac_ip = $message_array[2];
						   $src_ip_string = $message_array[3];
						}
						
						$src_ip_array = explode("?",$src_ip_string);
						$src_ip = @$src_ip_array[0];

						$src_filter_nat[] = self::filter_match_phrase_prefix($src_ip);
						if($dst_ip){
							$dst_filter[] = self::filter_match_phrase_prefix($dst_ip);
						}
						if($nat_ip){
							$nat_filter[] = self::filter_match_phrase_prefix($nat_ip);
						}
						
						if($src_port){
							$src_port_filter[] = self::filter_match_phrase_prefix($src_port);
						}
						if($dst_port){
							$dst_port_filter[] = self::filter_match_phrase_prefix($dst_port);
						}
						if($nat_port){
							$nat_port_filter[] = self::filter_match_phrase_prefix($nat_port);
						}
						
						$src_filter_nat = array_merge($src_filter_nat, $dst_filter, $nat_filter, $src_port_filter, $dst_port_filter, $nat_port_filter);
						$date_filter_nat = [];
						
						if($from_date && $to_date && $from_hours && $from_mins && $to_hours && $to_mins){
							$date_filter_nat[] = [
								"range"=>[
									"@timestamp"=>[
													"time_zone"=> "+06:00", 
													"gte"=>"".$from_date."T".$from_hours.":".$from_mins.":00",
													"lte"=>"".$to_date."T".$to_hours.":".$to_mins.":59",
									]
								]
							];
						}
						$filter = array_merge($src_filter_nat, $date_filter_nat);
						$match  =	 [
								"bool"=> [
								  "must"=> $filter
								]
						];
						$report_match2 = json_encode($match,1);
						//print '</br>';
						//print 'nat match';
						//print '</br>';
						//ApplicationHelper::_setTrace($match, 0);
						
						$all_data = self::getQueryData($match, 'cloud-log-nat', $limit, 0, $page_name);
						//ApplicationHelper::_setTrace($all_data, 0);
						//print 'final nat log process data';
						//print '</br>';
						if(!empty($all_data)){
							$data_count = count($all_data);
							
							$all_syslog_data = self::dataProcess($all_data, false, $from_date, $to_date, $from_hours, $from_mins, $to_hours, $to_mins, $router_list, $user_name, $mac_ip, $main_src_ip);
						//ApplicationHelper::_setTrace($all_syslog_data);
						
						}
					}
				}
			}
			
			$limit_date = '';
			if(!empty($all_syslog_data)){
				$limit_date = $all_syslog_data[count($all_syslog_data) - 1]['datetime'];
			}
			
			$report_status = false;
			$process = '';
			if($data_count > 3000 && ($page_name == 'report')){
				
				$report_generate_process = Yii::$app->db->createCommand( 'SELECT COUNT(*) FROM report_backup where status < 2' )->queryScalar();
				
				if($report_generate_process == 0){
					
					$all_data_count = self::getQueryCount($match, 'cloud-log-nat', $limit, $offset, $page_name);
					$params = ['from_date_to_date'=>$from_date.$from_hours.$from_mins.'_'.$to_date.$to_hours.$to_mins, 'from_date'=>$from_date."T".$from_hours.":".$from_mins.":00", 'to_date'=>$to_date."T".$to_hours.":".$to_mins.":59", 'report_type'=>$report_type, 'match1'=>$report_match1, 'match2'=>$report_match2, 'match_type'=>$match_type];
					ApplicationHelper::storeReportGenerateRecord($params, $all_data_count);
					$process = 'yes';
					$report_status = true;
				}else{
					$process = 'no';
				}
			}
			die(json_encode(['status'=>'success', 'process'=>$process, 'report_status'=>$report_status, 'count'=>$data_count, 'data'=>$all_syslog_data, 'limit_date'=>$limit_date]));
		}else{
			die(json_encode(['status'=>'fail', 'report_status'=>false, 'count'=>$data_count, 'data'=>[], 'limit_date'=>'']));
		}
    }
	

	
	private function getMissingUser($src_ip, $date_start = false, $date_end = false, $from_hours = false, $from_mins = false, $to_hours = false, $to_mins = false)
    {
		$page_name = 'log';
		$src_filter[] = self::filter_match_phrase_prefix($src_ip);
		$date_filter = [];
		if($date_start && $date_end){
			$date_filter[] = [
					"range"=>[
								"@timestamp"=>[												
												"time_zone"=> "+06:00", 
												//"gte"=>"".$date_start."T".$from_hours.":".$from_mins.":00",
												//"lte"=>"".$date_end."T".$to_hours.":".$to_mins.":59",
												"lte"=>"".$date_end."T23:59:59",
								]
					]
			];					
									
			$page_name = 'search';
		}
		
		$filter = array_merge($src_filter, $date_filter);
		$match  =	 [
					"bool"=> [
					  "must"=> $filter
					]
		];
			
		$all_data = self::getQueryData($match, 'cloud-log-ppp', 1, 0, $page_name);
		
		$all_syslog_data = [];
		if(!empty($all_data)){
			$missing_user_data = $all_data[0]['_source']['MESSAGE'];
			$src_ip = $all_data[0]['_source']['HOST'];
			$message_array = explode(" ",$missing_user_data);
			if(isset($message_array[1],  $message_array[2])){
				$user_name = $message_array[1];
				$mac_ip = $message_array[2];
				return ['user'=>$user_name, 'mac'=>$mac_ip, 'router_ip'=>$src_ip];
			}
		}
    }

	private function dataProcess($all_data, $missing_find=true, $date_start = false, $date_end = false, $from_hours = false, $from_mins = false, $to_hours = false, $to_mins = false, $router_list = [], $user_name = false, $mac_ip = false,  $main_src_ip = false, $params = [])
	{
		$all_syslog_data = [];
		foreach($all_data as $key=>$data){
			//$data['_source']['MESSAGE'] = 'prerouting: in:<pppoe-!sfc@shop.wifi> out:(unknown 0), proto TCP (ACK,FIN), [2001:df4:d480:f9dc:91ee:36dc:6720:fb4c]:54438->[2620:1ec:c11::239]:443, len 20';			
			$message_array = explode(", ",$data['_source']['MESSAGE']);
			$all_syslog_data[$key]['datetime_real'] = @$data['_source']['@timestamp'];
			$datetime2 = new \DateTime(@$data['_source']['@timestamp']);
			$all_syslog_data[$key]['datetime'] = $datetime2->format('d-m-Y H:i a');
			$all_syslog_data[$key]['host'] = @$data['_source']['HOST'];
			$all_syslog_data[$key]['user'] = 'N/A';
			$all_syslog_data[$key]['nat_ip'] = 'N/A';
			$all_syslog_data[$key]['nat_port'] = 'N/A';
			$all_syslog_data[$key]['mac'] = 'N/A';
			
			$all_syslog_data[$key]['destination_ip'] = 'N/A';
			$all_syslog_data[$key]['destination_port'] = 'N/A';
			$all_syslog_data[$key]['src_port'] = 'N/A';
			$all_syslog_data[$key]['src_ip'] = 'N/A';
			$all_syslog_data[$key]['status'] = true;
			
			foreach($message_array as $k=>$message){
				if(strpos($message, "Internet_Log:") !== false && strpos($message, "in:<pppoe-") !== false){
					$user_data = @explode("in:<pppoe-",$message);
					$last_user_data = @explode("out:", @$user_data[1]);
					if(!empty($last_user_data)){
						$user = str_replace('>','',@$last_user_data[0]);
						if($user != ''){
							$all_syslog_data[$key]['user'] = $user;
						}
					}
				}else if(strpos($message, "prerouting:") !== false && strpos($message, "in:<pppoe-") !== false){
					$user_data = @explode("in:<pppoe-",$message);
					$last_user_data = @explode("out:", @$user_data[1]);
					if(!empty($last_user_data)){
						$user = str_replace('>','',@$last_user_data[0]);
						if($user != ''){
							$all_syslog_data[$key]['user'] = $user;
						}
					}
				}else if(strpos($message, "PPPLOG") !== false){
					$user_data = @explode("PPPLOG",$message);
					$last_user_data = @explode(" ", @$user_data[1]);
					if(isset($last_user_data[0])){
						$user = $last_user_data[0];
						$all_syslog_data[$key]['user'] = $user;
					}
				}

				
				if(strpos($message, "src-mac") !== false){
					$mac1 = str_replace('src-mac ','',str_replace('connection-state:established','',$message));
					$mac1 = str_replace('connection-mark:speed','',$mac1);
					$mac1 = str_replace('connection-mark:cdn_ggc','',$mac1);
					$mac1 = str_replace('connection-mark:cdn_fna','',$mac1);
					$mac1 = str_replace('connection-state:new','',$mac1);
					$mac1 = str_replace(',snat','',$mac1);
					$all_syslog_data[$key]['mac'] = $mac1;
				}
				
				if(strpos($message, "proto") !== false){
					$all_syslog_data[$key]['protocol'] = @explode(" ", $message)[1];
					if($all_syslog_data[$key]['protocol'] == 'proto'){
						$all_syslog_data[$key]['protocol'] = @explode(" ", $message)[2];
					}
				}
				
				if($k === 3){
					
					if (str_contains($message, '->[')) {
						
						$ipv6_data = explode("->", @$message);
						$ipv6_data_1 = explode("]:", @$ipv6_data[0]);
						
						
						$src_ip = str_replace('[','',@$ipv6_data_1[0]);
						$src_ip = str_replace('NAT','',$src_ip);
						$src_ip = str_replace('(','',$src_ip);
						$all_syslog_data[$key]['src_ip'] = $src_ip;
						
						$src_port = str_replace('[','',@$ipv6_data_1[1]);
						$all_syslog_data[$key]['src_port'] = $src_port;
						
						$ipv6_data_2 = explode("]:", @$ipv6_data[1]);
						$dest_ip = str_replace('[','',@$ipv6_data_2[0]);
						$all_syslog_data[$key]['destination_ip'] = $dest_ip;
						
						$dest_port = str_replace('[','',@$ipv6_data_2[1]);
						$dest_port = str_replace(')','',$dest_port);
						$all_syslog_data[$key]['destination_port'] = $dest_port;
					}else{
						$ip_data = explode("->", $message);
						$all_syslog_data[$key]['src_ip'] = @explode(":", @$ip_data[0])[0];
						$all_syslog_data[$key]['src_ip'] = str_replace('NAT','',$all_syslog_data[$key]['src_ip']);
						$all_syslog_data[$key]['src_ip'] = str_replace('(','',$all_syslog_data[$key]['src_ip']);
						$all_syslog_data[$key]['src_port'] = @explode(":", @$ip_data[0])[1];
						$all_syslog_data[$key]['destination_ip'] = @explode(":", @$ip_data[1])[0];
						$all_syslog_data[$key]['destination_port'] = @explode(":", @$ip_data[1])[1];
						$all_syslog_data[$key]['destination_port'] = str_replace(')','',$all_syslog_data[$key]['destination_port']);
					}
					
					
					if(!$all_syslog_data[$key]['src_ip'] || !$all_syslog_data[$key]['destination_ip']){
						$src_dst_message = @$message_array[2];
						if (str_contains($src_dst_message, '->[')) {
						
							$ipv6_data = explode("->", @$src_dst_message);
							$ipv6_data_1 = explode("]:", @$ipv6_data[0]);

							$src_ip = str_replace('[','',@$ipv6_data_1[0]);
							$src_ip = str_replace('NAT','',$src_ip);
							$src_ip = str_replace('(','',$src_ip);
							$all_syslog_data[$key]['src_ip'] = $src_ip;
							
							$src_port = str_replace('[','',@$ipv6_data_1[1]);
							$all_syslog_data[$key]['src_port'] = $src_port;
							
							$ipv6_data_2 = explode("]:", @$ipv6_data[1]);
							$dest_ip = str_replace('[','',@$ipv6_data_2[0]);
							$all_syslog_data[$key]['destination_ip'] = $dest_ip;
							
							$dest_port = str_replace('[','',@$ipv6_data_2[1]);
							$dest_port = str_replace(')','',$dest_port);
							$all_syslog_data[$key]['destination_port'] = $dest_port;
						}else{
							$ip_data = explode("->", $src_dst_message);
							$all_syslog_data[$key]['src_ip'] = @explode(":", @$ip_data[0])[0];
							$all_syslog_data[$key]['src_ip'] = str_replace('NAT','',$all_syslog_data[$key]['src_ip']);
							$all_syslog_data[$key]['src_ip'] = str_replace('(','',$all_syslog_data[$key]['src_ip']);
							$all_syslog_data[$key]['src_port'] = @explode(":", @$ip_data[0])[1];
							$all_syslog_data[$key]['destination_ip'] = @explode(":", @$ip_data[1])[0];
							$all_syslog_data[$key]['destination_port'] = @explode(":", @$ip_data[1])[1];
							$all_syslog_data[$key]['destination_port'] = str_replace(')','',$all_syslog_data[$key]['destination_port']);
						}
					}
					
				}
				
				
				if(strpos($message, "NAT") !== false){
					$nat_ip = str_replace(@$ip_data[1],'',str_replace(@$ip_data[0],'',$message));
					$nat_ip_array = str_replace(')','',str_replace('(','',str_replace('->','',str_replace('NAT','',$nat_ip))));
					$all_syslog_data[$key]['nat_ip'] = @explode(":", @$nat_ip_array)[0];
					$all_syslog_data[$key]['nat_port'] = @explode(":", @$nat_ip_array)[1];
				}
				
				if(isset($all_syslog_data[$key]['src_ip'], $data['_source']['@timestamp']) && $missing_find && $all_syslog_data[$key]['src_ip'] && $all_syslog_data[$key]['user'] == 'N/A'){
					$missing_user_data = self::getMissingUser($all_syslog_data[$key]['src_ip'], $date_start, $date_end, $from_hours, $from_mins, $to_hours, $to_mins);
				
					if(isset($missing_user_data['user']) && $missing_user_data['user']){
						$all_syslog_data[$key]['user'] = $missing_user_data['user'];
						$all_syslog_data[$key]['mac'] = $missing_user_data['mac'];
						$all_syslog_data[$key]['host'] = $missing_user_data['router_ip'];
					}
				//for missing mac	
				}else if(isset($all_syslog_data[$key]['src_ip'], $data['_source']['@timestamp']) && $missing_find && $all_syslog_data[$key]['src_ip'] && $all_syslog_data[$key]['user'] != 'N/A' && $all_syslog_data[$key]['mac'] == 'N/A'){
					$missing_user_data = self::getMissingUser($all_syslog_data[$key]['src_ip'], $date_start, $date_end, $from_hours, $from_mins, $to_hours, $to_mins);
				
					if(isset($missing_user_data['mac']) && $missing_user_data['mac']){
						$all_syslog_data[$key]['mac'] = $missing_user_data['mac'];
					}
				}else{
					if($user_name && $mac_ip && $main_src_ip){
						$all_syslog_data[$key]['user'] = $user_name;									
						$all_syslog_data[$key]['mac'] = $mac_ip;
						$all_syslog_data[$key]['host'] = $main_src_ip;
					}
				}
				
				
			}
			
			
			if(isset($all_syslog_data[$key]['destination_port'], $_POST['src_port']) && $all_syslog_data[$key]['destination_port'] && $_POST['src_port']){
					if($_POST['src_port'] === $all_syslog_data[$key]['destination_port']){
						if(isset($all_syslog_data[$key])){
						    $all_syslog_data[$key]['status'] = false;
						}
					}
			}else if(isset($all_syslog_data[$key]['src_port'], $_POST['dst_port']) && $all_syslog_data[$key]['src_port'] && $_POST['dst_port']){
					if($_POST['dst_port'] === $all_syslog_data[$key]['src_port']){
						if(isset($all_syslog_data[$key])){
						    $all_syslog_data[$key]['status'] = false;
						}
					}
			}else if(isset($_POST['nat_port'], $all_syslog_data[$key]['nat_port'], $all_syslog_data[$key]['destination_port'], $all_syslog_data[$key]['src_port']) && $_POST['nat_port']){
				if($all_syslog_data[$key]['nat_port'] == 'N/A'){
					$all_syslog_data[$key]['status'] = false;
				}else if(($all_syslog_data[$key]['nat_port'] == 'N/A' && ($_POST['nat_port'] === $all_syslog_data[$key]['destination_port'])) || ($all_syslog_data[$key]['nat_port'] == 'N/A' && ($all_syslog_data[$key]['destination_port'] === $all_syslog_data[$key]['src_port']))){
					if(isset($all_syslog_data[$key])){
						$all_syslog_data[$key]['status'] = false;
					}
				}
			}
			


			
		}
		
		return $all_syslog_data;
	}
	
	private function getQueryData($match, $index = 'cloud-log-nat', $limit = 50, $offset = 0, $page_name = 'log')
	{
		$query = new Query;
		$query->from($index);
		$query->query = $match;
		if($page_name == 'log'){
		    $query->orderBy(['@timestamp' => SORT_DESC]);
		}else{
			$query->orderBy(['@timestamp' => SORT_ASC]);
		}
		$query->offset = $offset;
		$query->limit = $limit;
		$command = $query->createCommand();
        $response = $command->search();

		$all_data = [];
		if(!empty($response)){
			if(isset($response['hits']['hits']) && !empty($response['hits']['hits'])){
				$all_data = $response['hits']['hits'];
			}
		}
		return $all_data;
	}
	
	private function getQueryCount($match, $index = 'cloud-log-nat')
	{
		$query = new Query;
		$query->from($index);
		$query->query = $match;
		$count = $query->count();
		return $count;
	}
	
	private function filter_match_phrase_prefix($search_string){
		return [
		  "match_phrase"=> [
			"MESSAGE"=> '.*'.$search_string.'.*'
		  ]
		];
	}
	
	public function actionSearch()
	{
		$params = require __DIR__ . '/../config/configuration.php';
		$offset = Yii::$app->getRequest()->getQueryParam('offset');
		$limit = Yii::$app->getRequest()->getQueryParam('limit');
		
		if(!$offset){
			$offset = 0;
		}
		
		if(!$limit){
			$limit = 100;
		}
		$date_filter[] = [
				"range"=>[
					"@timestamp"=>[
						   "time_zone"=> "+06:00",
						   "gte" => "now-24h",
						   "lt" =>  "now"
					]
				]
		];
		$match  =	 [
			"bool"=> [
			  "must"=>$date_filter	
			]
		];
		
		$query = new Query;
		$query->from('cloud-log-nat');
		//$query->query = $match;
		$query->orderBy(['@timestamp' => SORT_DESC]);
		$query->offset = $offset;
		$query->limit = $limit;
		$command = $query->createCommand();
        $response = $command->search();
				
		ApplicationHelper::_setTrace("API ENDPOINT: ".@$params['elasticSearchHttpAddress'], 0);
		ApplicationHelper::_setTrace($response);

	}
	
	
	public function actionDate()
	{
		print date('Y-m-d H:i:s');
		
		print '</br>';
		
		$date = new \DateTime();
		$timeZone = $date->getTimezone();
		print $timeZone->getName();

	}
}