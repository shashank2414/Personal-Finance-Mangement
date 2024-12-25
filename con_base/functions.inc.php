<?php
session_start();
include("db.config.inc.php");
date_default_timezone_set("Asia/Kolkata");
//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
//header("Cache-Control: no-store, must-revalidate");
//header("Pragma: no-cache");
 
//// each client should remember their session id for EXACTLY 1 hour

 
$qry_global=mysqli_query($DB_LINK,"select * from tbl_setting")or die(mysqli_error($DB_LINK));
$global_fetch=mysqli_fetch_array($qry_global);
$SITE_NAME= stripslashes($global_fetch['site_name']);
$SITE_URL= stripslashes($global_fetch['site_url']);
$EMAIL_ID=stripslashes($global_fetch['email']); 
$EMAIL_ID_2=stripslashes($global_fetch['email2']);
$MOBILE=stripslashes($global_fetch['mobile']);
$MOBILE2=stripslashes($global_fetch['mobile2']); 
$fax=stripslashes($global_fetch['fax']);
$ADDRESS=stripslashes($global_fetch['address']);
$MAP=stripslashes($global_fetch['google_map']);
$F=stripslashes($global_fetch['f']);
$L=stripslashes($global_fetch['l']);
$T=stripslashes($global_fetch['t']);
$Y=stripslashes($global_fetch['y']);
$W=stripslashes($global_fetch['g']);
$WEBMAIL=stripslashes($global_fetch['webmail']);
$MPASS=stripslashes($global_fetch['mpass']);
$HOST=stripslashes($global_fetch['host']);
$PORT=stripslashes($global_fetch['port']);
$IS_MENU=stripslashes($global_fetch['is_menu']);
$msg_contact=stripslashes($global_fetch['msg_contact']);
$msg_pass=stripslashes($global_fetch['msg_pass']);
$msg_sender_id=stripslashes($global_fetch['msg_sender_id']);
$msg_type=stripslashes($global_fetch['msg_typ']);
$SESSION_MIN = 10;
$current_year = date('Y'); 
$ADMIN_HTML_TITLE=stripslashes($global_fetch['site_admin_title']);

//$LAST_BINARY_ID=stripslashes($global_fetch['binary_last_ac']);

function  update_bin_id($m_id)
{
	global $DB_LINK;

	$qry=mysqli_query($DB_LINK,"update tbl_setting set binary_last_ac='$m_id' ");
}

function  update_bin_id_pre($m_id)
{
	global $DB_LINK;

	$qry=mysqli_query($DB_LINK,"update tbl_setting set binary_last_ac_pre='$m_id' ");
}



function  update_bin_id_mem_table($m_id)
{
 global $DB_LINK;
 $qry=mysqli_query($DB_LINK,"update tbl_staff_profile set is_binary_calc='1' where id='$m_id' ");  
}


// function for admin login validation
function validate()
{
	if (time() - $_SESSION['CREATED'] > 1800) 
    {
   		// session started more than 30 minutes ago
    	//session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    	//$_SESSION['CREATED'] = time();  // update creation time
		header("location:sign-in");
		exit();
	}
}


function master_main()
{
	if(!isset($_SESSION['session_master']))
	{
        session_destroy();
        header("location:sign-in");
		exit();
	}
    if (time() - $_SESSION['CREATED'] > 30) {
        session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
        $_SESSION['CREATED'] = time();  // update creation time
    }


    if (time() - $_SESSION['CREATED'] > 60)
    {
        // session started more than 30 minutes ago
        session_destroy();
        header("location:sign-in");
        exit();
    }

}

function logout_time()
{
    $endTime = strtotime("+1 minutes", $_SESSION['CREATED']);
    echo date('h:i:s', $endTime);
}

//$_SESSION['CREATED'] = time();  // update creation time

function master_developer()
{
  if("amritforu8896935191"!=$_SESSION['session_master'])
  {
    $_SESSION['msg']=array('error', 'Server error!!');
    header("location:index.php");
    exit;
  }
}


