<?php

if (!defined("ROOT")) die("direct script access denied");

class Database
{
  private function connect()
  {
    // $str = DBDRIVER . ":hostname=" . DBHOST . ";dbname=" . DBNAME;
    try {
      //code...    
      $con = new PDO(DBDRIVER . ":host=". DBHOST .";dbname=". DBNAME .";charset=" . DBCHARSET, DBUSER, DBPASS);
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $con;
    } catch (PDOException $e) {
      //echo $str;
      echo "Connection failed: " . $e->getMessage();
      die;
    }
    //return new PDO("mysql:host=db.mp.spse-net.cz;dbname=kalejafi19_1","kalejafi19", "bikejucatudo");
  }

  public function query($query, $data = [], $lastId = false)
  {
    $con = $this->connect();

    $stm = $con->prepare($query);
    if ($stm) {
      $check = $stm->execute($data);
      if ($lastId) return $con->lastInsertId();
      if (preg_match("/^INSERT|insert/", $query) || preg_match("/^UPDATE|update/", $query)) {
        if ($check) {
          return true;
        }
        return false;
      }
      if ($check) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
        if (is_array($result) && !empty($result)) {
          //run after select functions 
          if (property_exists($this, 'afterSelect')) {
            foreach ($this->afterSelect as $func) {
              $result = $this->$func($result);
            }
          }
          return $result;
        }
      }
    }


    return false;
  }

  public function exec($query, $data)
  {
  }

  public function createTables()
  {
    //users table
    $query = "
        
    ";
    $this->query($query);
  }
}
