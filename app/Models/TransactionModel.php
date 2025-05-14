<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['partner_reference_no', 'amount', 'va_number', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updateField = 'updated_at';
}
