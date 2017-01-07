<?php

class ProductsController {
     
    protected $name;
    protected $description;
    protected $status;

    /**
    * Escaping string for protection
    * @param  string  $input
    * @return string
    * @author anurag
    */
    function escape_strings ($input)
    {
        $base = new BaseModel();
        return $base->escape_string($input);
    }
    /**
    * Setting input fields from the source provided
    * @param  string  $source
    * @return none
    * @author anurag
    */
    function setInputFields ($source)
    {
        if(!array_key_exists('name', $source) || !array_key_exists('description', $source))
        {
            throw new InsufficientDataException(" name and description are required ");
        }
        // Status is not a compulsary field.
        if(array_key_exists('status', $source))
        {
            $this->status = $this->escape_strings($source['status']);
        }
        $this->name = $this->escape_strings($source['name']);
        $this->description = $this->escape_strings($source['description']);
    }

    /**
    * Editing the product
    * @param  int $productid
    * @return array
    * @author anurag
    */
    function edit ($productid)
    {
        if(!$productid)
        {
            throw new InsufficientDataException(" product id not sent ");
        }
        parse_str(file_get_contents("php://input"),$source);
        $this->setInputFields($source);
        $product = new Product;
        $status = $product->edit($productid, $this->name, $this->description, $this->status);
        return array("product" => $this->get($productid));
    }

    /**
    * Creating a product based on POST request 
    * @param  string  $username
    * @return product created 
    * @author anurag
    */
    function create ()
    {
        $source = $_POST;
        $this->setInputFields($source);
        $product = new Product;
        $productid = $product->createnew($this->name, $this->description, $this->status);
        if($productid)
        {
            http_response_code(201);
            return array("product" => $this->get($productid));
        }
    }

    /**
    * Getting all the products 
    * @return array
    * @author anurag
    */
    public function all ()
    {
        $product = new Product;
        if(array_key_exists("name", $_GET))
        {
            $name = $_GET['name'];
            return array("products" => $product->search($name));
        }
        return array("products" => $product->getall());
    }

    /**
    * Getting Product 
    * @param  string  $id
    * @return none
    * @throws ResourceNotFoundException
    * @author anurag
    */
    function get ($productid)
    {
        $product = new Product;
        $p = $product->get($productid);
        if(!$p)
        {
           throw new ResourceNotFoundException(" not found "); 
        }
        return array("product" => $p);
    }

    /**
    * Deleting the product 
    * @param  int $product
    * @throws ResourceNotFoundException
    * @author anurag
    */
    function delete ($productid)
    {
        if(!$productid)
        {
            throw new InsufficientDataException(" product id not supplied ");
        }
        $product = new Product;
        $p = $this->get($productid);
        if(!count($p))
        {
           throw new ResourceNotFoundException(" not found "); 
        }
        $result = $product->deleteproduct($productid);
        return array("status" => "done");
    }
 
    function __destruct () 
    {
    }
         
}
