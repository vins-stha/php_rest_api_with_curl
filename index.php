<?php
session_start();
include("Components/ApiCall.php");
?>


<!DOCTYPE html>
<html>

<head>
</head>

<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

  $apiCall = new ApiCall(\ApiCall::authurl(), $method = "POST", null, null);

  $result = $apiCall->createCurlRequest();

  $accesstoken = trim($result['access_token']);

  if (isset($_FILES['file']['tmp_name']) && (filesize($_FILES['file']['tmp_name']) <= ApiCall::MAXUPLOAD) ) {


    $cfile = new CURLFile($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
    $data = array("file" => $cfile);

    $uploadUrl = ApiCall::BASEURL . "mass-sale/create_mass_post_sale_orders";

    $uploadCurl = new ApiCall($uploadUrl, $method = "POST", $data, $accesstoken);

    $uploadCurl->setCurlToken($accesstoken);

    $result = $uploadCurl->createCURLRequest();

    $curlUrl = ApiCall::BASEURL . "mass-sale/get_mass_post_sale_order_status/".$result['job_id'];
    $mass_sale_curl = new ApiCall($curlUrl, $method = "GET", null, $_SESSION['access_token']);
    $result = $mass_sale_curl->createCurlRequest();

    $str = "Cannot return order response list, Mass post sale job: ".$result['job_id']. " is still pending.";

    while (strcmp($result['message'], $str) == 0)
    {
      $mass_sale_curl = new ApiCall($curlUrl, $method = "GET", null, $_SESSION['access_token']);
      $result = $mass_sale_curl->createCurlRequest();
    }
    $_SESSION['access_token'] = $accesstoken;
    $_SESSION['job_id'] = $result['job_id'];
    $_SESSION['order_data'] = $result;

    if (!empty($result) && $result['job_id'] !== null)
      header("Location: /eas/results.php");
  }

}


?>
<script>
  localStorage.setItem('refreshed', false);
</script>
<h2>Upload JSON file to proceed</h2>
<form method="post" action=
"<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
  Name:
  <input type="text" name="name"/>
  <br>
  <br>
  JSON:
  <input type="file" name="file">
  <br>
  <br>
  <input type="submit" name="submit"
         value="Submit">
</form>

</body>

</html>