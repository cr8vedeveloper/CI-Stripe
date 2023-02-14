<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsers extends Migration
{
	public function up()
	{
        $fields = [
            'role' => [
                'type' => 'INT',
                'default' => '1',
                // 0 - not Allow
                // 1 - Allow
                // 1023 - ADMIN
            ],
            'fullname' => [
               'type'           => 'VARCHAR',
               'constraint'     => '255',
            ],
        ];
        $this->forge->addColumn('users', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
