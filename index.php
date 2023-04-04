<?php
/**
* Dasturchi: Sattorbek Sag`dulayyev.
* Manbaalar mavjud.
* Mualliflik huquqi mavjud emas.
**/

ob_start();
error_reporting(0);
date_default_timezone_set("Asia/Tashkent");
header("Content-Type: application/json; charset=UTF-8");

$link = $_GET['url'];
$headers = array();
$headers[] = 'origin: https://videodownloaderpro.net';
$headers[]  = 'referer: https://videodownloaderpro.net/';
$headers[]  = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36'; 
$curl = curl_init();
$config = array(
CURLOPT_URL => "https://api.videodownloaderpro.net/api/convert",
CURLOPT_POST => true,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_HTTPHEADER => $headers,
CURLOPT_POSTFIELDS => array('url'=>$link));
curl_setopt_array($curl, $config);
$response = curl_exec($curl);
curl_close($curl);
$json = json_decode($response, true);

if(!empty($_GET['url']) && mb_stripos($_GET['url'], "instagram")!==false) {
if(!empty($json[0])) {
for($i = 0; $i <= count($json)-1; $i++) {
$arrays["meta"]["title"] = $json[0]['meta']['title'];
$arrays["meta"]["source"] = $json[0]['meta']['source'];
if($json[$i]['url'][0]['type'] == "mp4") {
	$json[$i]['url'][0]['type'] = "video";
}else{
	$json[$i]['url'][0]['type'] = "photo";
}
$arrays["results"][] = ["url"=> $json[$i]['url'][0]['url'], "type"=> $json[$i]['url'][0]['type'], "thumbnail"=> $json[$i]['thumb']];
}
echo json_encode($arrays,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}elseif($json['url'][0]['url']) {
$arrays["meta"]["title"] = $json['meta']['title'];
$arrays["meta"]["source"] = $json['meta']['source'];
if($json[$i]['url'][0]['type'] == "mp4") {
	$json['url'][0]['type'] = "video";
}else{
	$json['url'][0]['type'] = "photo";
}
$arrays["results"][] = ["url"=> $json['url'][0]['url'], "type"=> $json['url'][0]['type'], "thumbnail"=> $json['thumb']];
echo json_encode($arrays,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}else{

	echo json_encode(array("error"=> "Media'ni yuklab bo'lmadi. Telegram: t.me/sol1khman"));
}
}else{
	echo json_encode(array("error"=> "Media'ni yuklab bo'lmadi. Telegram: t.me/sol1khman"));
}
?>
