<?php

namespace WooModern\OvaemCptWoo\Modal;

use WooModern\OvaemCptWoo\Traits\CptProductDataStoreReadTrait;
use WC_Product_Data_Store_CPT;

class CPTProductDataStore extends WC_Product_Data_Store_CPT {
	/**
	 * Method to read a product from the database.
	 * @param WC_Product
	 */
	use CptProductDataStoreReadTrait;

}