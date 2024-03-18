<?php

if (!defined("ROOT")) die("direct script access denied");

class Model extends Database
{
  //protected $table = "";
  public function insert($data, $lastId = false)
  {
    //remove unwanted colums
    foreach ($data as $key => $value) {
      if (!in_array($key, $this->allowedColumns)) {
        unset($data[$key]);
      }
    }

    $keys = array_keys($data);

    $query = "INSERT INTO  " . $this->table;
    $query .= " (" . implode(",", $keys) . ") VALUES (:" . implode(",:", $keys) . ")";

    if ($lastId == false) {
      return $this->query($query, $data);
    } else {
      return $this->query($query, $data, $lastId);
    }
  }

  public function where($data, $order = 'desc', $limit = 10, $offset = 0)
  {
    $keys = array_keys($data);
    $query = "SELECT * FROM " . $this->table . " WHERE ";

    foreach ($keys as $key) {
      $query .= $key . "=:" . $key . "&&";
    }

    $query = trim($query, "&&");
    $query .= " ORDER BY id $order LIMIT $limit OFFSET $offset";
    $result = $this->query($query, $data);

    if (is_array($result)) {
      //run after select functions 
      if (property_exists($this, 'afterSelect')) {
        foreach ($this->afterSelect as $func) {
          $result = $this->$func($result);
        }
      }
      return $result;
    }

    return false;
  }

  public function findAll($order = 'desc', $limit = 100, $offset = 0)
  {

    $query = "SELECT * FROM " . $this->table . " ORDER BY id " . $order . " limit $limit offset $offset";

    $result = $this->query($query);

    if (is_array($result)) {
      //run after select functions 
      if (property_exists($this, 'afterSelect')) {
        foreach ($this->afterSelect as $func) {
          $result = $this->$func($result);
        }
      }
      return $result;
    }

    return false;
  }

  public function first($data, $order = 'desc')
  {
    $keys = array_keys($data);
    $query = "SELECT * FROM " . $this->table . " WHERE ";

    foreach ($keys as $key) {
      $query .= $key . "=:" . $key . " && ";
    }

    $query = trim($query, " && ");
    $query .= " ORDER BY id $order limit 1";
    $result = $this->query($query, $data);

    if ($result) {
      //run after select functions 
      if (property_exists($this, 'afterSelect')) {
        foreach ($this->afterSelect as $func) {
          $result = $this->$func($result);
        }
      }
      return $result[0];
    }
    return false;
  }

  public function update($id, $data)
  {
    //remove unwanted colums
    foreach ($data as $key => $value) {
      //if ($data[$key] == 'disabled' || $data[$key] == 0) continue;
      if (!in_array($key, $this->allowedColumns)) {
        // if ($data[$key] == 0) continue;
        unset($data[$key]);
      }
    }

    $keys = array_keys($data);
    //$query = "UPDATE users SET fitstname = :firstname, lastname = :lastname WHERE id = :id";
    $query = "UPDATE " . $this->table  . " SET ";

    foreach ($keys as $value) {
      $query .= $value . "=:" . $value . ",";
    }

    $query = trim($query, ",");
    $query .= " WHERE id = :id";

    $data['id'] = $id;
    return $this->query($query, $data);
  }

  public function delete($id): bool
  {

    $query = "DELETE FROM " . $this->table . " WHERE id = :id limit 1";
    $result = $this->query($query, ['id' => $id]);
    if ($result)
      return true;
    else
      return false;
  }
}
