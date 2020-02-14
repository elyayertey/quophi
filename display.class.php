<?php
class display {
    
  function toJson( $status, $message ) {
    $res = array( 'status' => $status, 'message' => $message );
    $res_encode = json_encode( $res );
    echo $res_encode;
  }
    
}
?>