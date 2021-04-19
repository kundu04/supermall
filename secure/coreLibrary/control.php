<?php
/*
	Model Name: Control
	Developed By: Nova Framework Developer
	Dated: 17/02/2014
	For: All the PHP Lovers
*/

class Control
{	
	/* ---------- ---------- ---------- CONSTRUCTOR FUNCTION ---------- ---------- ---------- */
	
	public function __construct()
	{
	}
	
	/* ---------- ---------- ---------- SECURITY FUNCTION ---------- ---------- ---------- */

	// Character + Number + Space Checking Function - By Nirjhor //
	function letNumCheck($value)
	{
		$value = urldecode($value); // Changable //
		if (!preg_match('/[^a-z A-Z 0-9\s]/i', $value))
		{
			return $value;
		} 
		else 
		{
			return '';
		}
	}
	
	// Letter + Space Checking Function - By Nirjhor //
	function alphaCheck($value)
	{
		$value = urldecode($value); // Changable //
		if (!preg_match('/[^a-z A-Z\s]/i', $value))
		{
			return $value;
		} 
		else 
		{
			return '';
		}
	}

	// Function to Check Password Field (Alphabets + Numbers + At-The-Rate Sign + #&-.@) - By Nirjhor //
	function passCheck($value)
	{
		$value = trim($value);
		
		if(preg_match('/[$%^()+=\\[\]\';,\/{}|":<>?~\\\\]/', $value) == 0)
			return $value;
		else
			return '';
	}

	// Function to Check Mail Field - By Nirjhor //
	function mailCheck($value)
	{
		$value = trim($value);

		if(preg_match('/[#$%^&*()+=\\[\]\';,\/{}|":<>?~\\\\]/', $value) == 0)
			return $value;
		else
			return '';
	}
	
	/* ---------- ---------- ---------- SECURITY FUNCTION ---------- ---------- ---------- */
	
	// SEND SIGNUP MAIL / ADMIN or USER //
	public function smtpMail($mailConfig, $mailDetails, $mailReceiver)
	{
		require_once 'C:\xampp\htdocs\me\supermall\secure\novaLibrary\smtpMail\swift_required.php';
			
		$transport = Swift_SmtpTransport::newInstance($mailConfig['host'], $mailConfig['port'])
		  ->setUsername($mailConfig['email'])
		  ->setPassword($mailConfig['pass'])
		;
		
		$mailer = Swift_Mailer::newInstance($transport);

		if(empty($mailDetails['attachment']['file_with_path']))
		{
			$fullMessage = Swift_Message::newInstance($mailDetails['title'])
			->setFrom(array($mailConfig['email'] => $mailConfig['name']))
			->setTo($mailReceiver)
			->setContentType($mailConfig['type'])
			->setBody($mailDetails['body']);
		}
		else
		{
			$fullMessage = Swift_Message::newInstance($mailDetails['title'])
			->setFrom(array($mailConfig['email'] => $mailConfig['name']))
			->setTo($mailReceiver)
			->setContentType($mailConfig['type'])
			->setBody($mailDetails['body'])
			->attach( Swift_Attachment::fromPath($mailDetails['attachment']['file_with_path'])->setFilename($mailDetails['attachment']['file_new_name']) );
		}
		
		return $result = $mailer->send($fullMessage);
	}
	
	// VERIFY FILE FORMAT // IMAGE TYPES //
	public function checkImage($fileType, $fileSize, $fileError)
	{
		$allowedExts = array("gif", "jpeg", "jpg", "png"); // in a Array > all Supported Image Formats are Stored //
		
		// 5 MB = 5242880 Bytes // 100 MB = 104857600 Bytes //
		if ((($fileType == "image/gif")
		|| ($fileType == "image/jpeg")
		|| ($fileType == "image/jpg")
		|| ($fileType == "image/pjpeg")
		|| ($fileType == "image/x-png")
		|| ($fileType == "image/png"))
		&& ($fileSize < 5242880)
		&& ($fileError <= 0))
		{
			return 1;
		}
		else 
			return 0;
	}
	
