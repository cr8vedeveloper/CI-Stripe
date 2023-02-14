<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    
    protected $subscripTbl= 'user_subscriptions'; 

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'email', 
        'fullname',
        'password', 
        'config', 
        'affiliate_id', 
        'affiliate_from', 
        'plan', 
        'contract_period',
        'stripe_email',
        'role',
        'expire_date',
        'active',
        'register_token',
        'confirmpassword_token',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [
        'email'    => ['label' => 'メールアドレス', 'rules' => 'required|valid_email'],
        'password' => ['label' => 'パスワード', 'rules' => 'required'],
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
