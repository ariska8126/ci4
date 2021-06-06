<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'id_user';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    // protected $allowedFields = ['name', 'email'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getUser($email = false)
    {
        if ($email == false) {
            return $this->findAll();
        } else {
            return $this->where(['email' => $email])->first();
        }
    }

    public function getUserByUname($uname)
    {
        return $this->where(['username' => $uname])->first();
    }

    public function getIfExistEmsil()
    {

        $email = "ariskadianmusali@gmail.com";

        $query = $this->query('SELECT IF(EXISTS(SELECT * FROM `user` WHERE email = <?= $email ?> ),1,0)');
        $results = $query->getResult();
    }

    public function verifyEmail($email)
    {
        $builder = $this->db->table('user');
        $builder->select("username,password,email");
        $builder->where('email', $email);
        $result = $builder->get();

        if (count($result->getResultArray()) == 1) {
            return $result->getRowArray();
        } else {
            return false;
        }
    }

    public function updateAt($uuid)
    {
        $builder = $this->db->table('user');
        $builder->where('email', $uuid);
        $builder->update(['updated_at' => date('Y-m-d h:i:s')]);
        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePassword($username, $password)
    {
        $builder = $this->db->table('user');
        $builder->where('username', $username);
        $builder->update(['password' => $password]);
        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }
}
