<?php
session_start();
include("Components/ApiCall.php");
include("Components/OrderResponse.php");
include("template.php");

$_SESSION['access_token'] = "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJYUWp2dGk4aDNQZEpJUXlGMVI5OWFBWGtEWjV6bHFTWGdUTFMwNG02bzc4In0.eyJleHAiOjE2NTUzMDU4NjMsImlhdCI6MTY1NTMwMjI2MywianRpIjoiMTk5ZjhhYWItMzRhNC00M2FhLTkyN2QtNjQxMTBjNzY2MDQxIiwiaXNzIjoiaHR0cHM6Ly9pZC1kZXYuZWFzcHJvamVjdC5jb20vYXV0aC9yZWFsbXMvbWFzdGVyIiwiYXVkIjoiYWNjb3VudCIsInN1YiI6IjJjZWU3MTg4LThlY2EtNDEyZC1hZTNlLWM1NWFkNzQzMzU4MSIsInR5cCI6IkJlYXJlciIsImF6cCI6IlsxMjMyMTNdLTFiMWUyYWE4ZmI1MGU0M2RkMjA0MjlhZmRiYmVjMWI4MWIxNTM4NTMiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbImh0dHBzOi8vaW5mb0BlYXNwcm9qZWN0LmNvbSJdLCJyZWFsbV9hY2Nlc3MiOnsicm9sZXMiOlsib2ZmbGluZV9hY2Nlc3MiLCJ1bWFfYXV0aG9yaXphdGlvbiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7IlsxMjMyMTNdLTFiMWUyYWE4ZmI1MGU0M2RkMjA0MjlhZmRiYmVjMWI4MWIxNTM4NTMiOnsicm9sZXMiOlsidW1hX3Byb3RlY3Rpb24iXX0sImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwiY2xpZW50SG9zdCI6IjEwLjMyLjAuNTYiLCJjbGllbnRJZCI6IlsxMjMyMTNdLTFiMWUyYWE4ZmI1MGU0M2RkMjA0MjlhZmRiYmVjMWI4MWIxNTM4NTMiLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiJzZXJ2aWNlLWFjY291bnQtWzEyMzIxM10tMWIxZTJhYThmYjUwZTQzZGQyMDQyOWFmZGJiZWMxYjgxYjE1Mzg1MyIsImNsaWVudEFkZHJlc3MiOiIxMC4zMi4wLjU2In0.qiKSRlhOFvzeWLMYLiNAaJSfdcq4TWKYKc5uRYiTFcnNg5MxfOlIx9tfremmPa1NOAPFiwNoWd1nUUVN7qIfHIwLYU5re69ARaGx9MHheJPbY8FfHqxECNOdCR3wYd-t6Up-Fxx21uQShMkoK6r8ntl2Ilye1B-GK7gWL7MrvYDwEI6q2Wa1jHaqF10bWqsFR0cBGHn8mhwi_aXV5BYEZ1bThLTFz1HJs2CTonS7s3Dzi0j1JGBeKsHooKP3UGUtl8j14017Ucsgejd9fd9aIapS4pvor1NJ_fPhr9AgYXDgWXbM8pk4YbhkXBGylvwWwtpEzjkwy1Ie0PhVwCLMqA";
    $curlUrl = ApiCall::BASEURL . "mass-sale/get_mass_post_sale_order_status/1174";//.$_SESSION['job_id'];
$mass_sale_curl = new ApiCall($curlUrl, $method = "GET", null, $_SESSION['access_token']);
$result = $mass_sale_curl->createCurlRequest();

?>


<body>

  <table class="table table-hover table-dark table-striped">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">External order id</th>
      <th scope="col">Status</th>
      <th scope="col">Error/Message</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $count = 1;
    if (array_key_exists('order_response_list', $result)) :

      foreach ($result['order_response_list'] as $external_order) :
        ?>

        <tr>
          <td scope="row"><?= $count++; ?></td>
          <td><?= $external_order['external_order_id']; ?></td>
          <td><?= $external_order['status']; ?></td>
          <td><?= wordwrap($external_order['error']['message'], 30); ?></td>
        </tr>

       <?php endforeach; endif; ?>

    </tbody>
  </table>

<h2>Detailed table</h2>
    <table class="table table-hover table-dark table-striped table-bordered">
      <thead>
      <tr>
        <th scope="col" colspan="9" class="center">Order information</th>
        <th scope="col" colspan="6">Item Information Message</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th scope="col">external_id</th>
        <th scope="col">id</th>
        <th scope="col">total_order_amount</th>
        <th scope="col" class="b-r">taxes_and_duties</th>
        <th>merchandise_cost_vat_excl</th>
        <th>delivery_charge_vat_excl</th>
        <th>eas_fee</th>
        <th>delivery_country</th>
        <th>payment_currency</th>
        <th colspan="5"></th>

      </tr>


      <?php
      if(array_key_exists('order_response_list',$result)):
      foreach($result['order_response_list'] as $external_order):

      if (array_key_exists('checkout_token', $external_order)):
        $order_items_object = OrderResponseList::retrieveObjectFromToken($external_order['checkout_token']);
        $order_items = $order_items_object->items;
        $i = 0;
        ?>
        <tr>

          <td><?= $external_order['external_order_id']; ?></td>

          <td><?= $order_items_object->id; ?></td>
          <td><?= $order_items_object->total_order_amount; ?></td>
          <td><?= $order_items_object->taxes_and_duties; ?></td>
          <td><?= $order_items_object->merchandise_cost_vat_excl; ?></td>
          <td><?= $order_items_object->delivery_charge_vat_excl; ?></td>
          <td><?= $order_items_object->eas_fee; ?></td>
          <td><?= $order_items_object->delivery_country; ?></td>
          <td><?= $order_items_object->payment_currency; ?></td>

          <td>
            <table class="table-striped table-bordered">
              <?php if (!empty($order_items)): ?>
                <tr>
                  <th scope="col">item_id</th>
                  <th scope="col">quantity</th>
                  <th scope="col">unit_cost_excl_vat</th>
                  <th scope="col">item_duties_and_taxes</th>
                  <th scope="col">vat_rate</th>
                </tr>
                <?php foreach ($order_items as $item): ?>
                  <tr>
                    <td><?= $item->item_id; ?></td>
                    <td><?= $item->quantity; ?></td>
                    <td><?= $item->unit_cost_excl_vat; ?></td>
                    <td><?= $item->item_duties_and_taxes; ?></td>
                    <td><?= $item->vat_rate; ?></td>
                  </tr>
                <?php endforeach; endif;// $order_items
              ?>
            </table>
          </td>

        </tr>

      <?php endif; endforeach; endif;//$result['order_response_list'] ?>

      </tbody>
    </table>


</body>
