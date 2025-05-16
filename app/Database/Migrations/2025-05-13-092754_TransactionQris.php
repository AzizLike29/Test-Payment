<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransactionQris extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'partner_reference_no' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'external_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'terminal_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'sub_merchant_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false,
            ],
            'currency' => [
                'type'       => 'VARCHAR',
                'constraint' => '3',
                'null'       => false,
            ],
            'validity_period' => [
                'type'       => 'DATETIME',
                'null'       => false,
            ],
            'is_static' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
            ],
            'timestamp' => [
                'type'       => 'DATETIME',
                'null'       => false,
            ],
            'response_data' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'success', 'failed'],
                'default'    => 'pending',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('transactions_qris');
    }

    public function down()
    {
        $this->forge->dropTable('transactions_qris');
    }
}
