<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableSchedules extends Migration
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

            'dentista_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'comment'        => 'Identificador do dentista'
            ],

            'service_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'comment'        => 'Identificador do serviço'
            ],

            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'comment'        => 'Identificador do usuário logado'
            ],

            'finished' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'default'        => 0,
                'comment'        => 'indica se o agendamento esta finalizado, 0 = Não e 1= Sim'
            ],

            'canceled' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'default'        => 0,
                'comment'        => 'indica se o agendamento esta cancelado, 0 = Não e 1= Sim'
            ],

            'chosen_date' => [
                'type'           => 'DATETIME',
                'null'           => null,
                'default'        => null,
                'comment'        => 'indica quando o agendamento acontecerá'
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
        $this->forge->addForeignKey('dentista_id', 'dentistas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('service_id', 'services', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');


        $this->forge->createTable('schedules');
    }

    public function down()
    {
        $this->forge->dropTable('schedules');
    }
}
