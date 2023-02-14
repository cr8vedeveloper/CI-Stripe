<?php namespace App\Models;

use CodeIgniter\Model;

class TradesModel extends Model
{
    protected $table      = 'trades';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['user', 'entered_at', 'result', 'win', 'lose', 'currency', 'method', 'mode', 'direction', 'pips', 'bet', 'profit', 'evaluation'];

    protected $useTimestamps = false;

    protected $validationRules    = [
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
