<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        // Accounts Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'account_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'account_code' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'unique' => true
            ],
            'category' => [
                'type' => 'ENUM',
                'constraint' => ['asset', 'liability', 'equity', 'income', 'expense'],
                'null' => false
            ],
            'parent_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('parent_id');
        $this->forge->createTable('accounts');

        // Agents Table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'agent_no' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false
            ],
            'id_number' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP'
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('agents');

        // Agent-members table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'agent_no' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('agent_members');

        

    }

    public function down()
    {
        // Instead of dropping the table, just drop specific columns
        // $this->forge->dropColumn('your_table', ['column_name']);
    }
}
