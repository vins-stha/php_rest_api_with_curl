<?php


class ApiCall
{
  const  BASEURL = "http://internal1.easproject.com/api/";
  const AUTHURL = "https://internal1.easproject.com/api/auth/open-id/connect?client_id=%5B123213%5D-1b1e2aa8fb50e43dd20429afdbbec1b81b153853&client_secret=bc921891ad907d3ba443ad707962ab140295&grant_type=client_credentials";
  const MAXUPLOAD= 52428800;
  // url to be called for
  private $curlURL = "";
  // data to be sent
  private $curlData = "";
  // get or post
  private $curlMethod = "";
  // bearer token
  private $curlToken = "";

  private $curl;

  function __construct($curlURL, $curlMethod, $curlData, $curlToken)
  {
    $this->curlData = $curlData;
    $this->curlMethod = $curlMethod;
    $this->curlToken = $curlToken;
    $this->curlURL = $curlURL;
    $this->curl = curl_init();
  }

  /**
   * @return mixed
   */
  public function getCurlURL()
  {
    return $this->curlURL;
  }

  /**
   * @param mixed $curlURL
   */
  public function setCurlURL($curlURL)
  {
    $this->curlURL = $curlURL;
  }

  /**
   * @return mixed
   */
  public function getCurlData()
  {
    return $this->curlData;
  }

  /**
   * @param mixed $curlData
   */
  public function setCurlData($curlData)
  {
    $this->curlData = $curlData;
  }

  /**
   * @return mixed
   */
  public function getCurlMethod()
  {
    return $this->curlMethod;
  }

  /**
   * @param mixed $curlMethod
   */
  public function setCurlMethod($curlMethod)
  {
    $this->curlMethod = $curlMethod;
  }

  /**
   * @return mixed
   */
  public function getCurlToken()
  {
    return $this->curlToken;
  }

  /**
   * @param mixed $curlToken
   */
  public function setCurlToken($curlToken)
  {
    $this->curlToken = $curlToken;
  }

  public static function authurl()
  {
    return self::AUTHURL;
  }

  public static function baseurl()
  {
    return self::BASEURL;
  }

  public function createCURLRequest()
  {
    $curl = $this->curl;
    $headers = array(
        'Content-Type: multipart/form-data',
        "Authorization: Bearer $this->curlToken",
        "Accept: application/json"
    );
    curl_setopt($curl, CURLOPT_URL, $this->curlURL);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $this->curlData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->curlMethod);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


    $response = curl_exec($curl);

    $error = curl_error($curl);
    curl_close($this->curl);

    if ($error) {
      echo "cURL Error:" . $error;
    }
    return (json_decode($response, true));
  }

  public static function generateCurlToken(){
    $apiCall = new ApiCall(self::authurl(), $method = "POST", null, null);

    $result = $apiCall->createCurlRequest();

    $accesstoken = trim($result['access_token']);

    return $accesstoken;

  }

  public static function isJobPending($result){
    $str = "Cannot return order response list, Mass post sale job: " . $result['job_id'] . " is still pending.";

    return (array_key_exists('message', $result) && (strcmp($result['message'], $str) == 0)) ? true : false;
  }

}