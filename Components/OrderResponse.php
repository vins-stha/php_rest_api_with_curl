<?php


class OrderResponseList
{
 private $externalId;
 private $status;
 private  $error;
 private $checkout_token;

 public function __construct($externalId,$status,$error,$checkout_token)
 {
  $this->status = $status;
  $this->checkout_token = $checkout_token;
  $this->error = $error;
  $this->externalId = $externalId;

 }

 public static function retrieveObjectFromToken($token)
 {
//   var_dump($token);
   $object = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))));

   return $object;

 }
}