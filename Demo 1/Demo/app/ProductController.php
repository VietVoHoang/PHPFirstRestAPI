<?php

class ProductController {
    private $db; 
    private $SchemaProduct = "Product"; 
    
    public function __construct($inDB) {
        $this->db = $inDB; 
    }

    public function getAll(){
        $data = $this->db->select(
            "Product",
            "*"
        );
        $result = [
				'status' => 200, 
				'success' => true, 
				'data' => $data
			    ]; 
		return $result; 
    }
    public function getOne($reqBody){
        $id = $reqBody['id'];
        $data = $this->db->get(
            $this->SchemaProduct, 
            "*", 
            ["id" => $id]
        ); 
        $result = [
			'status' => 200, 
			'success' => true, 
			'data' => $data
			]; 
		return $result; 
    }
    public function delete($reqBody){
        $id = $reqBody['id'];
        $this->db->delete(
            $this->SchemaProduct, 
            ["id" => $id]
        ); 
        $data = (object)["message" => "Product deleted success!"];
        $result = [
			'status' => 200, 
			'success' => true, 
			'data' => $data
			]; 
		return $result; 
    }

    public function create($reqBody){
        $product = new Product($reqBody);
        $this->db->insert('Product', [
            'productName' => $product->productName, 
            'productPrice' => $product->productPrice,
        ]);
        $data = (object)["message" => "Product created success!"];
        $result = [
            'status' => 200,
            'success' => true, 
            'data' => $data
        ];
        return $result;
    }

    public function update($reqBody) {
        $product = new Product($reqBody);
        $this->db->update(
            $this->SchemaProduct, 
            [
                "productName"         => $product->productName, 
                "productPrice"        => $product->productPrice,
            ], 
            [
                "id" => $reqBody["id"]
            ]
        ); 
        $data = (object)["message" => "Product updated success!"];
        $result = [
            'status' => 200,
            'success' => true, 
            'data' => $data
        ];

        return $result;
        
    }
}


?>