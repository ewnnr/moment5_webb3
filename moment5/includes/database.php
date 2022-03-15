<?php
class Database{
    //DB params
    private $host = 'localhost';
    private $db_name = 'courses';
    private $username= 'courses';
    private $password= '123456';
    private $db;
//DB connect
    public function connect(){
        $this->db=null;

        try{
            $this->db=new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, 
            $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            echo 'Connection error:' . $e->getMessage();
        }
        return $this->db;
    }
}




?>