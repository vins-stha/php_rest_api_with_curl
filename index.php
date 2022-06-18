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

  $accesstoken = ApiCall::generateCurlToken();
  $array = explode('.', $_FILES['file']['name']);
  $extension = end($array);

  try {
    if (isset($_FILES['file']['tmp_name'])
        && (filesize($_FILES['file']['tmp_name']) <= ApiCall::MAXUPLOAD)
        && (strcmp(strtolower($extension), 'json') == 0)
        && ($_FILES['file']['error'] === UPLOAD_ERR_OK)
    ) {

      $cfile = new CURLFile($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
      $data = array("file" => $cfile);

      $uploadUrl = ApiCall::BASEURL . "mass-sale/create_mass_post_sale_orders";

      $uploadCurl = new ApiCall($uploadUrl, $method = "POST", $data);

      $uploadCurl->setCurlToken($accesstoken);

      $result = $uploadCurl->createCURLRequest($accesstoken);

      if (is_array($result) && array_key_exists('code', $result)) {
        throw new RuntimeException($result['code'] . "! " . $result['message']);
      }

      if (!empty($result) && $result['job_id'] !== null)
        header("Location: /eas/results?job_id=" . $result['job_id']);

    } else {
      throw new RuntimeException('Invalid parameters. File type allowed: json');
    }
  } catch (RuntimeException $exception) {
    echo $exception->getMessage();
  }

}


?>
<script>
  localStorage.setItem('refreshed', false);
</script>
<h2>Upload JSON file to proceed</h2>
<form method="post" action=
"<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

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