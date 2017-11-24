<?php
class Product {
    public $id;
    public $productName;
    public $productPrice;

    public function __construct($reqBody){
        if($reqBody){
            $this->id = "";
            $this->productName = $reqBody['productName'];
            $this->productPrice = $reqBody['productPrice'];
        }
    }
}

?>