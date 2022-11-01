<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventType extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'event_type_name' => [
                'type' => 'VARCHAR',
                'constraint' => '32',
                'unique' => true,
                'null' => false
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => '16',
                'unique' => true,
                'null' => false
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('event_type');
    }

    public function down()
    {
        $this->forge->dropTable('event_type');
    }
}
