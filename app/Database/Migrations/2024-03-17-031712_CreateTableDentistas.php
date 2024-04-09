<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableDentistas extends Migration
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

            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            
            'phone' => [
                'type'           => 'VARCHAR',
                'constraint'     => 14,
                'comment'        => '(99) 99999-9999'
            ],

            'endereco' => [
                'type'           => 'VARCHAR',
                'constraint'     => 128,
                'comment'        => 'endereço do dentista'
            ],

            'servicos' => [
                'type'           => 'JSON',
                'null'           => true,
                'default'        => null,
                'comment'        => 'Contera os identificadores dos servicos'
            ],

            'starttime' => [
                'type'           => 'VARCHAR',
                'constraint'     => 6,
                'comment'        => 'Horario em que o dentista inicia o expediente. Este valor é usado para calcular e exibir os horarios disponíveis do dentista'
            ],

            'endtime' => [
                'type'           => 'VARCHAR',
                'constraint'     => 6,
                'comment'        => 'Horario em que o dentista finaliza o expediente. Este valor é usado para calcular e exibir os horarios disponíveis do dentista'
            ],

            'servicetime' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'comment'        => 'Tempo necessário para cada atendimento ex: 1 hour, 10 minutes, 2 hours'
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
        $this->forge->addKey('email');
        $this->forge->addKey('phone');

        $this->forge->createTable('dentistas');
    }

    public function down()
    {
        $this->forge->dropTable('dentistas');
    }
}