// function for user login validation
function validate_user()
{
	if (time() - $_SESSION['CREATED_USER'] > 1800) 
  	{
  		// session started more than 30 minutes ago
    	//session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    	//$_SESSION['CREATED'] = time();  // update creation time
		session_destroy(); 
		header("location:sign-in");
		exit();
	}
}
function master_user()
{
	if(!isset($_SESSION['session_user']))
	{
		header("location:../login.html");
		exit();
	}
}
// function for staff login validation
function validate_staff()
{
	if (time() - $_SESSION['CREATED_STAFF'] > 1800) 
  	{
  		// session started more than 30 minutes ago
    	//session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    	//$_SESSION['CREATED'] = time();  // update creation time
		session_destroy(); 
		header("location:../login.html");
		exit();
	}
}
function master_staff()
{
	if(!isset($_SESSION['session_staff']))
	{
		//header("location:sign-in");
		//exit();
		header("location:../login.html");
		exit();
	}
}
// function for user login validation
function validate_branch()
{
	if (time() - $_SESSION['CREATED_BRANCH'] > 1800) 
  	{
  		// session started more than 30 minutes ago
    	//session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    	//$_SESSION['CREATED'] = time();  // update creation time
		session_destroy(); 
		header("location:sign-in");
		exit();
	}
}
function master_branch()
{
	if(!isset($_SESSION['session_branch']))
	{
		header("location:sign-in");
		exit();
	}
}
function master_member()
{
if(!isset($_SESSION['session_user'])) {  header("location:../");  exit(); }
}
function master_recruiters()
{
 if(!isset($_SESSION['session_recruiters'])) { header("location:sign-in");  exit(); }
}
function update_kyc()
{
	if($_SESSION['user_uid']=='')
	{
		$_SESSION[ 'warn_msg' ] = "Kindly complete the profile";
		header("Location: ../profile_edit");
		exit;
	}
}
function update_bank()
{
	if($_SESSION['user_bank']=='')
	{
		$_SESSION['warn_msg'] = "Kindly complete the Bank Details";
		header("Location: ../bank_details_edit");
		exit;
	}
}
//SEO URL Friendly
function clean($string) 
{
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

//SEO URL Friendly
function clean_witout_underscore($string)
{
    //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}
// function for filter the string
function normal_filter($val)
{
	return ucfirst(stripslashes($val));
}
function strip_filter($val, $size)
{
	return substr(stripslashes(strip_tags($val)),0,$size);
}
function caps_filter($val)
{
	return strtoupper(stripslashes($val));
}
function normalall_filter($val)
{
	return ucwords(stripslashes($val));
}
function date_dmy($date)
{
	if($date!='' || $date!='0000-00-00 00:00:00')
  	{
  		return date("j M Y h:i A", strtotime($date));
  	}
}

function date_time_only($date)
{
    if($date!='' || $date!='0000-00-00 00:00:00')
    {
        return date("h:i:s A", strtotime($date));
    }
}
function date_dmy_small($date)
{
  	if($date!='' && $date!='0000-00-00')
  	{
  		 return date("j M Y", strtotime($date));
  	}
}
// function to access description form content table
function enc($val)
{
	if($val!='')
	{
		$new_val=base64_encode(base64_encode(base64_encode(base64_encode($val))));
		return $new_val;
	}
}
function dec($val)
{
	if($val!='')
	{
		$org_val=base64_decode(base64_decode(base64_decode(base64_decode($val))));
		return $org_val;
	}
}
function enc_normal($val)
{
	if($val!='')
	{
		$new_val=base64_encode(base64_encode($val));
		return $new_val;
	}
}
function dec_normal($val)
{
	if($val!='')
	{
		$org_val=base64_decode(base64_decode($val));
		return $org_val;
	}
}
 
function show_content($id,$row_name,$DB_LINK)
{
	$grs=mysqli_query($DB_LINK,"select $row_name from tbl_category where id='$id'");
	$row=mysqli_fetch_array($grs);
	return $row[$row_name];
}
 
function data_cutter($data,$cut)
{
	if(strlen(stripslashes($data))>$cut)
	{
		$cutdata=ucfirst(substr(stripslashes($data),0,$cut)).".."; 
	}
	else 
	{
		$cutdata=stripslashes($data); 
	}
	return $cutdata;
}
function data_cutter_clean($data,$cut)
{
	if(strlen(stripslashes($data))>$cut)
	{
		$cutdata=ucfirst(substr(stripslashes($data),0,$cut)); 
	}
	else 
	{
		$cutdata=stripslashes($data); 
	}
	return $cutdata;
}
function date_dm($date)
{
  	if($date!='' && $date!='0000-00-00 00:00:00' && $date!='0000-00-00')
  	{
		return date("j M Y",strtotime($date));
  	}
}
function curPageName() 
{
	return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
$currentPG=curPageName(); 
//session_destroy();
function get_client_ip() 
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
function get_ip() 
{
	//Just get the headers if we can or else use the SERVER global
	if ( function_exists( 'apache_request_headers' ) ) 
	{
		$headers = apache_request_headers();
	} else 
	{
			$headers = $_SERVER;
	}
	//Get the forwarded IP if it exists
	if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) 			    {
		$the_ip = $headers['X-Forwarded-For'];
	} 
	elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
		) 
	{
		$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
	} 
	else 
	{
			
		$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
	}
	return $the_ip;
}
	
function ip_store($log_type,$log_id)
{ 
  	global $DB_LINK;
	$ip=get_ip();
	/*$qry_ip=mysqli_query($DB_LINK,"select * from log_data where ip='$ip'");
	$count_ip=mysqli_num_rows($qry_ip);
	if($count_ip>0)
	{
    	$global_ip=mysqli_fetch_array($qry_ip);
		$ip_open=$global_ip['count']+1;
   		mysqli_query($DB_LINK,"update log_data set count='$ip_open',dt='".date("Y-m-d")."' where ip='$ip'");
	}
	else
	{}*/
 // echo "insert into log_data set  ip='$ip',log_typ='$log_type',log_id='$log_id' "; exit;
	mysqli_query($DB_LINK, "insert into log_data set ip='$ip', log_typ='$log_type', log_id='$log_id'");
	
}
	
 s
//Date ago time*/
function timeAgo($time_ago)
{
    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        echo "Just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1)
		{
            echo "One minute ago";
        }
        else
		{
            echo "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24)
	{
        if($hours==1){
            echo "An hour ago";
        }else{
            echo "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 7)
	{
        if($days==1){
            echo "Yesterday";
        }else{
            echo "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 4.3)
	{
        if($weeks==1){
            echo "A week ago";
        }else{
            echo "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12)
	{
        if($months==1){
            echo "A month ago";
        }else{
            echo "$months months ago";
        }
    }
    //Years
    else
	{
        if($years==1)
		{
            echo "One year ago";
        }else{
            echo "$years years ago";
        }
    }
}  
 
function yearCalculator($dt, $y){
    if(!empty($dt)){
        $dt=strtotime($dt);
		$end = strtotime('+'. $y .'year', $dt);
		$year=date('Y-m-d',$end);
		//$year=date('d M Y',$end);
		return $year;
    }else{
        return 0;
    }
}
function simpleInterest($p, $r, $t){
	
	$si = ($p*$r*$t)/100;
	
	$amt=$p+$si;
	
	return $amt;
}
 
 
function insert_ledger($to, $from, $typ, $amt, $prt, $ttyp, $description='', $byledger)
{
	global $DB_LINK;
	$ins="INSERT INTO `tbl_leg_add` set `to_mem`='".$to."', `from_mem`='".$from."', `typ` ='$typ', `amt`='".$amt."', `dt`='".date("Y-m-d")."', `part`='$prt', ttyp='$ttyp', txnid='".time().rand(100,999)."', description='$description', byledger='$byledger'";
	mysqli_query($DB_LINK,$ins);
}
function insert_ledger_rec($to, $typ, $amt, $prt, $ttyp)
{
	global $DB_LINK;
	$ins="INSERT INTO `tbl_leg_rec` set `member`='".$to."', `typ` ='$typ', `amt`='".$amt."', `dt`='".date("Y-m-d")."', `part`='$prt', ttyp='$ttyp', txnid='".time().rand(100,999)."'";
	mysqli_query($DB_LINK,$ins);
}
 

function sentwp_sms($mobile,$msg,$Id=0)
{
	global $DB_LINK, $TodayDateFull;
	
	// $msg = str_replace(' ', '%20', $msg);
	//$msg=urlencode($msg);
	
	
	$sql_log_typ_firm = " select * from firm  where id='25' ";
	$firm_data = mysqli_fetch_assoc(mysqli_query($DB_LINK, $sql_log_typ_firm));
	$wp_username = $firm_data['wp_username'];
	$wp_password = $firm_data['wp_password'];
	$wp_api_token = $firm_data['wp_api_token'];
	$REGARDS = $firm_data['name'];
	
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.devindia.in/api/send/text/message/v1',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => http_build_query(array(
			'username' => $wp_username,
			'password' => $wp_password,
			'receiver_number' => '91' . $mobile,
			'msgtext' => $msg,
			'token' => $wp_api_token,
		)),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	 
	wp_sms_store($msg, $mobile, $status, $sentdate, $Id, $response);
		
		
		 
}
 

function wp_sms_store($msg,$contact,$status,$sentdate,$Id,$response)
{
    global $DB_LINK;
    if($Id=='0')
        $Id=rand(1000,9999);
    $ip=get_ip();
    if(isset($_SESSION['session_master']))
        $log_id=$_SESSION['session_master'];
    else
        $log_id="0";

    if(isset($_SESSION['master_company_id']))
        $firm_id=$_SESSION['master_company_id'];
    else
        $firm_id="0";

    if($sentdate!='NULL') $sentdt=", `sent_date`='$sentdate'";

     $qry="INSERT INTO `log_wp_msg` set 
    `ip`='$ip', 
    `log_id`='$log_id', 
    `firm_id`='$firm_id', 
    `msg`='".$msg."', 
    `contact`='$contact',
    `status`=$status,
    rec_id='$Id',
    response='$response'
    $sentdt    ";

    $dup_user=mysqli_num_rows(mysqli_query($DB_LINK,"select * from log_wp_msg where 
                       rec_id='".$Id."' and  log_id='$log_id'  "));
    if($dup_user<1)
    {
        mysqli_query($DB_LINK,$qry);
    }


}

function wp_sms_balance()
{
    global $DB_LINK;

    $sql_log_typ_firm = " select * from firm  where id='".$_SESSION['master_company_id']."' ";
    $firm_data=mysqli_fetch_assoc(mysqli_query($DB_LINK, $sql_log_typ_firm ));
    $wp_username=$firm_data['wp_username'];
    $wp_api_token_credit=$firm_data['wp_api_token_credit'];

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://int.chatway.in/api/credits?username=".$wp_username."&token=".$wp_api_token_credit."",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Cookie: a842d12e022a86cef1417c4d0641b5bc=oslnaq4jm74q7016ca094bf3hd'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $result=$response;
    $a = json_decode($result, true);
    $b=$a["credits"];
    foreach($b as $elem)  {
        $c=$elem["credits_bal"];
    }

    //$b=json_decode(json_encode($a["credits"]), true);;
    return $c ;



    //echo $response;
    /*$client = new http\Client;
    $request = new http\Client\Request;
    $request->setRequestUrl("http://chatway.in/wasup/api/send-msg?username=akmishra&number=91$mobile&message=$msg&token=SzR3UWJVQTBTUmZIRjJ6cXFrb0hYUT09");
    //$request->setRequestUrl("http://chatway.in/wasup/api/send-msg?username=devindia765@gmail.com&number=919695639782&message=$msg&token=c2crMnk0c09aaVoxMGYxU2d2Tk9idz09");
    $request->setRequestMethod('GET');
    $request->setOptions(array());
    $request->setHeaders(array(
        'Cookie' => 'a842d12e022a86cef1417c4d0641b5bc=8d2v6hnm9mq4o3ooigt5v7hs4r'
    ));
    $client->enqueue($request)->send();
    $response = $client->getResponse();
    $result=$response->getBody();

    $a = json_decode($result, true);
    $a["status"];
    if($a["status"]=="error")
    {
        $client1 = new http\Client;
        $request1 = new http\Client\Request;
        //$request->setRequestUrl("http://chatway.in/wasup/api/send-msg?username=akmishra&number=91$mobile&message=$msg&token=eUlJZC9vQUxRN1FxRzg4NkF5TjdBUT09");
        $request1->setRequestUrl("http://chatway.in/wasup/api/send-msg?username=devindia765@gmail.com&number=91$mobile&message=$msg&token=c2crMnk0c09aaVoxMGYxU2d2Tk9idz09");
        $request1->setRequestMethod('GET');
        $request1->setOptions(array());
        $request1->setHeaders(array(
            'Cookie' => 'a842d12e022a86cef1417c4d0641b5bc=8d2v6hnm9mq4o3ooigt5v7hs4r'
        ));
        $client1->enqueue($request1)->send();
        $response1 = $client1->getResponse();
        $result=$response1->getBody();*/
	


}
 
 

 
function alert_msg($type, $module)
{
    switch($type)
    {
        case 'success': $toastr = 'Successfully !!'; $sweetalert = 'success';
        break;
        case 'error': $toastr = 'Error !!'; $sweetalert = 'error';
        break;
        case 'warning': $toastr = 'Warning !!'; $sweetalert = 'warning';
        break;
        case 'info': $toastr = 'Welcome !!'; $sweetalert = 'info';
        break;
    }
    $result = array($toastr, $sweetalert);
    return $result;
}
function logEvent($msg, $message) 
{
	global $DB_LINK;
    if ($message != '') 
	{
		$delim = "\t";   // set delim, eg tab 
		$res = mysqli_query($DB_LINK,$msg); 
		while ($row = mysqli_fetch_row($res)) { 
    		$scoredata = $row;
		} 
        // Add a timestamp to the start of the $message
        //$message = date("Y/m/d H:i:s").': '.$message."\r\n";
		$message = date("Y/m/d H:i:s").': '.$message."".PHP_EOL;
        //$fp = fopen('appLog-'.date('d-m-Y').'.txt', 'a');
		$fp = fopen('logs/appLog-'.date('d-m-Y').'.txt', 'a');
        fwrite($fp, $message);
		fwrite($fp, join($delim, $scoredata) . "\r\n"); 
        fclose($fp);
    }
}
 
function randomString($length = 8) 
{
  $str = "";
  $characters = array_merge(range('A','Z'));
  $max = count($characters) - 1;
  for ($i = 0; $i < $length/2; $i++) {
    $rand = mt_rand(0, $max);
    $str .= $characters[$rand];
  }
  $characters = array_merge( range('0','9'));
  $max = count($characters) - 1;
  for ($i = 0; $i < $length/2; $i++) {
    $rand = mt_rand(0, $max);
    $str .= $characters[$rand];
  }
  return $str;
}  

function sanitizeInput($data) {
    $data = trim($data); // Remove unnecessary spaces
    $data = stripslashes($data); // Remove backslashes
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Convert special characters to HTML entities
    return $data;
}
   
        
?>