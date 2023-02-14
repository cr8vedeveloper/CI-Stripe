<?php namespace App\Models;

use CodeIgniter\Model;

class CurrenciesModel extends Model
{
    protected $table      = 'currencies';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [];

    protected $useTimestamps = false;

    protected $validationRules    = [
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
