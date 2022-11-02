<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEvent extends Migration
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
            'event_name' => [
                'type' => 'VARCHAR',
                'constraint' => '32',
            ],
            'event_start_date' => [
                'type' => 'DATE'
            ],
            'event_end_date' => [
                'type' => 'DATE'
            ],
            'short_description' => [
                'type' => 'VARCHAR',
                'constraint' => '64',
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
            'img_url' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => true
            ],
            'event_type_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('event_type_id', 'event_type', 'id');
        $this->forge->createTable('event');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('event');
    }
}
