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

    public function create($reqBody, $logger){
        $product = new Product($reqBody);
        // $logger->info(print_r($this->db, true));
        $this->db->insert('Product', [
                'productName' => "ancd", 
                'productPrice' => "123",
        ]);
        $data = (object)["message" => "Product created success!"];
        $result = [
            'status' => 200,
            'success' => true, 
            'data' => $data
        ];
        return $result;
    }

    // public function update($reqBody) {
    //         $this->db->update(
    //             $this->SchemaProduct, 
    //             [
    //                 "productName"         => $product->productName, 
    //                 "productPrice"        => $product->productPrice,
    //             ], 
    //             [
    //                 "id" => $reqBody["id"]
    //             ]
    //         ); 
    //         $data = (object)["message" => "Product created success!"];
    //         $result = [
    //             'status' => 200,
    //             'success' => true, 
    //             'data' => $data
    //         ];
    
    //         return $result;
        
    // }
}


?>