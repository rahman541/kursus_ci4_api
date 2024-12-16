<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'auto_increment' => true, 'unsigned' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => false],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'mykad' => ['type' => 'VARCHAR', 'constraint' => 12, 'null' => false],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
            'img' => ['type' => 'VARCHAR', 'constraint' => 9, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => false],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}
