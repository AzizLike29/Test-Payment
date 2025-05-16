<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionsQris extends Model
{
    protected $table = 'transactions_qris';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'partner_reference_no',
        'external_id',
        'terminal_id',
        'sub_merchant_id',
        'amount',
        'currency',
        'validity_period',
        'is_static',
        'timestamp',
        'response_data',
        'status',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';
}
