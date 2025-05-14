<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionsQris extends Model
{
    protected $table = 'transactions_qris';
    protected $primaryKey = 'id';
    protected $allowedFields = ['external_id', 'amount', 'status', 'response'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';
}
