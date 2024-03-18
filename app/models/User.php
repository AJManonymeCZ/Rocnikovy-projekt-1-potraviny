<?php

class User extends Model
{
  public $errors = [];
  protected $table = "users";

  protected $allowedColumns = [
    'id',
    'email',
    'firstname',
    'lastname',
    'password',
    'date',
    'image',
    'role_id',
    'gender',
    'banned',
    'token',
    'status',
  ];

  protected $afterSelect = [
    'get_role',
    'get_address',
  ];


  public function validate($data)
  {
    $this->errors = [];



    if (!empty($data)) {
      if (empty($data['firstname'])) {
        $this->errors['firstname'] = "Jméno je poviné";
      } else if (!preg_match("/^[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ]+$/", trim($data['firstname']))) {
        $this->errors['firstname'] = "Jméno se muže skládat jenom z písmen bez mezer";
      }

      if (empty($data['lastname'])) {
        $this->errors['lastname'] = "Přijmení je poviné";
      } else if (!preg_match("/^[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ]+$/", trim($data['lastname']))) {
        $this->errors['lastname'] = "Přijmení se muže skládat jenom z písmen bez mezer";
      }

      if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $this->errors['email'] = "Tento E-mail není validní";
      } else if ($this->where(['email' => $data['email']])) {
        $this->errors['email'] = "Tento E-mail již existuje";
      }

      if (empty($data['password'])) {
        $this->errors['password'] = "Heslo je povinné";
      }

      if (empty($data['confirm_password'])) {
        $this->errors['confirm_password'] = "Druhé heslo je povinné";
      }

      if ($data['password'] !== $data['confirm_password']) {
        $this->errors['password'] = "Hesla se neschdují";
      }

      if (empty($data['terms'])) {
        $this->errors['terms'] = "Prosím, přijměte podmínky";
      }

      if (empty($this->errors)) {
        return true;
      }
    }
    return false;
  }

  public function user_validate($data, $id)
  {
    $this->errors = [];

    //Alowed countries and gender
    $countries = ["czechia", "slovakia"];
    $gender = ["male", "female", "other"];
    if (!empty($data)) {
      if (empty($data['firstname'])) {
        $this->errors['firstname'] = "Jméno je povinné";
      } else if (!preg_match("/^[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ]+$/", trim($data['firstname']))) {
        $this->errors['firstname'] = "Jméno se muže skládat jenom z písmen bez mezer";
      }

      if (empty($data['lastname'])) {
        $this->errors['lastname'] = "Příjmení je povinné";
      } else if (!empty($data['lastname']) && !preg_match("/^[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ]+$/", trim($data['lastname']))) {
        $this->errors['lastname'] = "Přijmení se muže skládat jenom z písmen bez mezer";
      }

      if (empty($data['email'])) {
        $this->errors['email'] = "Email je povinný";
      } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $this->errors['email'] = "Tento E-mail není validní";
      } else if ($result = $this->where(['email' => $data['email']])) {
        foreach ($result as $value) {
          if ($value->id != $id) {
            $this->errors['email'] = "Tento E-mail již existuje";
          }
        }
      }

      if (!empty($data['gender']) && !in_array($data['gender'], $gender)) {
        $this->errors['gender'] = "Jeno tato pohlaví jsou povolená: " . implode(',', $gender);
      }


      if (!empty($data['country']) && !in_array($data['country'], $countries)) {
        $this->errors['country'] = "Jenom tyto země jsou povelený: " . implode(',', $countries);
      }

      if (empty($this->errors)) {
        return true;
      }
    }

    return false;
  }

  protected function get_role($data)
  {
    if (!empty($data[0]->role_id)) {
      foreach ($data as $key => $row) {
        $query = "SELECT role FROM role WHERE id = :id limit 1";
        $res = $this->query($query, ['id' => $row->role_id]);

        if ($res) {
          $data[$key]->role_name = $res[0]->role;
        }
      }
    }
    return $data;
  }

  protected function get_address($data)
  {
    if (!empty($data[0]->id)) {
      foreach ($data as $key => $row) {
        $query = "SELECT address.id AS 'address_id', country, postcode, street, town FROM address
                  JOIN user_address ON user_address.address_id=address.id
                  WHERE user_address.users_id =:user_id;";
        $res = $this->query($query, [':user_id' => $row->id]);

        if ($res) {
          $data[$key]->address = $res;
        }
      }
    }
    return $data;
  }
}
