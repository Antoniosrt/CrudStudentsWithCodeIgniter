<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Students extends Migration
{
    public function up()
    {
        {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'fullName' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255',
                ],
                'email' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'cpf' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'phone' => [
                    'type' => 'VARCHAR',
                    'constraint' => '255'
                ],
                'street'=>[
                    'type' => 'VARCHAR',
                    'constraint'=>'255'
                ],
                'city'=>[
                    'type' => 'VARCHAR',
                    'constraint'=>'255'
                ],
                'state'=>[
                    'type' => 'VARCHAR',
                    'constraint'=>'2'
                ],
                'cep'=>[
                    'type' => 'VARCHAR',
                    'constraint'=>'11'
                ],
                'address_number'=>[
                    'type' => 'VARCHAR',
                    'constraint'=>'255'
                ],
                'extra'=>[
                    'type' => 'VARCHAR',
                    'constraint'=>'255',
                    'null'=>true
                ],
                'photo'=>[
                    'type' => 'VARCHAR',
                    'constraint'=>'255'
                ],
                'created_at' => [
                    'type' => 'TIMESTAMP',
                    'default' => new RawSql('CURRENT_TIMESTAMP'),
                ],
                'updated_at' => [
                    'type' => 'TIMESTAMP',
                    'default' => new RawSql('CURRENT_TIMESTAMP'),
                ]
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('cpf');
            $this->forge->createTable('student');
        }
    }
    public function down()
    {
        $this->forge->dropTable('student');
    }
}
