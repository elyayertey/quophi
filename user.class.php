<?php

class product {
    private $id;
    private $name;
    private $description;
    private $price;
    private $availability;
    private $quantity;
    private $requiredToShip;
    private $promo_ends;
    private $date_created;
    private $last_updated;
    private $active;
    
    
    function __construct(){
        $this->date_created = date('Y-m-d H:i:s');
    }
    
    
    function addProduct(){
        $addProduct = $connect->prepare('INSERT into products (name, description, price, availability, quantity, requiredToShip, promo_ends, date_created, last_updated) VALUES :name, :description, :price, :availability, :quantity, :requiredToShip, :promo_ends, :date_created, :last_updated');
        $addProduct->bindParam(':name', $this->name, PDO::PARAM_STR);
        $addProduct->bindParam(':description', $this->description, PDO::PARAM_STR);
        $addProduct->bindParam(':price', $this->price, PDO::PARAM_INT);
        $addProduct->bindParam(':availability', $this->availability, PDO::PARAM_INT);
        $addProduct->bindParam(':quantity', $this->quantity, PDO::PARAM_INT);
        $addProduct->bindParam(':requiredToShip', $this->requiredToShip, PDO::PARAM_INT);
        $addProduct->bindParam(':promo_ends', $this->promo_ends, PDO::PARAM_STR);
        $addProduct->bindParam(':date_created', $this->date_created, PDO::PARAM_STR);
        $addProduct->bindParam(':last_updated', $this->date_updated, PDO::PARAM_STR);
        $addProduct->bindParam(':active', $this->active, PDO::PARAM_INT);
        if($addProduct->execute()){
            $this->toJson('success', 'Successfully added'); 
        }else {
           $this->toJson('error', 'We could add this product. Please try again.');  
        }
    }
    
    
    
    function deleteProduct(){
        $deleteProduct = $connect->prepare('DELETE FROM products WHERE id=:id');
        $deleteProduct->bindParam(':id', $this->id, PDO::PARAM_INT);
        $deleteProduct->execute();
    }
    
    
    function updateProduct(){
        $updateProduct = $connect->prepare('UPDATE products SET name=:name, description=:description, price=:price, availability=:availability, quantity=:quantity, requiredToShip=:requiredToShip, promo_ends:promo_ends, last_updated=:last_updated WHERE id=:id');
        $updateProduct->bindParam(':name', $this->name, PDO::PARAM_STR);
        $updateProduct->bindParam(':description', $this->description, PDO::PARAM_STR);
        $updateProduct->bindParam(':price', $this->price, PDO::PARAM_INT);
        $updateProduct->bindParam(':availability', $this->availability, PDO::PARAM_INT);
        $updateProduct->bindParam(':quantity', $this->quantity, PDO::PARAM_INT);
        $updateProduct->bindParam(':requiredToShip', $this->requiredToShip, PDO::PARAM_INT);
        $updateProduct->bindParam(':promo_ends', $this->promo_ends, PDO::PARAM_STR);
        $updateProduct->bindParam(':last_updated', $this->date_updated, PDO::PARAM_STR);
        $updateProduct->bindParam(':id', $this->id, PDO::PARAM_STR);
        if($updateProduct->execute()){
            $this->toJson('success', 'Successfully updated'); 
        }else {
           $this->toJson('error', 'We could update this product. Please try again.');  
        }
    }
    
    
    
    function listAllActiveProducts(){
        $listAllActiveProducts = $connect->prepare('SELECT * FROM products WHERE active=:active');
        $listAllActiveProducts->bindParam(':active', 1, PDO::PARAM_INT);
        $fetchProducts = $listAllActiveProducts->execute(); 
        $total = $fetchProducts->rowCount();
        if($total > 0){ 
            $products = $fetchProducts->fetchAll();
            $this->toJson('success', $products);
        }
        else {
            $this->toJson('error', 'We could not load any products'); 
        }
       
        
        
    }
    
    
    function fetchProductById(){
        $fetchProductById = $connect->prepare('SELECT * FROM products WHERE id=:id AND active=:active');
        $fetchAllActiveProducts->bindParam(':active', 1, PDO::PARAM_INT);
        $allActiveProducts = $fetchAllActiveProducts->execute(); 
        $activeProducts = $allActiveProducts->fetch(PDO::FETCH_ASSOC);
        $this->toJson('success', $activeProducts);
    }
    
    
    function toJson($status, $message){
        $res = array('status'=>$status, 'message'=>$message);
        $res_encode = json_encode($res);
        echo $res_encode;
    }
        
        
    
}