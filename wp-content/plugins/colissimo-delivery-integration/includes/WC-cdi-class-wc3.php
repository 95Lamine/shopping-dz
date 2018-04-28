<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class cdiwc3 {

  // ************* order **************

  public static function cdi_order_id ($order) {
    if (method_exists($order, 'get_id')) {
      $id = $order->get_id();
    }else{
      $id = $order->id;
    }
    return $id;
  }

  public static function cdi_order_status ($order) {
    if (method_exists($order, 'get_status')) {
      $status = $order->get_status();
    }else{
      $status = $order->status;
    }
    return $status;
  }

  public static function cdi_order_date_created ($order) {
    if (method_exists($order, 'get_date_created')) {
      $date = $order->get_date_created();
    }else{
      $date = $order->order_date;
    }
    return $date;
  }

  // ************* product **************

  public static function cdi_product_id ($product) {
    if (method_exists( $product, 'get_id' )) {
      $id = $product->get_id();
    }else{
      $id = $product->id;
    }
    return $id;
  }

}
