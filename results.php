<?php
session_start();
include("Components/ApiCall.php");
include("Components/OrderResponse.php");
include("template.php");

$_SESSION['access_token'] = "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJYUWp2dGk4aDNQZEpJUXlGMVI5OWFBWGtEWjV6bHFTWGdUTFMwNG02bzc4In0.eyJleHAiOjE2NTUyOTgxMjksImlhdCI6MTY1NTI5NDUyOSwianRpIjoiN2QyZTNiZTgtYWQxMS00NTgyLTg1Y2MtMDUwMDI1N2JmM2VmIiwiaXNzIjoiaHR0cHM6Ly9pZC1kZXYuZWFzcHJvamVjdC5jb20vYXV0aC9yZWFsbXMvbWFzdGVyIiwiYXVkIjoiYWNjb3VudCIsInN1YiI6IjJjZWU3MTg4LThlY2EtNDEyZC1hZTNlLWM1NWFkNzQzMzU4MSIsInR5cCI6IkJlYXJlciIsImF6cCI6IlsxMjMyMTNdLTFiMWUyYWE4ZmI1MGU0M2RkMjA0MjlhZmRiYmVjMWI4MWIxNTM4NTMiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbImh0dHBzOi8vaW5mb0BlYXNwcm9qZWN0LmNvbSJdLCJyZWFsbV9hY2Nlc3MiOnsicm9sZXMiOlsib2ZmbGluZV9hY2Nlc3MiLCJ1bWFfYXV0aG9yaXphdGlvbiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7IlsxMjMyMTNdLTFiMWUyYWE4ZmI1MGU0M2RkMjA0MjlhZmRiYmVjMWI4MWIxNTM4NTMiOnsicm9sZXMiOlsidW1hX3Byb3RlY3Rpb24iXX0sImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwiY2xpZW50SG9zdCI6IjEwLjQwLjAuNDYiLCJjbGllbnRJZCI6IlsxMjMyMTNdLTFiMWUyYWE4ZmI1MGU0M2RkMjA0MjlhZmRiYmVjMWI4MWIxNTM4NTMiLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiJzZXJ2aWNlLWFjY291bnQtWzEyMzIxM10tMWIxZTJhYThmYjUwZTQzZGQyMDQyOWFmZGJiZWMxYjgxYjE1Mzg1MyIsImNsaWVudEFkZHJlc3MiOiIxMC40MC4wLjQ2In0.dC8hvH1Spu8LC1dkzFUiPakCjtRcLyeUGwqQ0RQY1pfO2RSRIirAFZM92D4L6iXKJJ-BI8rQN1IOLU0jhErxglz3C2I7dzd0qA-wycgy2UUG4uNK-v4t6vr71h94zJ7cpIfO63l6e-f6kFnciPHhsUeXA8nf4e7wAJJHUF162SAPt91lpGQCsfoZ-8MVGu_uhfxHhUiQ6cPJw0qiQoNCjZFc2NvoWMiCCgHljygXFOm2BgLZ3g06ywgnvQ84H6b3VpFYJgLkS3As9XD_qxCav7rEBxeSq4HYT8AozCsnL-43XG6_C3qrD6xix8VkHUaR-iEAS7LP2phIz4RSKWXxtw";
    $curlUrl = ApiCall::BASEURL . "mass-sale/get_mass_post_sale_order_status/1174";//.$_SESSION['job_id'];
$mass_sale_curl = new ApiCall($curlUrl, $method = "GET", null, $_SESSION['access_token']);
$result = $mass_sale_curl->createCurlRequest();

?>


<body>


<div class="">
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

        <?php

        if (array_key_exists('checkout_token', $external_order)):
          $order_items_object = OrderResponseList::retrieveObjectFromToken($external_order['checkout_token']);

          $order_items = $order_items_object->items;
          $i = 0;
          ?>
          <div class="">

            <table class="table table-bordered table-dark">
              <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col" colspan="8" class="b-r">Order Information</th>
                <th scope="col" colspan="5">Item information</th>

              </tr>
              </thead>
              <tbody>
              <tr>
                <td></td>
                <th scope="col">id</th>
                <th scope="col">total_order_amount</th>
                <th scope="col" class="b-r">taxes_and_duties</th>
                <th>merchandise_cost_vat_excl</th>
                <th>delivery_charge_vat_excl</th>
                <th>eas_fee</th>
                <th>delivery_country</th>
                <th>payment_currency</th>
                <th colspan="5">


                  <?php if (!empty($order_items_object->items)): ?>
                  <table class="table table-bordered table-dark table-striped">
                    <thead>
                    <th scope="col">item_id</th>
                    <th scope="col">quantity</th>
                    <th scope="col">unit_cost_excl_vat</th>
                    <th scope="col">item_duties_and_taxes</th>
                    <th scope="col">vat_rate</th>
                    </thead>


                    <?php endif; ?>
                  </table>
                </th>

              </tr>

              <tr>
                <td><?= ++$i; ?></td>
                <td><?= $order_items_object->id; ?></td>
                <td><?= $order_items_object->total_order_amount; ?></td>
                <td><?= $order_items_object->taxes_and_duties; ?></td>
                <td><?= $order_items_object->merchandise_cost_vat_excl; ?></td>
                <td><?= $order_items_object->delivery_charge_vat_excl; ?></td>
                <td><?= $order_items_object->eas_fee; ?></td>
                <td><?= $order_items_object->delivery_country; ?></td>
                <td><?= $order_items_object->payment_currency; ?></td>

                <td>
                  <table class="table table-bordered table-dark table-striped">

                    <?php if (!empty($order_items_object->items)): ?>

                      <?php
                      $items = $order_items_object->items;
                      foreach ($items as $item):
                        ?>
                        <tr>
                          <td><?= $item->item_id; ?></td>
                          <td><?= $item->quantity; ?></td>
                          <td><?= $item->unit_cost_excl_vat; ?></td>
                          <td><?= $item->item_duties_and_taxes; ?></td>
                          <td><?= $item->vat_rate; ?></td>

                        </tr>

                      <?php endforeach; endif; ?>
                  </table>
                </td>

              </tr>


              </tbody>
            </table>

          </div>

        <?php endif; ?>

      <?php endforeach; //$result['order_response_list']
      ?>

    <?php endif; ?>
    </tbody>
  </table>


</div>
</body>

