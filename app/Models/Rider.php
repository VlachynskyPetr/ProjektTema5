<?php

namespace App\Models;

use CodeIgniter\Model;

class Rider extends Model
{
    protected $table            = 'rider';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    
    // AKTUALIZOVÁNO: Zapnutí Soft Deletes podle zadání (záznamy se fyzicky nesmažou)
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    // AKTUALIZOVÁNO: Ochrana sloupců – definice polí, která lze přes aplikaci spravovat
    protected $allowedFields    = [
        'first_name', 
        'last_name', 
        'country', 
        'photo', 
        'date_of_birth', 
        'height', 
        'weight',
        'place_of_birth', // Pokud využíváš vazbu na tabulku lokací
        'description'     // Sloupec pro data z WYSIWYG editoru
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    // AKTUALIZOVÁNO: Zapnutí automatických timestampů pro ukládání dat operací v tabulce
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Sem se uloží timestamp při Soft Delete

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
