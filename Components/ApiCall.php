<?php


class ApiCall
{
   const  BASEURL="http://internal1.easproject.com/api/";
  const AUTHURL= "https://internal1.easproject.com/api/auth/open-id/connect?client_id=%5B123213%5D-1b1e2aa8fb50e43dd20429afdbbec1b81b153853&client_secret=bc921891ad907d3ba443ad707962ab140295&grant_type=client_credentials";

  // url to be called for
  private $curlURL;
  // data to be sent
  private $curlData;
  // get or post
  private $curlMethod;
  // bearer token
  private $curlToken;

  private $curl;

  function __construct($curlURL, $curlMethod="POST", $curlData="", $curlToken="")
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

  public static function authurl() {
    return self::AUTHURL;
  }

  public static function baseurl() {
    return self::BASEURL;
  }
  public function createCURLRequest()
  {
    $curl = $this->curl;
    curl_setopt_array($curl, array(
        CURLOPT_URL => $this->curlURL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $this->curlMethod,
        CURLOPT_POSTFIELDS => $this->curlData,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer `$this->curlToken`"
        ),
    ));
    $response = curl_exec($curl);

    $error = curl_error($curl);
    curl_close($curl);

    if($error) {
      echo "cURL Error:" . $error;
    }
    return json_decode($response, true);
  }

}