	// MAKE PASSWORD // RETURN TO USER for SIGNUP //
	public function makePass() 
	{
		$alphabet = "56789abcdefghijklmnopqrstuwxyz@#%#@ABCDEFGHIJKLMNOPQRSTUWXYZ01234";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
			for ($i = 0; $i < 8; $i++) 
			{
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
			return implode($pass); //turn the array into a string
	}
	
	public function makeCaptcha($digitNo, $digitColor)
	{
		if($digitNo == 4)
		{
			$rangeValue = rand(1000,9999);
			$my_img = imagecreate( 41, 24 );
		}
		else if($digitNo == 5)
		{
			$rangeValue = rand(10000,99999);
			$my_img = imagecreate( 50, 24 );
		}
		else if($digitNo == 6)
		{
			$rangeValue = rand(100000,999999);
			$my_img = imagecreate( 59, 24 );
		}
		
		if($digitColor == "black")
		{
			$background = imagecolorallocate( $my_img, 255, 255, 255 );
			$text_colour = imagecolorallocate( $my_img, 0, 0, 0 );
		}
		else if($digitColor == "white")
		{
			$background = imagecolorallocate( $my_img, 0, 0, 0 );
			$text_colour = imagecolorallocate( $my_img, 255, 255, 255 );
		}
		$line_colour = imagecolorallocate( $my_img, 128, 255, 0 );
		imagestring( $my_img, 5, 3, 3, $rangeValue, $text_colour );
		imagesetthickness ( $my_img, 5 );


		header( "Content-type: image/png" );
		imagepng( $my_img );
		imagecolordeallocate( $line_color );
		imagecolordeallocate( $text_color );
		imagecolordeallocate( $background );
		imagedestroy( $my_img );
	}
	
	public function makePdf($pdfName, $htmlBody)
	{
		require_once("novaLibrary/domPdf/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->load_html($htmlBody);
		$dompdf->render();
		$dompdf->stream($pdfName);
	}
	
	// CHECK USER AGENT TYPE // PC-USER OR MOBILE-USER OR BOT //
	public function agentCheck()
	{
		$user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );

		if ( preg_match ( "/abrowse\/|acoo browser\/|america online browser\/|amigavoyager\/|aol\/|arora\/|avant browser\/|beonex\/|bonecho\/|browzar\/|camino\/|charon\/|cheshire\/|chimera\/|cirefox\/|chrome\/|chromeplus\/|classilla\/|cometbird\/|comodo_dragon\/|conkeror\/|crazy browser\/|cyberdog\/|deepnet explorer\/|deskbrowse\/|dillo\/|dooble\/|element browser\/|elinks\/|enigma browser\/|enigmafox\/|epiphany\/|escape\/|firebird\/|firefox\/|fireweb navigator\/|flock\/|fluid\/|galaxy\/|galeon\/|granparadiso\/|greenbrowser\/|hana\/|hotjava\/|ibm webexplorer\/|ibrowse\/|icab\/|iceape\/|icecat\/|iceweasel\/|inet browser\/|internet explorer\/|irider\/|iron\/|k-meleon\/|k-ninja\/|kapiko\/|kazehakase\/|kindle browser\/|kkman\/|kmlite\/|konqueror\/|leechcraft\/|links\/|lobo\/|lolifox\/|lorentz\/|lunascape\/|lynx\/|madfox\/|maxthon\/|midori\/|minefield\/|mozilla\/|myibrow\/|myie2\/|namoroka\/|navscape\/|ncsa_mosaic\/|netnewswire\/|netpositive\/|netscape\/|netsurf\/|omniweb\/|opera\/|orca\/|oregano\/|osb-browser\/|palemoon\/|phoenix\/|pogo\/|prism\/|qtweb internet browser\/|rekonq\/|retawq\/|rockmelt\/|safari\/|seamonkey\/|shiira\/|shiretoko\/|sleipnir\/|slimbrowser\/|stainless\/|sundance\/|sunrise\/|surf\/|sylera\/|tencent traveler\/|tenfourfox\/|theworld browser\/|uzbl\/|vimprobable\/|vonkeror\/|w3m\/|weltweitimnetzbrowser\/|worldwideweb\/|wyzo\//", $user_agent ) )
			$user = "PC";

		if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|kyocera|handspring|android|android webkit browser|blackberry|blazer|bolt|browser for s60|doris|dorothy|fennec|go browser|ie mobile|iris|maemo browser|mib|minimo|netfront|opera mini|opera mobile|semc-browser|skyfire|teashark|teleca-obigo|uzard web|epoc|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|mobile|pda;|avantgo|eudoraweb|minimo|smartphone|netfront|motorola|mmp|opwv|playstation portable|brew|teleca|lg;|lge |wap;| wap|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) )
			$user = "MOBILE";
			
