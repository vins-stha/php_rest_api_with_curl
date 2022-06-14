<?php

include("Components/ApiCall.php");
function apicall()
{

  $bearerToken = "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJYUWp2dGk4aDNQZEpJUXlGMVI5OWFBWGtEWjV6bHFTWGdUTFMwNG02bzc4In0.eyJleHAiOjE2NTUyMDM5NTksImlhdCI6MTY1NTIwMDM1OSwianRpIjoiNmVhMGNmOTgtN2RiYi00ZTQyLThhMmMtNjYwYjZhMTZhOTA3IiwiaXNzIjoiaHR0cHM6Ly9pZC1kZXYuZWFzcHJvamVjdC5jb20vYXV0aC9yZWFsbXMvbWFzdGVyIiwiYXVkIjoiYWNjb3VudCIsInN1YiI6IjJjZWU3MTg4LThlY2EtNDEyZC1hZTNlLWM1NWFkNzQzMzU4MSIsInR5cCI6IkJlYXJlciIsImF6cCI6IlsxMjMyMTNdLTFiMWUyYWE4ZmI1MGU0M2RkMjA0MjlhZmRiYmVjMWI4MWIxNTM4NTMiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbImh0dHBzOi8vaW5mb0BlYXNwcm9qZWN0LmNvbSJdLCJyZWFsbV9hY2Nlc3MiOnsicm9sZXMiOlsib2ZmbGluZV9hY2Nlc3MiLCJ1bWFfYXV0aG9yaXphdGlvbiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7IlsxMjMyMTNdLTFiMWUyYWE4ZmI1MGU0M2RkMjA0MjlhZmRiYmVjMWI4MWIxNTM4NTMiOnsicm9sZXMiOlsidW1hX3Byb3RlY3Rpb24iXX0sImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwiY2xpZW50SG9zdCI6IjEwLjMyLjAuNTYiLCJjbGllbnRJZCI6IlsxMjMyMTNdLTFiMWUyYWE4ZmI1MGU0M2RkMjA0MjlhZmRiYmVjMWI4MWIxNTM4NTMiLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiJzZXJ2aWNlLWFjY291bnQtWzEyMzIxM10tMWIxZTJhYThmYjUwZTQzZGQyMDQyOWFmZGJiZWMxYjgxYjE1Mzg1MyIsImNsaWVudEFkZHJlc3MiOiIxMC4zMi4wLjU2In0.KiwOWA0K0vqdIW-NFUbQamb0yZlLDSeAH_cJBiHbwiifI2zPvOe0hdglhaYEWF3Hpxb3qJykv30UhXWVMWp03MrVQZ2YLtkY5Y-JFLkgAszPqYSpCIwwfvqkmZtVRE5BqaFd5NAa1SCnSz_DU35MlKMC5adtYvFiMGLXHi_a8miNlRh0Fx_NMNfDc8r9zMNAqxCawKZQysYcmnG89rZMld7tF5FrxpvUz4RR1Xftp-8JnFwEYd0ipPRV-cj8y_BG8vCD8fzRYuJw9Yzvl_p3wvpChYz_uWflNZ-E7dJE_AMPJpxkp3nZ6Xc8AvqEBK7Cyb67gnucFaFWKdvKmAGsig";
  $url = "https://admin1.easproject.com/api/mass-sale/post_mass_sale_create_mass_post_sale_orders";
  $curl = curl_init();


  $tmpfile = $_FILES['name']['tmp_name'];
  $filename = basename($_FILES['name']['name']);
  $data = array(
      'uploaded_file' => curl_file_create($tmpfile, $_FILES['image']['type'], $filename)
  );

//var_dump($data);
  curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $data,
      CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer `$bearerToken`"
      ),
  ));



}


?>


<!DOCTYPE html>
<html>

<head>
</head>

<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $apiCall = new ApiCall(\ApiCall::authurl());

  $result = $apiCall->createCurlRequest();

  $apiCall->setCurlToken($result['access_token']);

  // send file to api

//  CURLOPT_POSTFIELDS => array('file'=> new CURLFILE('/C:/Users/Laptop/Downloads/js.JSON')),


  $data = array('file'=> new CURLFILE( $_FILES['name']['tmp_name']));
  var_dump( $data);

}


?>

<h2>PHP Form Example: GFG Review</h2>
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