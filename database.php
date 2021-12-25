<?php
namespace app;

use app\models\Product;
use PDO;

class Database
{
    public \PDO $pdo;
    public static Database $db;
    
    
    
    
    public  function __construct()
    {
        $this -> pdo = new PDO("mysql:host=localhost;port=3306;dbname=products_crud", "root", "");
        $this -> pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$db = $this;
    }

    public function getProducts($search)
    {
        if($search) 
        {
            $query = $this-> pdo -> prepare("SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC");
            $query->bindValue(":title", "%$search%");
        }
        else
        {
            $query = $this-> pdo -> prepare("SELECT * FROM products ORDER BY create_date DESC");
        }

        $query -> execute();
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getProductsById($id) 
    {
        $statement = $this -> pdo -> prepare("SELECT * FROM PRODUCTS WHERE id = :id ");
        $statement -> bindValue(":id", $id);
        $statement -> execute();
        
        return $statement -> fetch(PDO::FETCH_ASSOC);


    }


    public function createProduct(Product $product) 
    {
        $statement = $this -> pdo ->prepare("INSERT INTO products(title, image, description, price, create_date)        
        VALUE(:title, :image, :description, :price, :date)");               
        $statement->bindvalue(':title', $product -> title);
        $statement->bindvalue(':image', $product -> imagePath);
        $statement->bindvalue(':description',$product -> description);
        $statement->bindvalue(':price', $product -> price);
        $statement->bindvalue(':date', date("Y-m-d H:i:s"));
        $statement->execute();
    }

    public function updateProduct(Product $product)
    {

        $statement = $this -> pdo -> prepare("UPDATE products SET title = :title, image = :image, description = :description, price = :price WHERE id = :id");
        $statement->bindvalue(':title', $product -> title);
        $statement->bindvalue(':image', $product -> imagePath);
        $statement->bindvalue(':description',$product -> description);
        $statement->bindvalue(':price', $product -> price);
        $statement->bindValue(":id", $product -> id);
        $statement->execute();
    }




    public function deleteProduct($id) 
    {
        $statement =  $this -> pdo -> prepare("DELETE FROM products WHERE id = :id");
        $statement -> bindValue(":id", $id);
        $statement -> execute();
    }



















}































?>