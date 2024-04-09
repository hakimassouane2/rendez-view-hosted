<?php

namespace WooModern\OvaemCptWoo\Modal;

use WC_Order_Item_Product;

class CPTOrderItemProduct extends WC_Order_Item_Product {
	/**
	 * Set Product ID
	 *
	 * @param int $value Product ID.
	 */
	public function set_product_id( $value ) {
		$this->set_prop( 'product_id', absint( $value ) );
	}
}
