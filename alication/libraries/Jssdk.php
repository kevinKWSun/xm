<?php
class Jssdk {
  private $appId;
  private $appSecret;
  private $error;

  public function __construct($params) {
    $this->appId = $params['appId'];
    $this->appSecret = $params['appSecret'];
  }

  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();
	if($jsapiTicket === 0) {
		return 0;
	}
    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }
  public function getError() {
	  return $this->error;
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents("jsapi_ticket.json"));
    if (empty($data) || $data->expire_time < time()) {
      $accessToken = $this->getAccessToken();
	  if($accessToken === 0) {
		return 0;
	  }
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
	  if($res->errmsg != 'ok') {
		  $this->error = 'jsapi_ticket请求失败';
		  return 0;
	  }
      $ticket = $res->ticket;
      if ($ticket) {
        $data->expire_time = time() + 7000;
        $data->jsapi_ticket = $ticket;
        $fp = fopen("jsapi_ticket.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    } else {
      $ticket = $data->jsapi_ticket;
    }
    return $ticket;
  }

  private function getAccessToken() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents("access_token.json"));
    if (empty($data) || $data->expire_time < time()) {
      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      $res = json_decode($this->httpGet($url));
	  if(isset($res->errcode)) {
		  $this->error = 'access_token请求失败';
		  return 0;
	  }
      $access_token = $res->access_token;
      if ($access_token) {
        $data->expire_time = time() + 7000;
        $data->access_token = $access_token;
        $fp = fopen("access_token.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    } else {
      $access_token = $data->access_token;
    }
    return $access_token;
  }

  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }
  public function getImg($params) {
	
	if(!isset($params['media_id']) || !isset($params['foldername'])) {
		$this->error = '图片参数列表错误';
		return 0;
	}
	$accessToken = $this->getAccessToken();
	if($accessToken === 0) {
		return 0;
	}
	
	$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$accessToken."&media_id=".$params['media_id'];
	if (!file_exists($params['foldername'])) {
		mkdir($params['foldername'], 0777, true);
	}
	
	$randNum = rand(1000,9999);
	$timeStr = date('YmdHis');
	$targetName = $params['foldername'].'/'.$timeStr.$randNum.'.jpg';
	
	$ret = $this->httpGetImg($url, $targetName);
	return empty($ret) ? 0 : $ret;
  }
  private function httpGetImg($url, $targetName) {
	$ch = curl_init($url); // 初始化
	$fp = fopen($targetName, 'wb'); // 打开写入
	curl_setopt($ch, CURLOPT_FILE, $fp); // 设置输出文件的位置，值是一个资源类型
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
	return $targetName;
  }
  //推送消息
  public function sendM($openid,$con){
	$template = array(
		'touser' => $openid,
		'msgtype' => 'text',
		'text' => array(
			'content' => $con
		)
	);
	$json_template = '{"touser":"'.$openid.'","msgtype":"text","text":{"content":"'.$con.'"}}';
	$accessToken = $this->getAccessToken();
	$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $accessToken;
	$dataRes = $this->request_post($url, urldecode($json_template));
	/* if ($dataRes['errcode'] == 0) {
		return true;
	} else {
		return false;
	} */
  }
  //签到管理
  public function signSend($openid, $username, $time, $string, $url) {
	  $template = array(
		'touser' => $openid,
		'template_id' => 'RlVNygb4IAa4MUSxKvXLuVmtN_gbTGv73H4JbV9o9X8',
		"url"=> $url,
		"topcolor"=> "#FF0000",
		'data' => array(
			'first' => ["value" => $string."管理：".$username."已操作","color" => "#0065b3"],
			'keyword1' => ["value" => $username,"color" => "#0065b3"],
			'keyword2' => ["value" => "打卡签到","color" => "#0065b3"],
			'keyword3' => ["value" => $time,"color" => "#0065b3"],
			'remark' => ["value" => "\n点击详情进入操作","color" => "#0065b3"],
		)
	  ); 
	  $this->sendMB($template);
  }
  //死亡处理结果
  public function signSends($openid, $username, $time, $string, $url) {
	  $template = array(
		'touser' => $openid,
		'template_id' => 'kfZUlSKekJVJQPVQLmvMZ-EpvlgcIFPzCRPvw1VMwDw',
		"url"=> $url,
		"topcolor"=> "#FF0000",
		'data' => array(
			'first' => ["value" => $string."管理：".$username."已操作","color" => "#0065b3"],
			'keyword1' => ["value" => $username,"color" => "#0065b3"],
			'keyword2' => ["value" => "打卡签到","color" => "#0065b3"],
			'keyword3' => ["value" => $time,"color" => "#0065b3"],
			'remark' => ["value" => "\n点击详情进入操作","color" => "#0065b3"],
		)
	  ); 
	  $this->sendMB($template);
  }
  private function sendMB($template){
	$json_template = json_encode($template,JSON_UNESCAPED_UNICODE);
	
	$accessToken = $this->getAccessToken();
	if(!$accessToken) {
		$this->error = '不能获取accessToken';
		return false;
	}
	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $accessToken;
	$dataRes = $this->request_post($url, urldecode($json_template));
	// if($dataRes) {
		// $this->error = $dataRes;
		// return false;
	// }
  }
  /**
	* 发送post请求
	* @param string $url
	* @param string $param
	* @return bool|mixed
	*/
  private function request_post($url = '', $param = ''){
	if (empty($url) || empty($param)) {
		return false;
	}
	$postUrl = $url;
	$curlPost = $param;
	$ch = curl_init(); //初始化curl
	curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
	curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
	curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
	$data = curl_exec($ch); //运行curl
	curl_close($ch);
	return $data;
  }
}