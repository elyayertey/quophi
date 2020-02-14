<?php

class gallery {
    
  private $product_id
  private $title;
  private $description;
  private $photo_url;
  private $date_created;
  private $last_updated;
  private $active;
    

  public function set_product_id( $product_id ) {
    $this->product_id = $product_id;
  }

  public function set_title( $title ) {
    $this->title = $title;
  }
  public function set_description( $name ) {
    $this->description = $description;
  }
  public function set_photo_url( $photo_url ) {
    $this->photo_url = $photo_url;
  }
  public function set_date_created( $date_created ) {
    $this->date_created = $date_created;
  }
  public function set_active( $active ) {
    $this->active = $active;
  }


  function __construct() {
    $this->last_updated = date( 'Y-m-d H:i:s' );
  }


  function addPhoto() {
    $addPhoto = $connect->prepare( 'INSERT into gallery (product_id, title, description, photo_url, date_created, last_updated) VALUES (:product_id, :title, :description, :photo_url, :date_created, :last_updated)' );
    $addPhoto->bindParam( ':product_id', $this->product_id, PDO::PARAM_INT );
    $addPhoto->bindParam( ':title', $this->title, PDO::PARAM_STR );
    $addPhoto->bindParam( ':description', $this->description, PDO::PARAM_STR );
    $addPhoto->bindParam( ':photo_url', $this->photo_url, PDO::PARAM_INT );
    $addPhoto->bindParam( ':date_created', $this->date_created, PDO::PARAM_STR );
    $addPhoto->bindParam( ':last_updated', $this->date_updated, PDO::PARAM_STR );
    $addPhoto->bindParam( ':active', $this->active, PDO::PARAM_INT );
    if ( $addPhoto->execute() ) {
      $this->toJson( 'success', 'Successfully added' );
    } else {
      $this->toJson( 'error', 'We could add this photo. Please try again.' );
    }
  }


  function deletePhoto() {
    $deleteProduct = $connect->prepare( 'DELETE * FROM gallery WHERE id=:id' );
    $deleteProduct->bindParam( ':id', $this->id, PDO::PARAM_INT );
    $deleteProduct->execute();
  }


  function updatePhoto() {
    $updatePhoto = $connect->prepare( 'UPDATE gallery SET title=:title, description=:description, photo_url=:photo_url, last_updated=:last_updated WHERE id=:id' );
    $updatePhoto->bindParam( ':title', $this->title, PDO::PARAM_STR );
    $updatePhoto->bindParam( ':description', $this->description, PDO::PARAM_STR );
    $updatePhoto->bindParam( ':photo_url', $this->photo_url, PDO::PARAM_INT );
    $updatePhoto->bindParam( ':date_created', $this->date_created, PDO::PARAM_STR );
    $updatePhoto->bindParam( ':last_updated', $this->date_updated, PDO::PARAM_STR );
    $updatePhoto->bindParam( ':active', $this->active, PDO::PARAM_INT );
    $updatePhoto->bindParam( ':id', $this->id, PDO::PARAM_INT );
      
    if ( $updatePhoto->execute() ) {
      $this->toJson( 'success', 'Successfully updated' );
    } else {
      $this->toJson( 'error', 'We could update this photo. Please try again.' );
    }
  }


  function fetchPhotosById($product_id) {
    $fetchPhotoById = $connect->prepare( 'SELECT * FROM gallery WHERE active=:active AND product_id=:product_id' );
    $fetchPhotoById->bindParam( ':active', 1, PDO::PARAM_INT );
    $fetchPhotoById->bindParam( ':product_id', $priduct_id, PDO::PARAM_INT );
    $fetchPhotos = $fetchPhotoById->execute();
    $total = $fetchPhotos->rowCount();
    if ( $total > 0 ) {
      $photos = $fetchPhotos->fetchAll();
      $this->toJson( 'success', $photos );
    } else {
      $this->toJson( 'error', 'We could not load any photos' );
    }
  }

 
  function toJson( $status, $message ) {
    $res = array( 'status' => $status, 'message' => $message );
    $res_encode = json_encode( $res );
    echo $res_encode;
  }


}