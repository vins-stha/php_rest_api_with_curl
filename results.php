<?php
session_start();
include("Components/ApiCall.php");
include("Components/OrderResponse.php");
include("template.php");

$curlUrl = ApiCall::BASEURL . "mass-sale/get_mass_post_sale_order_status/".$_SESSION['job_id'];
$mass_sale_curl = new ApiCall($curlUrl, $method = "GET", null, $_SESSION['access_token']);
$result = $mass_sale_curl->createCurlRequest();
?>
<script>
  window.onload = function () {

    if (localStorage.getItem('refreshed') == "false" ) {

      localStorage.setItem('refreshed', true);
      window.location=window.location.href
      window.location=window.location.href

    }
  }

</script>

<body>
<h2>ORDER table</h2>
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
