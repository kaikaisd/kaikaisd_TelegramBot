
<?php
namespace kaikais_bot_index

require_once "vendor/autoload.php";

class TelegramProcess{
	public static function process()
    {
	try {
	$token = 'YOUR TOKEN';
    $bot = new \TelegramBot\Api\Client($token);
	
	$command_list = array("ping", "chatid" ,"start", "ipip", "me", "dmhyrss","leave","ipapiip","keycdnip","bangumirss","kick");
		foreach ($command_list as $command) {
			$bot->command($command, function ($message) use ($bot, $command) {
				TelegramProcess::telegram_process($bot, $message, $command);       
			});
		}
		
		
		 $bot->on($bot->getEvent(function ($message) use ($bot) {
                TelegramProcess::telegram_process($bot, $message, '');
            }), function () {
                return true;
            });
		
		 $bot->run();
		} catch (\TelegramBot\Api\Exception $e) {
            $e->getMessage();
		}
	}	
	
    public static function telegram_process($bot, $message, $command)
    { 		
	//IF&CASE
	
		
	if ($message->getChat()->getId() > 0) {
		
		switch ($command) {
        	
        case 'start':
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
			$bot->sendMessage($message->getChat()->getId(), "Thanks for using this bot, but this bot doesn't have any function , so just ignore it ! ");
		break;
		
		case 'ping':
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
			$bot->sendMessage($message->getChat()->getId(), 'pong!');
		break;
		
		case 'chatid':
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
			$bot->sendMessage($message->getChat()->getId(),'This Chat ID is : '.$message->getChat()->getId().' !');
		break;
		case 'dmhyrss':
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
				
				$url_dmhy = "http://share.dmhy.org/topics/rss/rss.xml";
				$rss = simplexml_load_file($url_dmhy);
                $sitename = $rss->channel->title ;
				$responce = '';
				$dmhygettime = 0;
				$final_result ='';
					
				foreach( $rss->channel->item as $item )
				{
								//指定尋找位置
								$dmhygroup = $item->author;
								$title = $item->title ;  
								$link = $item->link ;  
								$magant = $item->enclosure['url'];
								$category = $item->category;
								//
								
								//TEST
								$magant = str_replace(array("\r", "\n"), '', $magant);
								//
						
								//格式組成		
								$timestamp = strtotime( $item->pubDate );
								$date = date( 'Y 年 m 月 d 日 G 時 i 分',$timestamp );
								$responce ='網站 : ' . $sitename . PHP_EOL ;
								$responce .='發佈人/組 : ' . $dmhygroup .PHP_EOL;
								$responce .='類型 : ' . $category . PHP_EOL;
								$responce .='發佈時間 : ' . $date . PHP_EOL;
								$responce .='標題 : ' . $title . PHP_EOL;
								$responce .='網址 : ' ;
								$responce .='<a href="'.$link.'" > 打開 </a>' . PHP_EOL;
								$responce .='磁力連結 : ';
								$responce .='<a href="'.$magant.'"> 右鍵複製 (Not Done) </a>'.PHP_EOL;
								$responce .= PHP_EOL;
								//
										
								
								if ($dmhygettime++ > 2) break;
								
								$final_result .=$responce;
								 
				}
					
		$bot->sendMessage($message->getChat()->getId(), $final_result, $parseMode = HTML, $disablePreview = true, $replyToMessageId = $message->getMessageId());
		break;
		case 'bangumirss':
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
				
				$url_dmhy = "https://bangumi.moe/rss/latest";
				$rss = simplexml_load_file($url_dmhy);
                		$sitename = $rss->channel->title ;
				$responce = '';
				$dmhygettime = 0;
				$final_result ='';
					
				foreach( $rss->channel->item as $item )
				{
				//指定尋找位置
								$dmhygroup = $item->author;
								$title = $item->title ;  
								$link = $item->link ;  
								$magant = $item->enclosure['url'];
								$category = $item->category;
								//
								
								//TEST
								$magant = str_replace(array("\r", "\n"), '', $magant);
								//
						
								//格式組成		
								$timestamp = strtotime( $item->pubDate );
								$date = date( 'Y 年 m 月 d 日 G 時 i 分',$timestamp );
								$responce ='網站 : ' . $sitename . PHP_EOL ;
								$responce .='發佈時間 : ' . $date . PHP_EOL;
								$responce .='標題 : ' . $title . PHP_EOL;
								$responce .='網址 : ' ;
								$responce .='<a href="'.$link.'" > 打開 </a>' . PHP_EOL;
								$responce .='BT連結 : ';
								$responce .='<a href="'.$magant.'"> 右鍵複製</a>'.PHP_EOL;
								$responce .= PHP_EOL;
								//
										
								
								if ($dmhygettime++ > 2) break;
								
								$final_result .=$responce;
								 
				}
					
		$bot->sendMessage($message->getChat()->getId(), $final_result, $parseMode = HTML, $disablePreview = true, $replyToMessageId = $message->getMessageId());
		break;
		
		case 'me':
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
			$fntext="";
			$user_text=$message->getText();
			if (strpos($user_text, '@kaikaisd_bot') !== false) {
			$fntext= str_replace("/me@kaikaisd_bot ","",$user_text);
			}else{
			$fntext= str_replace("/me ","",$user_text);
			}
			$name=$message->getFrom()->getUsername();
			
			$$OAtext = '<code>@'.$name.' '.$fntext.'</code>';
		
			$bot->sendMessage($message->getChat()->getId(),$OAtext, $parseMode = HTML, $disablePreview = true);
			
		break;
		case 'ipapiip':
		
		$bot->sendChatAction($message->getChat()->getId(), 'typing');
		
		$status='';
		$total_result='';
		
		$user_text=$message->getText();
		if (strpos($user_text, '@kaikaisd_bot') !== false) {
		$ip= str_replace("/ipapiip@kaikaisd_bot ","",$user_text);
		}else{
		$ip= str_replace("/ipapiip ","",$user_text);
		}
		
		$apiurl='https://ipapi.co/'.$ip.'/json/';
			$opts=array(
				'http'=>array(
					'method'=>"GET"
					)
			);
		
		$context=stream_context_create($opts);
	
		$info=json_decode(file_get_contents($apiurl, null, $context));
			if($info->error=='true'){
				$status = $info->reason;
				$bot->sendMessage($message->getChat()->getId(),'ERROR : '.$status, $parseMode = null, $disablePreview = true, $replyToMessageId = $message->getMessageId() );
				exit();
			}
		
		
		$city ='<code>';
		$city.='IP : '.$ip.PHP_EOL;
		$city.='國家 : '.$info->country_name. PHP_EOL;
		$city.='城市 : '.$info->city. PHP_EOL;
		$city.='地區 : '.$info->region. PHP_EOL;
		$city.='ISP : '.$info->org. PHP_EOL;
		$city.='</code>';
		$city.='<a href="http://bgp.he.net/'.$info->asn.'">'.$info->asn." ".$info->org.'</a>'. PHP_EOL;
		
		$total_result .= $city;
		
		
		$bot->sendMessage($message->getChat()->getId(),$total_result, $parseMode = HTML, $disablePreview = true, $replyToMessageId = $message->getMessageId());
		
		break;
		
		case 'keycdnip':
		$bot->sendChatAction($message->getChat()->getId(), 'typing');
		
		$status='';
		$total_result='';
		
		$user_text=$message->getText();
		if (strpos($user_text, '@kaikaisd_bot') !== false) {
		$ip= str_replace("/keycdnip@kaikaisd_bot ","",$user_text);
		}else{
		$ip= str_replace("/keycdnip ","",$user_text);
		}
		
		$apiurl='https://tools.keycdn.com/geo.json?host='.$ip;
			$opts=array(
				'http'=>array(
					'method'=>"GET"
					)
			);
		
		$context=stream_context_create($opts);
	
		$info=json_decode(file_get_contents($apiurl, null, $context));
			if($info->error=='true'){
				$status = $info->reason;
				$bot->sendMessage($message->getChat()->getId(),'ERROR : '.$status, $parseMode = null, $disablePreview = true, $replyToMessageId = $message->getMessageId() );
				exit();
			}
		
		
		$city ='<code>';
		$city.='IP : '.$ip.PHP_EOL;
		$city.='國家 : '.$info->data->country_name. PHP_EOL;
		$city.='城市 : '.$info->data->city. PHP_EOL;
		$city.='地區 : '.$info->data->region. PHP_EOL;
		$city.='ORG : '.$info->data->org. PHP_EOL;
		$city.='rDNS : '.$info->data->rdns. PHP_EOL;
		$city.='ISP : '.$info->data->isp. PHP_EOL;
		$city.='</code>';
		$city.='<a href="http://bgp.he.net/'.$info->data->asn.'">'.$info->data->asn." ".$info->data->org.'</a>'. PHP_EOL;
		
		$total_result .= $city;
		
		
		$bot->sendMessage($message->getChat()->getId(),$total_result, $parseMode = HTML, $disablePreview = true, $replyToMessageId = $message->getMessageId());
		
		
		break;
		
		}
	 }else{
		 
		switch ($command) {
			
		case 'leave':
			$uid=$message->getFrom()->getId();
		    	if($uid== admin id ){
				$bot->sendMessage($message->getChat()->getId(), "GoodBye");
            			$bot->leaveChat($message->getChat()->getId()); 
			}
        break;
		
	case 'kick':
			$uid=$message->getreplyformmessgae()->getFrom()->getId();
            		 if($uid!==null){
			$bot->sendMessage($message->getChat()->getId(), "GoodBye",);
			 $target=$message->getreplytomessageId()->getChat()->getId();
           		  $bot->kickChatMember($target,$replyToMessageId = $message->getreplytomessageId()); 
			 }
         break;
		
        case 'start':
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
			$bot->sendMessage($message->getChat()->getId(), "Thanks for using this bot, but this bot doesn't have any function , so just ignore it ! ");
		break;
		
		case 'ping':
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
			$bot->sendMessage($message->getChat()->getId(), 'pong!');
		break;
		
		case 'chatid':
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
			$bot->sendMessage($message->getChat()->getId(),'This Chat ID is : '.$message->getChat()->getId().' !');
		break;
		
		case 'dmhyrss':
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
				
			$url_dmhy = "http://share.dmhy.org/topics/rss/rss.xml";
			$rss = simplexml_load_file($url_dmhy);
            $sitename = $rss->channel->title ;
			$responce = '';
			$dmhygettime = 0;
			$final_result ='';
					
			foreach( $rss->channel->item as $item ){
					//指定尋找位置
					$dmhygroup = $item->author;
					$title = $item->title ;  
					$link = $item->link ;  
					$magant = $item->enclosure['url'];
					$category = $item->category;
					//
								
					//TEST
					$magant = str_replace(array("\r", "\n"), '', $magant);
					//
						
					//格式組成		
					$timestamp = strtotime( $item->pubDate );
					$date = date( 'Y 年 m 月 d 日 G 時 i 分',$timestamp );
					$responce ='網站 : ' . $sitename . PHP_EOL ;
					$responce .='發佈人/組 : ' . $dmhygroup .PHP_EOL;
					$responce .='類型 : ' . $category . PHP_EOL;
					$responce .='發佈時間 : ' . $date . PHP_EOL;
					$responce .='標題 : ' . $title . PHP_EOL;
					$responce .='網址 : ' ;
					$responce .='<a href="'.$link.'" > 打開 </a>' . PHP_EOL;
					$responce .='磁力連結 : ';
					$responce .='<a href="'.$magant.'"> 右鍵複製 (Not Done)</a>'.PHP_EOL;
					$responce .= PHP_EOL;
					//
										
					if ($dmhygettime++ > 1) break;
						$final_result .=$responce;
			}
					
			$bot->sendMessage($message->getChat()->getId(), $final_result, $parseMode = HTML, $disablePreview = true, $replyToMessageId = $message->getMessageId());
		break;
		
		case 'bangumirss':
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
				
				$url_dmhy = "https://bangumi.moe/rss/latest";
				$rss = simplexml_load_file($url_dmhy);
                $sitename = $rss->channel->title ;
				$responce = '';
				$dmhygettime = 0;
				$final_result ='';
					
				foreach( $rss->channel->item as $item )
				{
								//指定尋找位置
								$dmhygroup = $item->author;
								$title = $item->title ;  
								$link = $item->link ;  
								$magant = $item->enclosure['url'];
								$category = $item->category;
								//
								
								//TEST
								$magant = str_replace(array("\r", "\n"), '', $magant);
								//
						
								//格式組成		
								$timestamp = strtotime( $item->pubDate );
								$date = date( 'Y 年 m 月 d 日 G 時 i 分',$timestamp );
								$responce ='網站 : ' . $sitename . PHP_EOL ;
								$responce .='發佈時間 : ' . $date . PHP_EOL;
								$responce .='標題 : ' . $title . PHP_EOL;
								$responce .='網址 : ' ;
								$responce .='<a href="'.$link.'" > 打開 </a>' . PHP_EOL;
								$responce .='BT連結 : ';
								$responce .='<a href="'.$magant.'"> 右鍵複製 </a>'.PHP_EOL;
								$responce .= PHP_EOL;
								//
										
								
								if ($dmhygettime++ > 2) break;
								
								$final_result .=$responce;
								 
				}
					
		$bot->sendMessage($message->getChat()->getId(), $final_result, $parseMode = HTML, $disablePreview = true, $replyToMessageId = $message->getMessageId());
		break;
		
		case 'ipip':
		if ($message->getChat()->getId() == 'group id'){
		$bot->sendChatAction($message->getChat()->getId(), 'typing');
		
		$status='';
		$total_result='';
		$tet1='';
		$tet2='';
		$tet3='';
		$tet4='';
		
		$user_text=$message->getText();
		if ($user_text=="/ipip@kaikaisd_bot" or $user_text=="/ipip") {
			$bot->sendMessage($message->getChat()->getId(),"Sorry , I can't guess what IP Address which you want to check . ", $parseMode = null, $disablePreview = true );
			exit();
		}
		if (strpos($user_text, '@kaikaisd_bot') !== false) {
		$ip= str_replace("/ipip@kaikaisd_bot ","",$user_text);
		}else{
		$ip= str_replace("/ipip ","",$user_text);
		}
		
		$apiurl='http://ipapi.ipip.net/find?addr='.$ip;
			$opts=array(
				'http'=>array(
					'method'=>"GET",
					'header'=>"Token: IPIP TOKEN"
					)
			);
		
		$context=stream_context_create($opts);
	
		$info=json_decode(file_get_contents($apiurl, null, $context));
			if($info->ret=='err'){
				$status = $info->msg;
				$bot->sendMessage($message->getChat()->getId(),'ERROR / invalid query '.$status, $parseMode = null, $disablePreview = true, $replyToMessageId = $message->getMessageId() );
				exit();
			}
		if ($info->data[1]!== ""){
			$tet1=$info->data[1];
		}else{
			$tet1='EMPTY';
		}
		if ($info->data[2]!== ""){
			$tet2=$info->data[2];
		}else{
			$tet2='EMPTY';
		}
		if ($info->data[3]!== ""){
			$tet3=$info->data[3];
		}else{
			$tet3='EMPTY';
		}	
		if ($info->data[4]!== ""){
			$tet4=$info->data[4];
		}else{
			$tet4='EMPTY';
		}	
		
		$city ='<code>';
		$city.='IP : '.$ip.PHP_EOL;
		$city.='國家 : '.$info->data[0]. PHP_EOL;
		$city.='城市 : '.$tet1. PHP_EOL;
		$city.='地區 : '.$tet2. PHP_EOL;
		$city.='ORG : '.$tet3. PHP_EOL;
		$city.='ISP : '.$tet4. PHP_EOL;
		$city.='</code>';
		
		$total_result .= $city;
		
		
		$bot->sendMessage($message->getChat()->getId(),$total_result, $parseMode = HTML, $disablePreview = true, $replyToMessageId = $message->getMessageId());
		}else{
			$bot->sendMessage($message->getChat()->getId(),'This Command is only for specfic group use only.', $parseMode = null, $disablePreview = true,$replyToMessageId = $message->getMessageId() );
		}
		
		break;
		
		case 'ipapiip':
		
		$bot->sendChatAction($message->getChat()->getId(), 'typing');
		
		$status='';
		$total_result='';
		
		$user_text=$message->getText();
		if ($user_text=="/ipapiip@kaikaisd_bot" or $user_text=="/ipapiip") {
			$bot->sendMessage($message->getChat()->getId(),"Sorry , I can't guess what IP Address which you want to check . ", $parseMode = null, $disablePreview = true );
			exit();
		}
		if (strpos($user_text, '@kaikaisd_bot') !== false) {
		$ip= str_replace("/ipapiip@kaikaisd_bot ","",$user_text);
		}else{
		$ip= str_replace("/ipapiip ","",$user_text);
		}
		
			if ($ip!==""){
				$apiurl='https://ipapi.co/'.$ip.'/json/';
				$opts=array(
					'http'=>array(
						'method'=>"GET"
						)
				);
		
			$context=stream_context_create($opts);
	
			$info=json_decode(file_get_contents($apiurl, null, $context));
				if($info->error=='true'){
					$status = $info->reason;
					$bot->sendMessage($message->getChat()->getId(),'ERROR : '.$status, $parseMode = null, $disablePreview = true, 	$replyToMessageId = $message->getMessageId() );
					exit();
			}
				if(strpos($info->country_name, 'limited')==ture){
					$status = $info->country_name;
					$bot->sendMessage($message->getChat()->getId(),'ERROR : '.$status, $parseMode = null, $disablePreview = true, 	$replyToMessageId = $message->getMessageId() );
					exit();
				}
		
		
			$city ='<code>';
			$city.='IP : '.$ip.PHP_EOL;
			$city.='國家 : '.$info->country_name. PHP_EOL;
			$city.='城市 : '.$info->city. PHP_EOL;
			$city.='地區 : '.$info->region. PHP_EOL;
			$city.='ISP : '.$info->org. PHP_EOL;
			$city.='</code>';
			$city.='<a href="http://bgp.he.net/'.$info->asn.'">'.$info->asn." ".$info->org.'</a>'. PHP_EOL;
		
			$total_result .= $city;
		
		
			$bot->sendMessage($message->getChat()->getId(),$total_result, $parseMode = HTML, $disablePreview = true, $replyToMessageId = $message->getMessageId());
			}else{
				$bot->sendMessage($message->getChat()->getId(),"Sorry , I can't guess what IP Address which you want to check . ", $parseMode = null, $disablePreview = true,$replyToMessageId = $message->getMessageId() );
			}
		break;
		
		
		case 'keycdnip':
		
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
			
			$status='';
			$total_result='';
		
			$user_text=$message->getText();
			if ($user_text=="/keycdnip@kaikaisd_bot"  or $user_text=="/keycdnip") {
				$bot->sendMessage($message->getChat()->getId(),"Sorry , I can't guess what IP Address which you want to check . ", $parseMode = null, $disablePreview = true ,$replyToMessageId = $message->getMessageId());
				exit();
			}
			if (strpos($user_text, '@kaikaisd_bot') !== false) {
				$ip= str_replace("/keycdnip@kaikaisd_bot ","",$user_text);
			}else{
				$ip= str_replace("/keycdnip ","",$user_text);
			}
		
			if ($user_text!=""){
			$apiurl='https://tools.keycdn.com/geo.json?host='.$ip;
				$opts=array(
					'http'=>array(
						'method'=>"GET"
						)
				);
		
			$context=stream_context_create($opts);
	
			$info=json_decode(file_get_contents($apiurl, null, $context));
			if($info->status=='error'){
				$status = $info->description;
				$bot->sendMessage($message->getChat()->getId(),'ERROR : '.$status, $parseMode = null, $disablePreview = true, $replyToMessageId = $message->getMessageId() );
				exit();
			}
		
		
			$city ='<code>';
			$city.='IP : '.$ip.PHP_EOL;
			$city.='國家 : '.$info->data->geo->country_name. PHP_EOL;
			$city.='ORG : '.$info->data->geo->org. PHP_EOL;
			$city.='rDNS : '.$info->data->geo->rdns. PHP_EOL;
			$city.='ISP : '.$info->data->geo->isp. PHP_EOL;
			$city.='</code>';
			$city.='<a href="http://bgp.he.net/'.$info->data->geo->asn.'">'.$info->data->geo->asn." ".$info->data->geo->isp.'</a>'. PHP_EOL;
		
			$total_result .= $city;
		
			$bot->sendMessage($message->getChat()->getId(),$total_result, $parseMode = HTML, $disablePreview = true, $replyToMessageId = $message->getMessageId());
		}else{
			$bot->sendMessage($message->getChat()->getId(),"Sorry , I can't guess what IP Address which you want to check . ", $parseMode = null, $disablePreview = true , $replyToMessageId = $message->getMessageId() );
		}
		
		break;
		
		case 'me':
			$bot->sendChatAction($message->getChat()->getId(), 'typing');
			$fntext="";
			$user_text=$message->getText();
			
			if (strpos($user_text, '@kaikaisd_bot') !== false) {
			$fntext= str_replace("/me@kaikaisd_bot ","",$user_text);
			}else{
			$fntext= str_replace("/me ","",$user_text);
			}
			
			$name1=$message->getFrom()->getfirstname();
			$name2=$message->getFrom()->getlastname();
			
			if ($name2!== ""){
				$OAtext = '<code>'.$name1." ".$name2.' '.$fntext.'</code>';
			}else{
				$OAtext = '<code>'.$name1.' '.$fntext.'</code>';
			}	
								
			$bot->sendMessage($message->getChat()->getId(),$OAtext, $parseMode = HTML, $disablePreview = true);
			
		break;
		
		// default:
		// $user_text = $message->getText();
		// $newusername=$message->getFrom()->getusername();
		// $member=$message->getNewChatMember();
					
			// if (!$message->getbotAddedInChat()){
				// $text= 'Welcome! @'.$newusername.' to join in our group , Please look at the RULES before you chat in ours';
				// $bot->sendMessage($message->getChat()->getId(),$text, $parseMode = null, $disablePreview = true );
			// }
			// if ($message->getreplytomessage() !=="")
			// {
				// if (strpos($user_text, 'dress') !== false) {
				// $text= 'この人は変態だ';
				// $bot->sendMessage($message->getChat()->getId(),$text, $parseMode = null, $disablePreview = true,$replyToMessageId = $message->getMessageId() );
			// }else{
				// $text= '何だかお尋ねします？';
				// $bot->sendMessage($message->getChat()->getId(),$text, $parseMode = null, $disablePreview = true,$replyToMessageId = $message->getMessageId() );
			// }
		
			// }
		
		
		$bot->sendChatAction($message->getChat()->getId(), '');	
		
	  }
	 
	
	}
	
  }
}  

$TelegramProcess = new TelegramProcess;
$TelegramProcess->process();