		if ( preg_match ( "/rambler|008|abachobot|accoona-ai-agent|addsugarspiderbot|anyapexbot|arachmo|b-l-i-t-z-b-o-t|baiduspider|becomebot|beslistbot|billybobbot|bimbot|bingbot|blitzbot|boitho.com-dc|boitho.com-robot|btbot|catchbot|cerberian drtrs|charlotte|converacrawler|cosmos|covario ids|dataparksearch|diamondbot|discobot|dotbot|earthcom.info|emeraldshield.com webbot|envolk[its]spider|esperanzabot|exabot|fast enterprise crawler|fast-webcrawler|fdse robot|findlinks|furlbot|fyberspider|g2crawler|gaisbot|galaxybot|geniebot|gigabot|girafabot|googlebot|googlebot-image|gurujibot|happyfunbot|hl_ftien_spider|holmes|htdig|iaskspider|ia_archiver|iccrawler|ichiro|igdespyder|irlbot|issuecrawler|jaxified bot|jyxobot|koepabot|l.webis|lapozzbot|larbin|ldspider|lexxebot|linguee bot|linkwalker|lmspider|lwp-trivial|mabontland|magpie-crawler|mediapartners-google|mj12bot|mlbot|mnogosearch|mogimogi|mojeekbot|moreoverbot|morning paper|msnbot|msrbot|mvaclient|mxbot|netresearchserver|netseer crawler|newsgator|ng-search|nicebot|noxtrumbot|nusearch spider|nutchcvs|nymesis|obot|oegp|omgilibot|omniexplorer_bot|oozbot|orbiter|pagebiteshyperbot|peew|polybot|pompos|postpost|psbot|pycurl|qseero|radian6|rampybot|rufusbot|sandcrawler|sbider|scoutjet|scrubby|searchsight|seekbot|semanticdiscovery|sensis web crawler|seochat::bot|seznambot|shim-crawler|shopwiki|shoula robot|silk|sitebot|snappy|sogou spider|sosospider|speedy spider|sqworm|stackrambler|suggybot|surveybot|synoobot|teoma|terrawizbot|thesubot|thumbnail.cz robot|tineye|truwogps|turnitinbot|tweetedtimes bot|twengabot|updated|urlfilebot|vagabondo|voilabot|vortex|voyager|vyu2|webcollage|websquash.com|wf84|wofindeich robot|womlpefactory|xaldon_webspider|yacy|yahoo! slurp|yahoo! slurp china|yahooseeker|yahooseeker-testing|yandexbot|yandeximages|yandexmetrika|yasaklibot|yeti|yodaobot|yooglifetchagent|youdaobot|zao|zealbot|zspider|zyborg|yahoo|abachobot|accoona|aciorobot|aspseek|cococrawler|dumbot|geonabot|lycos|scooter|altavista|idbot|estyle|adsbot|yahoobot|watchmouse|pingdom\.com/", $user_agent ) ) 
			$user = "WEBBOT";
			
		if ( preg_match ( "/abilogicbot|link valet|link validity check|linkexaminer|linksmanager.com_bot|mojoo robot|notifixious|online link validator|ploetz + zeller|reciprocal link system pro|rel link checker lite|sitebar|vivante link checker|w3c-checklink|xenu link sleuth/", $user_agent ) )
			$user = "LINKBOT";
		
		if ( preg_match ( "/awasu|bloglines|everyfeed-spider|feedfetcher-google|greatnews|gregarius|magpierss|nfreader|universalfeedparser/", $user_agent ) )
			$user = "FEEDBOT";
		
