<?php
require( 'display.class.php' );


class orders {

  private $id;
  private $product_id;
  private $firstname;
  private $lastname;
  private $email;
  private $phone;
  private $qty;
  private $address;
  private $date_created;
  private $last_updated;
  private $active;
  public $display;


  public function set_id( $id ) {
    $this->id = $id;
  }
  public function set_product_id( $product_id ) {
    $this->product_id = $product_id;
  }
  public function set_firstname( $firstname ) {
    $this->firstname = $firstname;
  }
  public function set_lastname( $lastname ) {
    $this->lastname = $lastname;
  }
  public function set_email( $email ) {
    $this->email = $email;
  }
  public function set_phone( $phone ) {
    $this->phone = $phone;
  }
  public function set_qty( $qty ) {
    $this->qty = $qty;
  }
  public function set_address( $address ) {
    $this->address = $address;
  }
  public function set_date_created( $date_created ) {
    $this->date_created = $date_created;
  }
  public function set_active( $active ) {
    $this->active = $active;
  }


  function __construct() {
    $this->last_updated = date( 'Y-m-d H:i:s' );
    $this->display = new display();
  }


  function addOrder() {
    $addProduct = $connect->prepare( 'INSERT into products (product_id , firstname, lastname, email, phone, qty, address, date_created, last_updated) VALUES (:product_id , :firstname, :lastname, :email, :phone, :qty, :address, :date_created, :last_updated)' );
    $addOrder->bindParam( ':product_id', $this->product_id, PDO::PARAM_INT );
    $addOrder->bindParam( ':firstname', $this->firstname, PDO::PARAM_STR );
    $addOrder->bindParam( ':lastname', $this->lastname, PDO::PARAM_STR );
    $addOrder->bindParam( ':email', $this->email, PDO::PARAM_STR );
    $addOrder->bindParam( ':phone', $this->phone, PDO::PARAM_STR );
    $addOrder->bindParam( ':qty', $this->qty, PDO::PARAM_INT );
    $addOrder->bindParam( ':address', $this->address, PDO::PARAM_STR );
    $addOrder->bindParam( ':date_created', $this->date_created, PDO::PARAM_STR );
    $addOrder->bindParam( ':last_updated', $this->date_updated, PDO::PARAM_STR );

    if ( $addOrder->execute() ) {
      $this->toJson( 'success', 'Successfully added' );
    } else {
      $this->toJson( 'error', 'We could add this product. Please try again.' );
    }
  }


  function deleteOrder() {
    $deleteOrder = $connect->prepare( 'DELETE * FROM orders WHERE id=:id' );
    $deleteOrder->bindParam( ':id', $this->id, PDO::PARAM_INT );
    $deleteOrder->execute();
  }


  function updateProduct() {
    $updateOrder = $connect->prepare( 'UPDATE products SET product_id=:product_id , firstname=:firstname, lastname=:lastname, email=:email, phone=:phone, qty=:qty, address=:address, last_updated=:last_updated WHERE id=:id' );
    $updateOrder->bindParam( ':product_id', $this->product_id, PDO::PARAM_INT );
    $updateOrder->bindParam( ':firstname', $this->firstname, PDO::PARAM_STR );
    $updateOrder->bindParam( ':lastname', $this->lastname, PDO::PARAM_STR );
    $updateOrder->bindParam( ':email', $this->email, PDO::PARAM_STR );
    $updateOrder->bindParam( ':phone', $this->phone, PDO::PARAM_STR );
    $updateOrder->bindParam( ':qty', $this->qty, PDO::PARAM_INT );
    $updateOrder->bindParam( ':address', $this->address, PDO::PARAM_STR );
    $updateOrder->bindParam( ':last_updated', $this->last_updated, PDO::PARAM_STR );
    $updateOrder->bindParam( ':id', $this->id, PDO::PARAM_STR );
    if ( $updateOrder->execute() ) {
      $this->toJson( 'success', 'Successfully updated' );
    } else {
      $this->toJson( 'error', 'We could update this order. Please try again.' );
    }
  }


  function listAllActiveOrders() {
    $listAllActiveOrders = $connect->prepare( 'SELECT * FROM products WHERE active=:active' );
    $listAllActiveOrders->bindParam( ':active', 1, PDO::PARAM_INT );
    $fetchOrders = $listAllActiveOrders->execute();
    $total = $fetchOrders->rowCount();
    if ( $total > 0 ) {
      $orders = $fetchOrders->fetchAll();
      $this->toJson( 'success', $orders );
    } else {
      $this->toJson( 'error', 'We could not load any orders' );
    }


  }

  function fetchOrderById() {
    $fetchOrderById = $connect->prepare( 'SELECT * FROM orders WHERE id=:id AND active=:active' );
    $fetchOrderById->bindParam( ':id', $this->id, PDO::PARAM_INT );
    $fetchOrderById->bindParam( ':active', $this->active, PDO::PARAM_INT );
    $allActiveOrders = $fetchOrderById->execute();
    $activeOrders = $allActiveOrders->fetch( PDO::FETCH_ASSOC );
    $this->toJson( 'success', $activeOrders );
  }


  function toJson( $status, $message ) {
    $res = array( 'status' => $status, 'message' => $message );
    $res_encode = json_encode( $res );
    echo $res_encode;
  }


}