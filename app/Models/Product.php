<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model
{
    protected $table = 'transaction_product';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_name', 'price', 'qris_url'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updateField = 'updated_at';
}