		return $user;
	}
	
	public function ipCheck()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) // IP from Share Internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) // Whether IP is Pass from Proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		
		if($ip="::1")
			$ip="127.0.0.1";
		
		return $ip;
	}
	
	public function hostCheck()
	{
		$ip = $this->ipCheck();
		$host = gethostbyaddr($ip);
		
		return $host;
	}
	
	public function safeDownload($fileLink, $downloadAs)
	{
		$path = $fileLink;

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=" . $downloadAs);
		header( "Content-Description: File Transfer");
		header ("Content-type: octet/stream"); 
		@readfile($path);
	}
	
	public function paginatorJScript()
	{
		echo '
		<!-- ++++++++++ PAGINATION / SCRIPT 1 ++++++++++ -->
		<script type="text/javascript">
		function paginatorFunction(handlerNF, controllerNF, pointerNF, intervalNF, valueNF1, valueNF2, valueNF3, valueNF4, valueNF5, valueNF6)
		{
			if (controllerNF=="")
			{
				document.getElementById("paginatedTable").innerHTML="No Data Found!";
				return;
			}
			if (window.XMLHttpRequest)
			{
				// Code for IE7+, Firefox, Chrome, Opera, Safari //
				xmlhttp=new XMLHttpRequest();
			}
			else
			{
				// Code for IE6, IE5 //
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("paginatedTable").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("POST", handlerNF+"?controllerNF="+controllerNF+"&pointerNF="+pointerNF+"&intervalNF="+intervalNF+"&valueNF1="+valueNF1+"&valueNF2="+valueNF2+"&valueNF3="+valueNF3+"&valueNF4="+valueNF4+"&valueNF5="+valueNF5+"&valueNF6="+valueNF6, true);
			xmlhttp.send();
		}
		</script>
		<!-- ++++++++++ PAGINATION / SCRIPT 1 ++++++++++ -->
		';
	}
	
	public function paginatorPScript($handlerNF, $controllerNF, $intervalNF, $valueNF1=0, $valueNF2=0, $valueNF3=0, $valueNF4=0, $valueNF5=0, $valueNF6=0)
	{
		echo "<!-- ++++++++++ PAGINATION / SCRIPT 2 ++++++++++ -->";
		
		if($controllerNF > 0)
			echo "Pages: ";
		
		for($pointerNF=0, $jNF=1; $pointerNF < $controllerNF ; $pointerNF=$pointerNF+$intervalNF, $jNF++)
		{
			echo "<a style=\"font-family:Verdana;background-color:#888888;color:#fff;border-radius:25px;cursor:pointer;\" href=\"#\" onClick=\"paginatorFunction('$handlerNF', '$controllerNF','$pointerNF', '$intervalNF', '$valueNF1', '$valueNF2', '$valueNF3', '$valueNF4', '$valueNF5', '$valueNF6')\">&nbsp; $jNF &nbsp;</a> ";
		}
		
		echo '<div id="paginatedTable"><b>Please wait... Loading...</b></div>';

		echo "
			<script type='text/javascript'>
				paginatorFunction('$handlerNF', '$controllerNF', 0, '$intervalNF', '$valueNF1', '$valueNF2', '$valueNF3', '$valueNF4', '$valueNF5', '$valueNF6');
			</script>
		";
		
		echo "<!-- ++++++++++ PAGINATION / SCRIPT 2 ++++++++++ -->";
	}
	
	public function excelLibrary()
	{
		require_once("novaLibrary/phpExcel/Classes/PHPExcel.php");
		ini_set("memory_limit", "10000M");
		@$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_discISAM;
		@$cacheSettings = array('dir'  => 'download/xls-tmp');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		@$_SESSION['objPHPExcel'] = new PHPExcel();
		@$_SESSION['objPHPExcel'] ->getActiveSheet()->setTitle('Data');
	}
	
	public function excelExport($indexArray, $dataArray, $fileName)
	{
		/** ASSIGNING INDEX **/
		foreach($indexArray as $indexId=>$indexName)
			$_SESSION['objPHPExcel']->getActiveSheet()->setCellValue($indexId, $indexName);
		
		/** ASSIGNING VALUE **/
		$rowNumber = 2; // START FROM ROW 1
		foreach($dataArray as $excelEachRow)
		{
			$colName = 'A'; // START FROM A
			foreach($excelEachRow as $excelCell) 
			{
				$_SESSION['objPHPExcel']->getActiveSheet()->setCellValue($colName.$rowNumber ,$excelCell);
				$colName++;
			}
			$rowNumber++;	
		}
		
		/** CREATE THE EXCEL FILE HERE **/

		# DEFAULT CONFIGURATION OF EXCEL FILE
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
		# DEFINE THE FILE'S NAME # YOU HAVE TO SET YOUR FILE NAME HERE DYNAMICALLY
		header("Content-Disposition: attachment;filename='$fileName'");
		header('Cache-Control: max-age=0');
		
		# CREATE EXCEL FILE HERE
		$objWriter = PHPExcel_IOFactory::createWriter($_SESSION['objPHPExcel'], 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}
	
	public function pageUrl()
	{
		
		
		
		$thePath = explode("/", $_SERVER['SCRIPT_NAME'] );
		$thePage = array_reverse($thePath);
		$thePage = $thePage[0];
	
		return $thePage;
	}
	
	public function baseUrl()
	{
		
		$thePath = explode("/", $_SERVER['REQUEST_URI'] );
		$thePage = array_reverse($thePath);
		$thePage = $thePage[0];
		
		return $thePage;
	}
	
}