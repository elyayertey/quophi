<?php
header('Content-Type: application/json');

require 'product.class.php';

$product = new product;
$err = array();
$error = 0;

if (isset($_POST['submit']) && ($_POST['action'] == 'add_product')) {

	if (isset($_POST['name']) && !empty($_POST['name'])) {
		$product->set_name($_POST['name']);
	} else {
		$error = 1;
		$err[] = "Please provide the product name";
	}

	if (isset($_POST['description']) && !empty($_POST['description'])) {
		$product->set_description($_POST['description']);
	} else {
		$error = 1;
		$err[] = "Please provide the product description";
		exit;
	}

	if (isset($_POST['price']) && !empty($_POST['price'])) {
		$product->set_price($_POST['price']);
	} else {
		$error = 1;
		$err[] = "Please provide the product price";
		exit;
	}

	if (isset($_POST['availability']) && !empty($_POST['availability'])) {
		$product->set_availability($_POST['availability']);
	} else {
		$error = 1;
		$err[] = "Please provide the product availability";
		exit;
	}

	if (isset($_POST['quantity']) && !empty($_POST['quantity'])) {
		$product->set_quantity($_POST['quantity']);
	} else {
		$error = 1;
		$err[] = "Please provide the product quantity";
		exit;
	}

	if (isset($_POST['requiredToShip']) && !empty($_POST['requiredToShip'])) {
		$product->set_requiredToShip($_POST['requiredToShip']);
	} else {
		$error = 1;
		$err[] = "Please provide the minimum order required to process shipment";
		exit;
	}

	if (isset($_POST['promo_ends']) && !empty($_POST['promo_ends'])) {
		$product->set_promo_ends($_POST['promo_ends']);
	} else {
		$error = 1;
		$err[] = "Please provide the promo end date";
		exit;
	}

	if ($error === 1) {

		$this->toJson('error', $err);

	} else {

		$product->addProduct();

	}

}

if (isset($_POST['submit']) && ($_POST['action'] == 'delete_product')) {

	if (isset($_POST['id']) && !empty($_POST['id'])) {
		$product->set_id($_POST['id']);
		$product->deleteProduct();

	} else {
		$error = 1;
		$err[] = "Product could not be deleted.";
	}

}