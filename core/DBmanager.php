<?php  
 
class DBmanager {
    private PDO  $pdo ;
    private $type ; 
    private $host ; 
    private $dbname ; 
    private $username ;
    private $password ;  

public function __construct() {
    $configs = require_once __DIR__ . "/../config/database.php";
    $this->setparams($configs);
    $this->getconnection();
    
}
public function setparams(array $configs){
    extract($configs); 
    $this->type = $type ?? null ;
  $this->host = $host ?? null;
  $this->dbname = $dbname ?? null;
 $this->username = $username ?? null;
 $this->password = $password?? null ;

}

 public function getconnection () : PDO {
if(empty($this->pdo)){
    $this->pdo = new PDO($this->getdsn() , $this->username ,$this->password ) ;
    
}
 return $this->pdo ; 
}


public function query($sql, ...$params) {
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
} 

public function getdsn() : string {

  return  sprintf("mysql:host=%s;dbname=%s",$this->host , $this->dbname );

}

}

?>