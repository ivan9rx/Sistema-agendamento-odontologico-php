<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableServices extends Migration
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
            
            'nome' => [
                'type'           => 'VARCHAR',
                'constraint'     => 70,
            ],

            'active' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'default'        => 0,
                'comment'        => '0 = Não e 1= Sim'
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => null,
                'default'        => null
            ],

            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => null,
                'default'        => null
            ],


        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('nome');


        $this->forge->createTable('services');
    }

    public function down()
    {
        $this->forge->dropTable('services');
    }
}
