<?php namespace App\Models;

use CodeIgniter\Model;

class AccountsModel extends Model
{
    protected $table      = 'accounts';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['user', 'entered_at', 'amount', 'bonus', ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
