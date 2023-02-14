<?php namespace App\Models;

use CodeIgniter\Model;

class NotesModel extends Model
{
    protected $table      = 'notes';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'user', 'note', 'image'];

    protected $useTimestamps = false;

    protected $validationRules    = [
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
