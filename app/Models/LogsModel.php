<?php namespace App\Models;

use CodeIgniter\Model;

class LogsModel extends Model
{
    protected $table      = 'logs';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        "action",
        "description",
        "performer",
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
